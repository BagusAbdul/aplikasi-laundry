<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $transaksi->kode_invoice }}</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .header {
            border-bottom: 2px solid #1e40af;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .brand {
            float: left;
            width: 50%;
        }
        .brand h1 {
            color: #1e40af;
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }
        .brand p {
            margin: 2px 0;
            color: #666;
        }
        .invoice-info {
            float: right;
            width: 40%;
            text-align: right;
        }
        .invoice-info h2 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .clear { clear: both; }

        .section-title {
            background: #f3f4f6;
            padding: 5px 10px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
            margin-bottom: 10px;
            color: #4b5563;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            vertical-align: top;
            width: 50%;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th {
            background-color: #1e40af;
            color: #ffffff;
            padding: 8px;
            text-align: left;
            text-transform: uppercase;
            font-size: 10px;
        }
        .items-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        .totals-table {
            width: 40%;
            float: right;
        }
        .totals-table td {
            padding: 5px 8px;
        }
        .grand-total {
            background: #1e40af;
            color: white;
            font-weight: bold;
        }

        .footer {
            margin-top: 50px;
            font-size: 10px;
            color: #666;
            border: 1px dashed #ccc;
            padding: 10px;
        }
        .signature {
            margin-top: 40px;
            width: 100%;
        }
        .sig-box {
            text-align: center;
            width: 50%;
            float: left;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="brand">
            <h1>{{ $transaksi->outlet->nama_outlet }}</h1>
            <p>{{ $transaksi->outlet->alamat }}</p>
            <p>Telp: {{ $transaksi->outlet->tlp }}</p>
        </div>
        <div class="invoice-info">
            <h2>INVOICE</h2>
            <p><strong>#{{ $transaksi->kode_invoice }}</strong></p>
            <p>Status: {{ strtoupper(str_replace('_', ' ', $transaksi->dibayar)) }}</p>
        </div>
        <div class="clear"></div>
    </div>

    <table class="info-table">
        <tr>
            <td>
                <div class="section-title">Pelanggan</div>
                <strong>{{ $transaksi->member->nama }}</strong><br>
                {{ $transaksi->member->tlp }}<br>
                {{ $transaksi->member->alamat }}
            </td>
            <td>
                <div class="section-title">Detail Order</div>
                Tgl Masuk: {{ \Carbon\Carbon::parse($transaksi->tgl)->format('d/m/Y H:i') }}<br>
                Batas Waktu: {{ \Carbon\Carbon::parse($transaksi->batas_waktu)->format('d/m/Y') }}<br>
                Kasir: {{ $transaksi->user->name }}
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th>Paket Laundry</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: right;">Harga</th>
                <th style="text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total_paket = 0; @endphp
            @foreach($transaksi->details as $detail)
            <tr>
                <td>{{ $detail->paket->nama_paket }}</td>
                <td style="text-align: center;">{{ $detail->qty }}</td>
                <td style="text-align: right;">{{ number_format($detail->paket->harga) }}</td>
                <td style="text-align: right;">{{ number_format($detail->subtotal) }}</td>
            </tr>
            @php $total_paket += $detail->subtotal; @endphp
            @endforeach
        </tbody>
    </table>

    <div style="width: 100%;">
        <table class="totals-table">
            <tr>
                <td>Subtotal</td>
                <td style="text-align: right;">{{ number_format($total_paket) }}</td>
            </tr>
            <tr>
                <td>Pajak</td>
                <td style="text-align: right;">+ {{ number_format($transaksi->pajak) }}</td>
            </tr>
            <tr>
                <td>Biaya Tambahan</td>
                <td style="text-align: right;">+ {{ number_format($transaksi->biaya_tambahan) }}</td>
            </tr>
            <tr>
                <td>Diskon ({{ $transaksi->diskon }}%)</td>
                @php $nilai_diskon = ($total_paket + $transaksi->biaya_tambahan + $transaksi->pajak) * ($transaksi->diskon / 100); @endphp
                <td style="text-align: right; color: #dc2626;">- {{ number_format($nilai_diskon) }}</td>
            </tr>
            <tr class="grand-total">
                <td>TOTAL</td>
                <td style="text-align: right;">Rp {{ number_format(($total_paket + $transaksi->biaya_tambahan + $transaksi->pajak) - $nilai_diskon) }}</td>
            </tr>
        </table>
        <div class="clear"></div>
    </div>

    <div class="footer">
        <strong>Syarat & Ketentuan:</strong><br>
        1. Pengambilan harus disertai nota ini.<br>
        2. Barang yang tidak diambil dalam 30 hari bukan tanggung jawab kami.<br>
        3. Komplain maksimal 1x24 jam setelah barang diambil.
    </div>

    <div class="signature">
        <div class="sig-box">
            Pelanggan,<br><br><br><br>
            ( {{ $transaksi->member->nama }} )
        </div>
        <div class="sig-box">
            Hormat Kami,<br><br><br><br>
            ( {{ auth()->user()->name }} )
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>
