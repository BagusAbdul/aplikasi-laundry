<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Member;
use App\Models\Paket;
use Illuminate\Http\Request;
use App\Http\Requests\TransaksiRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['member', 'user', 'outlet'])->latest()->paginate(10);
        return view('kasir.transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $members = Member::all();
        $pakets = Paket::where('outlet_id', auth()->user()->outlet_id)->get();
        return view('kasir.transaksi.create', compact('members', 'pakets'));
    }

    public function store(TransaksiRequest $request)
    {
        // Debug: Cek apakah data items benar-benar masuk
        // dd($request->all());

        DB::beginTransaction();
        try {
            $invoice = 'INV/' . date('Ymd') . '/' . auth()->id() . '/' . strtoupper(bin2hex(random_bytes(2)));
            $batas_waktu = \Carbon\Carbon::now()->addDays(3);

            // Pastikan outlet_id ada
            $outlet_id = auth()->user()->outlet_id;
            if(!$outlet_id) {
                throw new \Exception("User anda belum terhubung ke outlet manapun.");
            }

            $transaksi = Transaksi::create([
                'outlet_id' => $outlet_id,
                'kode_invoice' => $invoice,
                'member_id' => $request->member_id,
                'tanggal' => \Carbon\Carbon::now(),
                'batas_waktu' => $batas_waktu,
                'biaya_tambahan' => $request->biaya_tambahan ?? 0,
                'diskon' => $request->diskon ?? 0,
                'pajak' => $request->pajak ?? 0,
                'status' => 'baru',
                'dibayar' => 'belum_dibayar',
                'user_id' => auth()->id(),
                // 'keterangan' => $request->keterangan
            ]);

            foreach ($request->items as $item) {
                $paket = Paket::findOrFail($item['paket_id']);
                $subtotal = $paket->harga * $item['qty'];
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'paket_id' => $item['paket_id'],
                    'qty' => $item['qty'],
                    'subtotal'     => $subtotal,
                    'keterangan' => null
                ]);
            }

            DB::commit();
            return redirect()->route('kasir.transaksi.index')->with('success', 'Transaksi Berhasil Simpan!');
        } catch (\Exception $e) {
            DB::rollback();
            // Ini akan membantu kita melihat error database yang sebenarnya
            return back()->withInput()->with('error', 'Gagal Simpan: ' . $e->getMessage());
        }
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['member', 'outlet', 'user', 'details.paket']);
        return view('kasir.transaksi.show', compact('transaksi'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'status' => 'required|in:baru,proses,selesai,diambil',
            'dibayar' => 'required|in:baru,belum_dibayar,dibayar'
        ]);

        // Jika status diubah jadi 'dibayar', catat tanggal bayarnya
        $updateData = [
            'status' => $request->status,
            'dibayar' => $request->dibayar,
        ];

        if ($request->dibayar == 'dibayar' && $transaksi->dibayar == 'belum_dibayar') {
            $updateData['tanggal_bayar'] = now();
        }

        $transaksi->update($updateData);

        return back()->with('success', 'Status transaksi berhasil diperbarui!');
    }

    public function exportPdf(Transaksi $transaksi)
{
    // Load view dan kirim data transaksi
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('kasir.transaksi.pdf', compact('transaksi'));

    // Bersihkan nama file: ganti / atau \ menjadi -
    $fileName = str_replace(['/', '\\'], '-', $transaksi->kode_invoice);

    // Download dengan nama yang sudah dibersihkan
    return $pdf->download('Invoice-' . $fileName . '.pdf');
}
}
