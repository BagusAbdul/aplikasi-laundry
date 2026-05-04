<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pendapatan</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #1e40af; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #1e40af; font-size: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th { background: #1e40af; color: white; padding: 8px; border: 1px solid #1e40af; text-transform: uppercase; }
        .table td { padding: 8px; border: 1px solid #e5e7eb; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row { background: #f3f4f6; font-weight: bold; }
        .signature { margin-top: 50px; width: 100%; }
        .sig-box { float: right; width: 200px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENDAPATAN LAUNDRY</h1>
        <p>Periode: {{ $start_date ?? '...' }} s/d {{ $end_date ?? '...' }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Invoice</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Outlet</th>
                <th class="text-right">Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($transaksis as $index => $t)
                @php
                    $totalItem = $t->details->sum('subtotal');
                    $pajakDiskon = ($totalItem + $t->biaya_tambahan + $t->pajak) * ($t->diskon / 100);
                    $totalAkhir = ($totalItem + $t->biaya_tambahan + $t->pajak) - $pajakDiskon;
                    $grandTotal += $totalAkhir;
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center"><strong>{{ $t->kode_invoice }}</strong></td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($t->tgl)->format('d/m/Y') }}</td>
                    <td>{{ $t->member->nama }}</td>
                    <td>{{ $t->outlet->nama_outlet }}</td>
                    <td class="text-right">Rp {{ number_format($totalAkhir) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5" class="text-right">TOTAL PENDAPATAN</td>
                <td class="text-right">Rp {{ number_format($grandTotal) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="signature">
        <div class="sig-box">
            Dicetak pada: {{ date('d/m/Y') }}<br>
            Mengetahui, Owner<br><br><br><br>
            ( ________________ )
        </div>
    </div>
</body>
</html>
