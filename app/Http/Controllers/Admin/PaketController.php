<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Models\Outlet;
use App\Http\Requests\PaketRequest;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = Paket::with('outlet')->latest()->paginate(10);
        $outlets = Outlet::all(); // Untuk dropdown di modal tambah
        return view('admin.paket.index', compact('pakets', 'outlets'));
    }

    public function store(PaketRequest $request)
    {
        Paket::create($request->validated());
        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil ditambahkan!');
    }

    public function edit(Paket $paket)
    {
        $outlets = Outlet::all();
        return view('admin.paket.edit', compact('paket', 'outlets'));
    }

    public function update(PaketRequest $request, Paket $paket)
    {
        $paket->update($request->validated());
        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil diperbarui!');
    }

    public function destroy(Paket $paket)
    {
        if ($paket->details()->count() > 0) {
            return redirect()->back()->with('error', 'Paket tidak bisa dihapus karena sudah pernah digunakan dalam transaksi.');
        }
        $paket->delete();
        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil dihapus!');
    }
}
