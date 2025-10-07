<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan Gedung Farida</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h1, h2 {
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h1 {
            font-size: 20px;
        }

        h2 {
            font-size: 16px;
            margin-bottom: 20px;
            color: #555;
        }

        /* Tabel utama */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f7b733;
            color: #fff;
            font-weight: bold;
        }

        td.description {
            text-align: left;
        }

        .badge-income {
            background-color: #d4edda;
            color: #155724;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
        }

        .badge-expense {
            background-color: #f8d7da;
            color: #721c24;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
        }

        tfoot td {
            font-weight: bold;
            background-color: #f1f1f1;
        }

        /* Summary boxes */
        .summary-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .summary-box {
            flex: 1 1 30%;
            margin: 5px;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .income-box {
            background-color: #e6f4ea;
            color: #256029;
        }

        .expense-box {
            background-color: #fdecea;
            color: #c53030;
        }

        .saldo-box {
            background-color: #fff4e5;
            color: #b75c00;
        }

        .summary-box .label {
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
        }

        .summary-box .value {
            font-size: 16px;
            font-weight: bold;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
            color: #777;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .summary-container {
                flex-direction: column;
            }
            .summary-box {
                flex: 1 1 100%;
            }
            th, td {
                font-size: 11px;
                padding: 6px;
            }
        }
    </style>
</head>
<body>
    <h1>Laporan Keuangan Gedung Farida</h1>
    <h2>Periode: {{ now()->format('d M Y') }}</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jumlah</th>
                <th>Tipe</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($finances as $index => $finance)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>Rp {{ number_format($finance->amount,0,',','.') }}</td>
                <td>
                    @if($finance->type == 'income')
                        <span class="badge-income">Pemasukan</span>
                    @else
                        <span class="badge-expense">Pengeluaran</span>
                    @endif
                </td>
                <td class="description">{{ $finance->description }}</td>
                <td>{{ $finance->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>Total</td>
                <td>Rp {{ number_format($totalAmount,0,',','.') }}</td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
    </table>

    <div class="summary-container">
        <div class="summary-box income-box">
            <span class="label">Total Pemasukan</span>
            <span class="value">Rp {{ number_format($totalIncome,0,',','.') }}</span>
        </div>
        <div class="summary-box expense-box">
            <span class="label">Total Pengeluaran</span>
            <span class="value">Rp {{ number_format($totalExpense,0,',','.') }}</span>
        </div>
        <div class="summary-box saldo-box">
            <span class="label">Total Dana</span>
            <span class="value">Rp {{ number_format($totalIncome - $totalExpense,0,',','.') }}</span>
        </div>
    </div>

    <div class="footer">
        Laporan ini dicetak oleh sistem manajemen Gedung Farida.
    </div>
</body>
</html>
