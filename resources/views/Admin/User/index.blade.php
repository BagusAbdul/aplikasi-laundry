@extends('layouts.main', ['title' => 'Manajemen Pengguna'])

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Daftar Pengguna</h2>
        <button onclick="document.getElementById('modalAdd').classList.remove('hidden')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            + Tambah Pengguna
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 border-l-4 border-green-500">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 border-l-4 border-red-500">{{ session('error') }}</div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="p-4 font-semibold text-gray-600">Nama</th>
                    <th class="p-4 font-semibold text-gray-600">Email</th>
                    <th class="p-4 font-semibold text-gray-600">Role</th>
                    <th class="p-4 font-semibold text-gray-600">Outlet</th>
                    <th class="p-4 font-semibold text-gray-600 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4 font-medium">{{ $u->name }}</td>
                    <td class="p-4 text-gray-600">{{ $u->email }}</td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded text-xs font-bold uppercase
                            {{ $u->role->nama_role == 'admin' ? 'bg-purple-100 text-purple-700' : ($u->role->nama_role == 'kasir' ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700') }}">
                            {{ $u->role->nama_role }}
                        </span>
                    </td>
                    <td class="p-4 text-gray-600">{{ $u->outlet->nama_outlet }}</td>
                    <td class="p-4 flex justify-center gap-2">
                        <a href="{{ route('admin.user.edit', $u->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('admin.user.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $users->links() }}</div>
</div>

<div id="modalAdd" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white p-6 rounded-xl w-full max-w-md shadow-xl max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-bold mb-4">Tambah Pengguna Baru</h3>
        <form action="{{ route('admin.user.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="text" name="name" placeholder="Nama Lengkap" class="w-full border rounded-lg p-2" required>
            <input type="email" name="email" placeholder="Email" class="w-full border rounded-lg p-2" required>
            <input type="password" name="password" placeholder="Password (min. 8 karakter)" class="w-full border rounded-lg p-2" required>

            <div>
                <label class="text-sm font-medium">Role</label>
                <select name="role_id" class="w-full border rounded-lg p-2" required>
                    @foreach($roles as $r)
                        <option value="{{ $r->id }}">{{ ucfirst($r->nama_role) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm font-medium">Outlet Penempatan</label>
                <select name="outlet_id" class="w-full border rounded-lg p-2" required>
                    @foreach($outlets as $o)
                        <option value="{{ $o->id }}">{{ $o->nama_outlet }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-2 pt-4">
                <button type="button" onclick="document.getElementById('modalAdd').classList.add('hidden')" class="text-gray-500">Batal</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
