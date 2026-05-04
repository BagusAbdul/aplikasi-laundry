@extends('layouts.main', ['title' => 'Edit Paket'])

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold mb-6">Edit Paket Cucian</h2>
    <form action="{{ route('admin.paket.update', $paket->id) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium">Outlet</label>
            <select name="outlet_id" class="w-full border rounded-lg p-2">
                @foreach($outlets as $o)
                    <option value="{{ $o->id }}" {{ $paket->outlet_id == $o->id ? 'selected' : '' }}>
                        {{ $o->nama_outlet }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium">Nama Paket</label>
            <input type="text" name="nama_paket" value="{{ $paket->nama_paket }}" class="w-full border rounded-lg p-2">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Jenis</label>
                <select name="jenis" class="w-full border rounded-lg p-2">
                    @foreach(['kiloan','selimut','bed_cover','kaos','lain'] as $j)
                        <option value="{{ $j }}" {{ $paket->jenis == $j ? 'selected' : '' }}>{{ ucfirst($j) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium">Harga</label>
                <input type="number" name="harga" value="{{ $paket->harga }}" class="w-full border rounded-lg p-2">
            </div>
        </div>

        <div class="flex gap-2 pt-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Update Paket</button>
            <a href="{{ route('admin.paket.index') }}" class="bg-gray-100 px-6 py-2 rounded-lg">Batal</a>
        </div>
    </form>
</div>
@endsection
