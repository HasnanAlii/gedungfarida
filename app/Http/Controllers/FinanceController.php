<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;


class FinanceController extends Controller
{
   public function index(Request $request)
{
    $filter = $request->get('filter', 'all');
    $date = $request->get('date');

    $query = Finance::query();

    if ($filter === 'harian' && $date) {
        $query->whereDate('created_at', $date);
    } elseif ($filter === 'bulanan' && $date) {
        [$year, $month] = explode('-', $date);
        $query->whereYear('created_at', $year)
              ->whereMonth('created_at', $month);
    }

    $finances = $query->orderBy('created_at', 'desc')->paginate(10);

    return view('finances.index', compact('finances'));
}


    public function create()
    {
        return view('finances.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'nullable|string|in:income,expense',
            'transaction_type' => 'nullable|string|in:income,expense',
            'amount' => 'required',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
        ]);

        try {
            $type = $request->input('type');

            if (!$type) {
                return redirect()->back()
                    ->withInput()
                    ->with([
                        'message' => 'Tipe transaksi harus diisi (income atau expense).',
                        'alert-type' => 'error'
                    ]);
            }

            // normalisasi amount jika pengguna memasukkan format lokal (mis. "20.000")
            $rawAmount = (string) $request->input('amount');
            // hapus titik ribuan, ubah koma desimal ke titik
            $normalized = str_replace('.', '', $rawAmount);
            $normalized = str_replace(',', '.', $normalized);

            if (!is_numeric($normalized)) {
                return redirect()->back()->withInput()->with([
                    'message' => 'Jumlah tidak valid. Gunakan angka tanpa pemisah ribuan atau gunakan titik/koma untuk desimal.',
                    'alert-type' => 'error'
                ]);
            }

            $data = [
                'type' => $type,
                'amount' => $normalized,
                'description' => $request->input('description'),
                'date' => $request->input('date') ?? now(),
            ];

            Finance::create($data);

            return redirect()->route('finances.index')
                ->with([
                    'message' => 'Transaksi berhasil disimpan.',
                    'alert-type' => 'success'
                ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    public function exportPdf(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $date = $request->get('date');

        $query = Finance::query();

        // Terapkan filter sesuai pilihan
        if ($filter === 'harian' && $date) {
            $query->whereDate('created_at', $date);
        } elseif ($filter === 'bulanan' && $date) {
            [$year, $month] = explode('-', $date);
            $query->whereYear('created_at', $year)
                ->whereMonth('created_at', $month);
        }

        // Ambil data keuangan sesuai filter
        $finances = $query->orderBy('created_at', 'desc')->get();

        // Hitung total
        $totalIncome  = $finances->where('type', 'income')->sum('amount');
        $totalExpense = $finances->where('type', 'expense')->sum('amount');
        $totalSaldo   = $totalIncome - $totalExpense;
        $totalAmount  = $finances->sum('amount');

        // Generate PDF
        $pdf = Pdf::loadView('finances.pdf', compact(
            'finances', 'totalIncome', 'totalExpense', 'totalSaldo', 'totalAmount', 'filter', 'date'
        ));

        // Nama file menyesuaikan filter
        $filename = 'laporan-keuangan';
        if ($filter === 'harian' && $date) {
            $filename .= '-harian-' . $date;
        } elseif ($filter === 'bulanan' && $date) {
            $filename .= '-bulanan-' . str_replace('-', '_', $date);
        }
        $filename .= '.pdf';

        return $pdf->download($filename);
    }
        public function deleteOld()
        {
            try {
                $twoMonthsAgo = Carbon::now()->subMonths(2);

                $deleted = Finance::where('created_at', '<', $twoMonthsAgo)->delete();

                return redirect()
                    ->route('finances.index')
                    ->with([
                        'message' => "Berhasil menghapus {$deleted} data keuangan yang lebih dari 2 bulan.",
                        'alert-type' => 'success'
                    ]);
            } catch (\Exception $e) {
                return redirect()->back()->with([
                    'message' => 'Gagal menghapus data keuangan lama: ' . $e->getMessage(),
                    'alert-type' => 'error'
                ]);
            }
        }

}
