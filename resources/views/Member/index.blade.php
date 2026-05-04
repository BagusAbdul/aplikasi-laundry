@extends('layouts.main') {{-- Kita asumsikan ada layout utama nanti --}}
@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Registrasi Pelanggan</h2>
        <button onclick="toggleModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            + Tambah Pelanggan
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-hidden">
<table class="w-full text-left border-collapse">
    <thead class="bg-gray-50 border-b">
        <tr>
            <th class="p-4 font-semibold text-gray-600">Nama</th>
            <th class="p-4 font-semibold text-gray-600">Alamat</th>
            <th class="p-4 font-semibold text-gray-600">Gender</th>
            <th class="p-4 font-semibold text-gray-600">Telepon</th>
            <th class="p-4 font-semibold text-gray-600 text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($members as $m)
        <tr class="border-b hover:bg-gray-50">
            <td class="p-4">{{ $m->nama }}</td>
            <td class="p-4 text-gray-600">{{ $m->alamat }}</td>
            <td class="p-4">{{ $m->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            <td class="p-4">{{ $m->telepon }}</td>
            <td class="p-4 flex justify-center gap-2">
                <button onclick="editMember({{ $m->id }})" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
                    Edit
                </button>

                <form action="{{ route('kasir.member.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
        <div class="p-4">{{ $members->links() }}</div>
    </div>
</div>

<div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-8 rounded-xl w-full max-w-md shadow-2xl">
        <h3 class="text-xl font-bold mb-4">Data Pelanggan Baru</h3>
        <form action="{{ route('kasir.member.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium">Nama Lengkap</label>
                <input type="text" name="nama" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div>
                <label class="block text-sm font-medium">Alamat</label>
                <textarea name="alamat" class="w-full border rounded-lg p-2" required></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full border rounded-lg p-2">
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium">Telepon</label>
                <input type="text" name="telepon" class="w-full border rounded-lg p-2" required>
            </div>
            <div class="flex justify-end gap-2 pt-4">
                <button type="button" onclick="toggleModal()" class="text-gray-500 hover:underline">Batal</button>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal() {
        document.getElementById('modal').classList.toggle('hidden');
    }
</script>
@endsection
