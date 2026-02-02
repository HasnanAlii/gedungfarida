<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\HallAvailability;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Menampilkan daftar pembayaran
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            // Admin: tampilkan semua pembayaran
            $payments = Payment::with('reservation.user')
                ->orderBy('payment_date', 'asc')
                ->paginate(10);

            return view('payments.index', compact('payments'));

        } else {
            // User biasa: tampilkan hanya pembayaran miliknya
            $payments = Payment::with('reservation.hall')
                ->whereHas('reservation', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->orderBy('payment_date', 'desc')
                ->paginate(10);

            return view('payments.index', compact('payments'));
        }
    }

    /**
     * Menampilkan form edit pembayaran
     */
    public function edit(Payment $payment)
    {
        $reservations = Reservation::all();
        return view('payments.edit', compact('payment', 'reservations'));
    }

    /**
     * Memperbarui data pembayaran
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'amount'         => 'required|numeric|min:0',
            'method'         => 'required|in:cash,transfer',
            'payment_date'   => 'required|date',
            'status'         => 'required|in:pending,paid,failed',
            'payment_proof'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:12288',
        ], [
            'reservation_id.required' => 'Reservasi harus dipilih.',
            'amount.required'         => 'Jumlah pembayaran wajib diisi.',
            'method.required'         => 'Metode pembayaran wajib dipilih.',
            'payment_date.required'   => 'Tanggal pembayaran wajib diisi.',
            'status.required'         => 'Status pembayaran wajib dipilih.',
            'payment_proof.mimes'     => 'Bukti pembayaran harus berupa file gambar atau PDF.',
        ]);

        $data = $request->all();

        // Upload bukti pembayaran (jika ada)
        if ($request->hasFile('payment_proof')) {

            // Hapus file lama jika ada
            if ($payment->payment_proof && Storage::disk('public')->exists('payment_proofs/' . $payment->payment_proof)) {
                Storage::disk('public')->delete('payment_proofs/' . $payment->payment_proof);
            }

            $file = $request->file('payment_proof');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Simpan file
            $file->storeAs('payment_proofs', $filename, 'public');

            $data['payment_proof'] = $filename;
        }

        $payment->update($data);

        return redirect()->route('payments.receipt', $payment->id)
            ->with([
                'message' => 'Data pembayaran berhasil diperbarui.',
                'alert-type' => 'success'
            ]);
    }

    /**
     * Menghapus pembayaran
     */
    public function destroy(Payment $payment)
    {
        // Hapus bukti pembayaran jika ada
        if ($payment->payment_proof && Storage::exists('public/payment_proofs/' . $payment->payment_proof)) {
            Storage::delete('public/payment_proofs/' . $payment->payment_proof);
        }

        $payment->delete();

        return redirect()->route('payments.index')->with([
            'message' => 'Data pembayaran berhasil dihapus.',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Menampilkan struk pembayaran
     */
    public function receipt(Payment $payment)
    {
        if (!$payment->reservation) {
            return redirect()->route('payments.index')
                ->with([
                    'message' => 'Pembayaran ini belum memiliki data reservasi!',
                    'alert-type' => 'error'
                ]);
        }

        return view('payments.receipt', compact('payment'));
    }

    /**
     * Konfirmasi pembayaran
     */
    public function konfirmasi(Payment $payment)
    {
        // Set pembayaran menjadi "paid"
        $payment->update(['status' => 'paid']);

        $reservation = $payment->reservation;
        $hall_id = $reservation->hall_id;

        // Set reservasi menjadi "completed"
        $reservation->update(['status' => 'completed']);

        // Masukkan data ke tabel keuangan
        Finance::create([
            'type'           => 'income',
            'description'    => 'Pembayaran untuk reservasi #' . $reservation->id,
            'amount'         => $payment->amount,
            'date'           => now(),
            'reservation_id' => $reservation->id,
        ]);

        // Tandai gedung sebagai tidak tersedia
        HallAvailability::create([
            'hall_id'        => $hall_id,
            'date'           => $reservation->event_start,
            'date_end'       => $reservation->event_end,
            'reservation_id' => $reservation->id,
            'status'         => 'unavailable',
            'note'           => 'Gedung digunakan oleh ' . $reservation->renter_name,
        ]);

        return redirect()->route('payments.index')
            ->with([
                'message' => 'Pembayaran berhasil dikonfirmasi.',
                'alert-type' => 'success'
            ]);
    }
}
