@extends('layouts.main', ['title' => 'Manajemen Paket'])

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Daftar Paket Cucian</h2>
        <button onclick="document.getElementById('modalAdd').classList.remove('hidden')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            + Tambah Paket
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-4">Outlet</th>
                    <th class="p-4">Nama Paket</th>
                    <th class="p-4">Jenis</th>
                    <th class="p-4">Harga</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pakets as $p)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4">{{ $p->outlet->nama_outlet }}</td>
                    <td class="p-4 font-medium">{{ $p->nama_paket }}</td>
                    <td class="p-4"><span class="bg-gray-100 px-2 py-1 rounded text-xs uppercase">{{ $p->jenis }}</span></td>
                    <td class="p-4 text-blue-600 font-bold">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                    <td class="p-4 flex justify-center gap-2">
                        <a href="{{ route('admin.paket.edit', $p->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('admin.paket.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus paket?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $pakets->links() }}</div>
</div>

<div id="modalAdd" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white p-6 rounded-xl w-full max-w-md shadow-xl">
        <h3 class="text-lg font-bold mb-4">Tambah Paket Baru</h3>
        <form action="{{ route('admin.paket.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="text-sm font-medium">Outlet</label>
                <select name="outlet_id" class="w-full border rounded-lg p-2" required>
                    @foreach($outlets as $o)
                        <option value="{{ $o->id }}">{{ $o->nama_outlet }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-medium">Nama Paket</label>
                <input type="text" name="nama_paket" class="w-full border rounded-lg p-2" required>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium">Jenis</label>
                    <select name="jenis" class="w-full border rounded-lg p-2">
                        <option value="kiloan">Kiloan</option>
                        <option value="selimut">Selimut</option>
                        <option value="bed_cover">Bed Cover</option>
                        <option value="kaos">Kaos</option>
                        <option value="lain">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium">Harga</label>
                    <input type="number" name="harga" class="w-full border rounded-lg p-2" required>
                </div>
            </div>
            <div class="flex justify-end gap-2 pt-4">
                <button type="button" onclick="this.closest('#modalAdd').classList.add('hidden')" class="text-gray-500">Batal</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
