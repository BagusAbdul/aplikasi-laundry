<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Outlet;
use App\Http\Requests\OutletRequest;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $outlets = Outlet::when($search, function($query) use ($search) {
            $query->where('nama_outlet', 'like', "%$search%")
                  ->orWhere('alamat', 'like', "%$search%");
        })->latest()->paginate(10);

        return view('admin.outlet.index', compact('outlets'));
    }

    public function store(OutletRequest $request)
    {
        Outlet::create($request->validated());
        return redirect()->route('admin.outlet.index')->with('success', 'Outlet berhasil ditambahkan!');
    }

    public function edit(Outlet $outlet)
    {
        return view('admin.outlet.edit', compact('outlet'));
    }

    public function update(OutletRequest $request, Outlet $outlet)
    {
        $outlet->update($request->validated());
        return redirect()->route('admin.outlet.index')->with('success', 'Outlet berhasil diperbarui!');
    }

    public function destroy(Outlet $outlet)
    {
        // Cek jika outlet masih punya paket atau user (mencegah data error)
        if ($outlet->users()->count() > 0 || $outlet->pakets()->count() > 0) {
            return redirect()->back()->with('error', 'Outlet tidak bisa dihapus karena masih memiliki data terkait (User/Paket).');
        }

        $outlet->delete();
        return redirect()->route('admin.outlet.index')->with('success', 'Outlet berhasil dihapus!');
    }
}
