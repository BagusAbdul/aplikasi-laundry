@extends('layouts.main', ['title' => 'Laporan Transaksi'])

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-xl font-bold text-gray-800 mb-6">Laporan Pendapatan</h2>

    <form action="{{ route('owner.laporan.index') }}" method="GET" class="bg-gray-50 p-4 rounded-lg mb-6 no-print">
        <div class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $start_date }}" class="border rounded-lg p-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ $end_date }}" class="border rounded-lg p-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Filter Laporan
                </button>
                @if($start_date && $end_date)
                    <button onclick="window.print()" type="button" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-black transition">
                        Cetak Laporan
                    </button>
                @endif
            </div>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="p-3 text-xs font-bold text-gray-600 uppercase">No</th>
                    <th class="p-3 text-xs font-bold text-gray-600 uppercase">Invoice</th>
                    <th class="p-3 text-xs font-bold text-gray-600 uppercase">Pelanggan</th>
                    <th class="p-3 text-xs font-bold text-gray-600 uppercase">Tanggal</th>
                    <th class="p-3 text-xs font-bold text-gray-600 uppercase text-right">Total Bayar</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @forelse($transaksis as $index => $t)
                    @php
                        $totalItem = $t->details->sum('subtotal');
                        $pajakDiskon = ($totalItem + $t->biaya_tambahan + $t->pajak) * ($t->diskon / 100);
                        $totalAkhir = ($totalItem + $t->biaya_tambahan + $t->pajak) - $pajakDiskon;
                        $grandTotal += $totalAkhir;
                    @endphp
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 text-sm">{{ $index + 1 }}</td>
                        <td class="p-3 text-sm font-bold text-blue-600">{{ $t->kode_invoice }}</td>
                        <td class="p-3 text-sm">{{ $t->member->nama }}</td>
                        <td class="p-3 text-sm">{{ \Carbon\Carbon::parse($t->tgl)->format('d/m/Y') }}</td>
                        <td class="p-3 text-sm text-right font-bold">Rp {{ number_format($totalAkhir) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-10 text-center text-gray-400 italic">Silakan pilih rentang tanggal laporan.</td>
                    </tr>
                @endforelse
            </tbody>
            @if($transaksis->count() > 0)
            <tfoot>
                <tr class="bg-blue-600 text-white font-bold">
                    <td colspan="4" class="p-3 text-right uppercase">Total Pendapatan</td>
                    <td class="p-3 text-right text-lg">Rp {{ number_format($grandTotal) }}</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>

<style>
    @media print {
        .no-print, nav, sidebar, footer { display: none !important; }
        body { padding: 0; margin: 0; }
        .bg-white { border: none !important; box-shadow: none !important; }
    }
</style>
@endsection
