@extends('layouts.main', ['title' => 'Edit Outlet'])

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white p-8 rounded-xl shadow-md">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.outlet.index') }}" class="text-blue-600 hover:underline mr-4">← Kembali</a>
            <h2 class="text-2xl font-bold text-gray-800">Edit Data Outlet</h2>
        </div>

        <form action="{{ route('admin.outlet.update', $outlet->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Outlet</label>
                <input type="text" name="nama_outlet" value="{{ old('nama_outlet', $outlet->nama_outlet) }}"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none @error('nama_outlet') border-red-500 @enderror">
                @error('nama_outlet') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="alamat" rows="3"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none @error('alamat') border-red-500 @enderror">{{ old('alamat', $outlet->alamat) }}</textarea>
                @error('alamat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                <input type="text" name="telepon" value="{{ old('telepon', $outlet->telepon) }}"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none @error('telepon') border-red-500 @enderror">
                @error('telepon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4 flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.outlet.index') }}" class="bg-gray-100 text-gray-600 px-6 py-2 rounded-lg hover:bg-gray-200 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
