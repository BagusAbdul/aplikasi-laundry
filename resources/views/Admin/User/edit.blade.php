@extends('layouts.main', ['title' => 'Edit Pengguna'])

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white p-8 rounded-xl shadow-md">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.user.index') }}" class="text-blue-600 hover:underline mr-4">← Kembali</a>
            <h2 class="text-2xl font-bold text-gray-800">Edit Data Pengguna</h2>
        </div>

        <form action="{{ route('admin.user.update', $user->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none @error('name') border-red-500 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none @error('email') border-red-500 @enderror">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru (Opsional)</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none @error('password') border-red-500 @enderror">
                <p class="text-gray-400 text-[10px] mt-1">*Minimal 8 karakter jika ingin diubah</p>
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hak Akses / Role</label>
                    <select name="role_id" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                {{ ucfirst($role->nama_role) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Outlet Penempatan</label>
                    <select name="outlet_id" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none">
                        @foreach($outlets as $outlet)
                            <option value="{{ $outlet->id }}" {{ $user->outlet_id == $outlet->id ? 'selected' : '' }}>
                                {{ $outlet->nama_outlet }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="pt-4 flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                    Update Pengguna
                </button>
                <a href="{{ route('admin.user.index') }}" class="bg-gray-100 text-gray-600 px-6 py-2 rounded-lg hover:bg-gray-200 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
