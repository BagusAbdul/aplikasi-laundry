@extends('layouts.main', ['title' => 'Admin Dashboard'])

@section('content')
<h1 class="text-2xl font-bold text-blue-800 mb-6">Overview Admin</h1>
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-600">
        <p class="text-gray-500 text-sm">Total Outlet</p>
        <p class="text-3xl font-bold text-gray-800">5</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-600">
        <p class="text-gray-500 text-sm">Total Pengguna</p>
        <p class="text-3xl font-bold text-gray-800">12</p>
    </div>
    </div>
@endsection
