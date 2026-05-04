@extends('layouts.main', ['title' => 'Manajemen Outlet'])

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Daftar Outlet</h2>
        <button onclick="document.getElementById('modalAdd').classList.remove('hidden')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            + Tambah Outlet
        </button>
    </div>

    <div class="mb-4">
        <form action="{{ route('admin.outlet.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau alamat..." class="border rounded-lg px-4 py-2 w-full md:w-64 focus:ring-2 focus:ring-blue-400 outline-none">
            <button type="submit" class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">Cari</button>
        </form>
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
                    <th class="p-4 font-semibold text-gray-600">Nama Outlet</th>
                    <th class="p-4 font-semibold text-gray-600">Alamat</th>
                    <th class="p-4 font-semibold text-gray-600">Telepon</th>
                    <th class="p-4 font-semibold text-gray-600 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($outlets as $o)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4 font-medium">{{ $o->nama_outlet }}</td>
                    <td class="p-4 text-gray-600">{{ $o->alamat }}</td>
                    <td class="p-4 text-gray-600">{{ $o->telepon }}</td>
                    <td class="p-4 flex justify-center gap-2">
                        <a href="{{ route('admin.outlet.edit', $o->id) }}" class="text-blue-600 hover:bg-blue-50 px-3 py-1 rounded-md border border-blue-200 transition">
                            Edit
                        </a>

                        <form action="{{ route('admin.outlet.index') }}/{{ $o->id }}" method="POST" onsubmit="return confirm('Hapus outlet ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:bg-red-50 p-2 rounded">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-500">Data tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $outlets->links() }}</div>
</div>

<div id="modalAdd" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white p-6 rounded-xl w-full max-w-md shadow-xl">
        <h3 class="text-lg font-bold mb-4">Tambah Outlet Baru</h3>
        <form action="{{ route('admin.outlet.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="text" name="nama_outlet" placeholder="Nama Outlet" class="w-full border rounded-lg p-2" required>
            <textarea name="alamat" placeholder="Alamat Lengkap" class="w-full border rounded-lg p-2" required></textarea>
            <input type="text" name="telepon" placeholder="No. Telepon" class="w-full border rounded-lg p-2" required>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="this.closest('#modalAdd').classList.add('hidden')" class="text-gray-500">Batal</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(data) {
        // Logika untuk menampilkan modal edit (bisa menggunakan modal terpisah atau update form action)
        // Demi efisiensi, saya sarankan buat satu modal edit statis di bawah atau gunakan JS untuk mengisi value.
        alert('Fitur Edit untuk: ' + data.nama_outlet + '\nAlamat: ' + data.alamat);
        // Tips: Untuk ujian, buatlah halaman edit.blade.php terpisah jika modal dirasa terlalu rumit.
    }
</script>
@endsection
