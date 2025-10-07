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
    public function index()
{
    $user = Auth::user();

    if ($user->hasRole('admin')) {
        // Admin: tampilkan semua pembayaran
        $payments = Payment::with('reservation.user')
            ->orderBy('payment_date', 'desc')
            ->paginate(10);

        return view('payments.index', compact('payments'));
    } else {
        // User: hanya tampilkan pembayaran miliknya
        $payments = Payment::with('reservation.hall')
            ->whereHas('reservation', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->orderBy('payment_date', 'desc')
            ->paginate(10);

        return view('payments.index', compact('payments'));
        }
    }

  

    public function edit(Payment $payment)
    {
        $reservations = Reservation::all();
        return view('payments.edit', compact('payment', 'reservations'));
    }

public function update(Request $request, Payment $payment)
{
    $request->validate([
        'reservation_id' => 'required|exists:reservations,id',
        'amount' => 'required|numeric|min:0',
        'method' => 'required|in:cash,transfer',
        'payment_date' => 'required|date',
        'status' => 'required|in:pending,paid,failed',
        'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:12288',
    ]);

    $data = $request->all();

    // Upload bukti pembayaran jika ada
    if ($request->hasFile('payment_proof')) {
        // Hapus file lama jika ada
        if ($payment->payment_proof && Storage::disk('public')->exists('payment_proofs/' . $payment->payment_proof)) {
            Storage::disk('public')->delete('payment_proofs/' . $payment->payment_proof);
        }

        $file = $request->file('payment_proof');
        $filename = time() . '_' . $file->getClientOriginalName();

        // Simpan file di disk public
        $file->storeAs('payment_proofs', $filename, 'public');

        $data['payment_proof'] = $filename;
    }

    $payment->update($data);

    // Redirect ke route receipt dengan parameter payment
    return redirect()->route('payments.receipt', $payment->id)
                     ->with([
                        'message' => 'Data pembayaran berhasil diperbarui.',
                        'alert-type' => 'success'
                     ]);
}



    public function destroy(Payment $payment)
    {
        // Hapus file bukti jika ada
        if ($payment->payment_proof && Storage::exists('public/payment_proofs/' . $payment->payment_proof)) {
            Storage::delete('public/payment_proofs/' . $payment->payment_proof);
        }

        $payment->delete();
        return redirect()->route('payments.index')->with([
                                                    'message' => 'Data pembayaran berhasil dihapus.',
                                                    'alert-type' => 'success'
                                                ]);

    }

public function receipt(Payment $payment)
{
    if (!$payment->reservation) {
        return redirect()->route('payments.index')
            ->with([
                'message' => 'Payment ini belum memiliki reservasi terkait!',
                'alert-type' => 'error'
            ]);
    }

    return view('payments.receipt', compact('payment'));
}




    public function konfirmasi(Payment $payment)
{
    // Ubah status pembayaran menjadi 'paid'
    $payment->update(['status' => 'paid']);

    // Ambil data reservasi dari payment
    $reservation = $payment->reservation;
    $hall_id = $reservation->hall_id;

    // Update status reservasi jadi 'completed'
    $reservation->update(['status' => 'completed']);

    // Tambahkan data ke tabel finances
    Finance::create([
        'type'           => 'income',
        'description'    => 'Payment for reservation #' . $reservation->id,
        'amount'         => $payment->amount,
        'date'           => now(),
        'reservation_id' => $reservation->id,
    ]);

    // Tandai hall sebagai unavailable
    HallAvailability::create([
        'hall_id'        => $hall_id,
        'date'           => $reservation->event_start,
        'reservation_id' => $reservation->id,
        'status'         => 'unavailable',
        'note'           => 'Dipakai reservasi #' . $reservation->id,
    ]);

    return redirect()->route('payments.index')
    ->with([
        'message' => 'Pembayaran berhasil dikonfirmasi.',
        'alert-type' => 'success'
    ]);

}



}
