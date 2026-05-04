<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $query = Transaksi::with(['member', 'user', 'outlet']);

        if ($start_date && $end_date) {
            $query->whereBetween('tanggal', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
        }

        $transaksis = $query->latest()->get();

        return view('owner.laporan.index', compact('transaksis', 'start_date', 'end_date'));
    }

    public function exportPdf(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $query = Transaksi::with(['member', 'user', 'outlet']);

        if ($start_date && $end_date) {
            $query->whereBetween('tanggal', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
        }

        $transaksis = $query->latest()->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('owner.laporan.pdf', compact('transaksis', 'start_date', 'end_date'))
            ->setPaper('a4', 'landscape'); // Landscape agar tabel lebih lega

        return $pdf->download('Laporan-Laundry-' . ($start_date ?? 'Semua') . '.pdf');
    }
}
