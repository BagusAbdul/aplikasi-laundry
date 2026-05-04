@extends('layouts.main', ['title' => 'Detail Transaksi'])

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('kasir.transaksi.index') }}" class="bg-gray-100 p-2 rounded-full hover:bg-gray-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-7-7a1 1 0 010-1.414l7-7a1 1 0 011.414 1.414L4.414 9H17a1 1 0 110 2H4.414l5.293 5.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $transaksi->kode_invoice }}</h2>
                <p class="text-sm text-gray-500 italic">Invoice Transaksi Laundry</p>
            </div>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('kasir.transaksi.pdf', $transaksi->id) }}" class="bg-red-600 text-white px-5 py-2.5 rounded-lg font-bold hover:bg-red-700 shadow-md transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Cetak Invoice
            </a>
        </div>
    </div>

    @if(session('success'))
        <div id="notif" class="bg-green-500 text-white p-4 rounded-xl shadow-lg mb-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="hover:text-green-200">×</button>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-4">Detail Pelanggan</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm font-bold text-gray-800">{{ $transaksi->member->nama }}</p>
                        <p class="text-xs text-gray-500">{{ $transaksi->member->tlp }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $transaksi->member->alamat }}</p>
                    </div>
                    <div class="pt-3 border-t">
                        <p class="text-[10px] text-gray-400 uppercase font-bold">Outlet</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $transaksi->outlet->nama_outlet }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-blue-900 p-6 rounded-xl shadow-lg text-white">
                <h3 class="font-bold mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-300" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                    </svg>
                    Update Status
                </h3>
                <form action="{{ route('kasir.transaksi.update', $transaksi->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="text-[10px] text-blue-200 uppercase font-bold">Pengerjaan</label>
                        <select name="status" class="w-full bg-blue-800 border-blue-700 rounded-lg p-2 text-sm mt-1 focus:ring-2 focus:ring-blue-400 outline-none">
                            <option value="baru" {{ $transaksi->status == 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="proses" {{ $transaksi->status == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ $transaksi->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="diambil" {{ $transaksi->status == 'diambil' ? 'selected' : '' }}>Diambil</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] text-blue-200 uppercase font-bold">Pembayaran</label>
                        <select name="dibayar" class="w-full bg-blue-800 border-blue-700 rounded-lg p-2 text-sm mt-1 focus:ring-2 focus:ring-blue-400 outline-none">
                            <option value="belum_dibayar" {{ $transaksi->dibayar == 'belum_dibayar' ? 'selected' : '' }}>Belum Bayar</option>
                            <option value="dibayar" {{ $transaksi->dibayar == 'dibayar' ? 'selected' : '' }}>Sudah Bayar</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-400 text-white py-2 rounded-lg font-bold transition shadow-md">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="p-4 text-xs font-bold text-gray-500 uppercase">Item Paket</th>
                            <th class="p-4 text-xs font-bold text-gray-500 uppercase text-center">Qty</th>
                            <th class="p-4 text-xs font-bold text-gray-500 uppercase text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @php $total_paket = 0; @endphp
                        @foreach($transaksi->details as $detail)
                        <tr>
                            <td class="p-4 text-sm">
                                <span class="font-bold text-gray-800 block">{{ $detail->paket->nama_paket }}</span>
                                <span class="text-xs text-gray-400">Rp {{ number_format($detail->paket->harga) }} / {{ $detail->paket->jenis == 'kiloan' ? 'kg' : 'pcs' }}</span>
                            </td>
                            <td class="p-4 text-sm text-center font-semibold text-gray-600">{{ $detail->qty }}</td>
                            <td class="p-4 text-sm text-right font-bold text-gray-800">Rp {{ number_format($detail->subtotal) }}</td>
                        </tr>
                        @php $total_paket += $detail->subtotal; @endphp
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50/50">
                        <tr class="text-sm">
                            <td colspan="2" class="p-3 text-right text-gray-500 font-medium">Subtotal Paket</td>
                            <td class="p-3 text-right font-semibold">Rp {{ number_format($total_paket) }}</td>
                        </tr>
                        <tr class="text-sm">
                            <td colspan="2" class="p-3 text-right text-gray-500 font-medium">Biaya Tambahan</td>
                            <td class="p-3 text-right text-blue-600">+ Rp {{ number_format($transaksi->biaya_tambahan) }}</td>
                        </tr>
                        <tr class="text-sm">
                            <td colspan="2" class="p-3 text-right text-gray-500 font-medium">Pajak</td>
                            <td class="p-3 text-right text-blue-600">+ Rp {{ number_format($transaksi->pajak) }}</td>
                        </tr>
                        <tr class="text-sm">
                            <td colspan="2" class="p-3 text-right text-gray-500 font-medium">Diskon ({{ $transaksi->diskon }}%)</td>
                            @php $nilai_diskon = ($total_paket + $transaksi->biaya_tambahan + $transaksi->pajak) * ($transaksi->diskon / 100); @endphp
                            <td class="p-3 text-right text-red-500 font-semibold">- Rp {{ number_format($nilai_diskon) }}</td>
                        </tr>
                        <tr class="bg-blue-600 text-white">
                            <td colspan="2" class="p-4 text-right text-sm font-bold uppercase">Total Akhir</td>
                            <td class="p-4 text-right text-xl font-black">
                                Rp {{ number_format(($total_paket + $transaksi->biaya_tambahan + $transaksi->pajak) - $nilai_diskon) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if($transaksi->keterangan)
            <div class="mt-4 p-4 bg-yellow-50 border border-yellow-100 rounded-xl">
                <p class="text-[10px] font-black text-yellow-600 uppercase mb-1">Catatan Khusus:</p>
                <p class="text-sm text-yellow-800 leading-relaxed italic">"{{ $transaksi->keterangan }}"</p>
            </div>
            @endif

            <div class="mt-6 flex justify-between items-center text-[11px] text-gray-400 uppercase tracking-widest font-bold">
                <span>Dibuat: {{ \Carbon\Carbon::parse($transaksi->tgl)->format('d/m/Y H:i') }}</span>
                <span>Petugas: {{ $transaksi->user->name }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
