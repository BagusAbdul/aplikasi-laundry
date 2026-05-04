@extends('layouts.main', ['title' => 'Owner Dashboard'])

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Laporan Ringkasan Bisnis</h1>
    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded uppercase">Mode View-Only</span>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border-b-4 border-indigo-500">
        <div class="flex items-center">
            <div class="p-3 bg-indigo-100 rounded-full text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm italic">Pendapatan Bulan Ini</p>
                <p class="text-2xl font-bold text-gray-800">Rp 15.250.000</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border-b-4 border-green-500">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-full text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm italic">Total Transaksi</p>
                <p class="text-2xl font-bold text-gray-800">245</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border-b-4 border-orange-500">
        <div class="flex items-center">
            <div class="p-3 bg-orange-100 rounded-full text-orange-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm italic">Pelanggan Aktif</p>
                <p class="text-2xl font-bold text-gray-800">89</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white p-6 rounded-xl shadow-sm">
    <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Aktivitas Terbaru Seluruh Outlet</h3>
    <div class="space-y-4">
        <div class="flex justify-between items-center text-sm border-l-2 border-blue-500 pl-3">
            <div>
                <p class="font-semibold">Transaksi Baru #INV-20260504</p>
                <p class="text-gray-500">Outlet Pusat • Rp 45.000</p>
            </div>
            <span class="text-xs text-gray-400">2 menit yang lalu</span>
        </div>
    </div>
    <div class="mt-6">
        <a href="#" class="block text-center bg-gray-100 text-gray-600 py-2 rounded-lg hover:bg-gray-200 font-medium transition">
            Lihat Laporan Lengkap
        </a>
    </div>
</div>
@endsection
