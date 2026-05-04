@extends('layouts.main', ['title' => 'Entri Transaksi Baru'])

@section('content')
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
        <ul class="list-disc ml-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('error'))
    <div class="bg-orange-100 text-orange-700 p-4 rounded-lg mb-6 border-l-4 border-orange-500">
        {{ session('error') }}
    </div>
@endif

<form action="{{ route('kasir.transaksi.store') }}" method="POST">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border">
                <h3 class="font-bold text-lg mb-4 text-gray-800">Informasi Utama</h3>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium">Pilih Member</label>
                        <select name="member_id" class="w-full border rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-blue-500 outline-none" required>
                            <option value="">-- Pilih Member --</option>
                            @foreach($members as $m)
                                <option value="{{ $m->id }}">{{ $m->nama }} ({{ $m->tlp }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Biaya Tambahan (Rp)</label>
                        <input type="number" name="biaya_tambahan" value="0" class="w-full border rounded-lg p-2.5 mt-1">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium">Diskon (%)</label>
                            <input type="number" name="diskon" value="0" max="100" class="w-full border rounded-lg p-2.5 mt-1">
                        </div>
                        <div>
                            <label class="text-sm font-medium">Pajak (Rp)</label>
                            <input type="number" name="pajak" value="0" class="w-full border rounded-lg p-2.5 mt-1">
                        </div>
                    </div>

                    {{-- <div>
                        <label class="text-sm font-medium">Keterangan</label>
                        <textarea name="keterangan" class="w-full border rounded-lg p-2.5 mt-1" rows="3"></textarea>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg text-gray-800">Item Cucian</h3>
                    <button type="button" id="add-item" class="text-blue-600 font-semibold hover:text-blue-800">+ Tambah Baris</button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full" id="items-table">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="p-3 text-left text-sm">Paket Laundry</th>
                            <th class="p-3 text-left text-sm" width="150px">Harga Satuan</th>
                            <th class="p-3 text-left text-sm" width="100px">Qty</th>
                            <th class="p-3 text-left text-sm" width="150px">Subtotal</th>
                            <th class="p-3 text-center text-sm" width="50px"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr class="item-row">
                            <td class="p-3">
                                <select name="items[0][paket_id]" class="paket-select w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                                    <option value="" data-harga="0">-- Pilih Paket --</option>
                                    @foreach($pakets as $p)
                                        <option value="{{ $p->id }}" data-harga="{{ $p->harga }}">{{ $p->nama_paket }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-3">
                                <input type="text" class="harga-satuan w-full bg-gray-50 border rounded-lg p-2" readonly value="0">
                            </td>
                            <td class="p-3">
                                <input type="number" name="items[0][qty]" value="1" min="1" class="qty-input w-full border rounded-lg p-2" required>
                            </td>
                            <td class="p-3">
                                <input type="text" class="row-subtotal w-full bg-gray-50 border rounded-lg p-2" readonly value="0">
                            </td>
                            <td class="p-3 text-center"></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50 font-bold">
                            <td colspan="3" class="p-3 text-right">Total Keseluruhan:</td>
                            <td class="p-3">
                                <span id="total-semua">Rp 0</span>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <a href="{{ route('kasir.transaksi.index') }}" class="px-6 py-2.5 text-gray-600 font-medium">Batal</a>
                    <button type="submit" class="bg-blue-600 text-white px-8 py-2.5 rounded-lg font-bold hover:bg-blue-700 transition">
                        Simpan Transaksi
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    let rowIndex = 1;

    // Fungsi untuk menghitung subtotal per baris dan total keseluruhan
    function hitungTotal() {
        let totalKeseluruhan = 0;

        document.querySelectorAll('.item-row').forEach(row => {
            const selectPaket = row.querySelector('.paket-select');
            const qtyInput = row.querySelector('.qty-input');
            const hargaSatuanInput = row.querySelector('.harga-satuan');
            const rowSubtotalInput = row.querySelector('.row-subtotal');

            const harga = parseFloat(selectPaket.options[selectPaket.selectedIndex].getAttribute('data-harga')) || 0;
            const qty = parseFloat(qtyInput.value) || 0;
            const subtotal = harga * qty;

            hargaSatuanInput.value = new Intl.NumberFormat('id-ID').format(harga);
            rowSubtotalInput.value = new Intl.NumberFormat('id-ID').format(subtotal);

            totalKeseluruhan += subtotal;
        });

        document.getElementById('total-semua').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalKeseluruhan);
    }

    // Event Listener untuk tambah baris
    document.getElementById('add-item').addEventListener('click', function() {
        let table = document.getElementById('items-table').getElementsByTagName('tbody')[0];
        let newRow = table.insertRow();
        newRow.className = "item-row";
        newRow.innerHTML = `
            <td class="p-3">
                <select name="items[${rowIndex}][paket_id]" class="paket-select w-full border rounded-lg p-2" required>
                    <option value="" data-harga="0">-- Pilih Paket --</option>
                    @foreach($pakets as $p)
                        <option value="{{ $p->id }}" data-harga="{{ $p->harga }}">{{ $p->nama_paket }}</option>
                    @endforeach
                </select>
            </td>
            <td class="p-3">
                <input type="text" class="harga-satuan w-full bg-gray-50 border rounded-lg p-2" readonly value="0">
            </td>
            <td class="p-3">
                <input type="number" name="items[${rowIndex}][qty]" value="1" min="1" class="qty-input w-full border rounded-lg p-2" required>
            </td>
            <td class="p-3">
                <input type="text" class="row-subtotal w-full bg-gray-50 border rounded-lg p-2" readonly value="0">
            </td>
            <td class="p-3 text-center">
                <button type="button" class="text-red-500 font-bold remove-item">×</button>
            </td>
        `;
        rowIndex++;
    });

    // Event Listener untuk perubahan input (Delegation)
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('paket-select') || e.target.classList.contains('qty-input')) {
            hitungTotal();
        }
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('tr').remove();
            hitungTotal();
        }
    });
</script>
@endsection
