@extends('layouts.main', ['title' => 'Riwayat Transaksi'])

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Daftar Transaksi</h2>
            <p class="text-sm text-gray-500">Kelola data transaksi dan status pengerjaan laundry.</p>
        </div>
        <a href="{{ route('kasir.transaksi.create') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Transaksi Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 border-l-4 border-green-500">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="p-4 font-semibold text-gray-600 text-sm">Invoice</th>
                    <th class="p-4 font-semibold text-gray-600 text-sm">Pelanggan</th>
                    <th class="p-4 font-semibold text-gray-600 text-sm">Tanggal</th>
                    <th class="p-4 font-semibold text-gray-600 text-sm">Batas Waktu</th>
                    <th class="p-4 font-semibold text-gray-600 text-sm">Status Order</th>
                    <th class="p-4 font-semibold text-gray-600 text-sm">Pembayaran</th>
                    <th class="p-4 font-semibold text-gray-600 text-sm text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($transaksis as $t)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 font-bold text-blue-600 text-sm">{{ $t->kode_invoice }}</td>
                    <td class="p-4 text-sm">
                        <div class="font-medium text-gray-800">{{ $t->member->nama }}</div>
                        <div class="text-xs text-gray-500">{{ $t->member->tlp }}</div>
                    </td>
                    <td class="p-4 text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($t->tgl)->format('d/m/Y H:i') }}
                    </td>
                    <td class="p-4 text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($t->batas_waktu)->format('d/m/Y') }}
                    </td>
                    <td class="p-4">
                        @php
                            $statusColor = [
                                'baru' => 'bg-blue-100 text-blue-700',
                                'proses' => 'bg-yellow-100 text-yellow-700',
                                'selesai' => 'bg-indigo-100 text-indigo-700',
                                'diambil' => 'bg-green-100 text-green-700',
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $statusColor[$t->status] }}">
                            {{ $t->status }}
                        </span>
                    </td>
                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $t->dibayar == 'dibayar' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ str_replace('_', ' ', $t->dibayar) }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('kasir.transaksi.show', $t->id) }}" class="p-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition" title="Detail">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-500">Belum ada data transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $transaksis->links() }}
    </div>
</div>
@endsection
