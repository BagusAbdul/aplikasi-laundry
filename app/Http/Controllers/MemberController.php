<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Member;
use App\Http\Requests\MemberRequest;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->paginate(10);
        return view('member.index', compact('members'));
    }

    public function store(MemberRequest $request)
    {
        Member::create($request->validated());
        return redirect()->back()->with('success', 'Pelanggan berhasil didaftarkan!');
    }

    // Menampilkan data untuk diedit (biasanya via modal atau halaman terpisah)
    public function edit(Member $member)
    {
        return response()->json($member); // Kita gunakan JSON jika ingin load ke Modal via JS
    }

    public function update(MemberRequest $request, Member $member)
    {
        $member->update($request->validated());
        return redirect()->back()->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    public function destroy(Member $member)
    {
        // Pastikan member belum memiliki transaksi sebelum dihapus (Best Practice)
        if ($member->transaksis()->count() > 0) {
            return redirect()->back()->with('error', 'Member tidak bisa dihapus karena memiliki riwayat transaksi.');
        }

        $member->delete();
        return redirect()->back()->with('success', 'Data pelanggan berhasil dihapus!');
    }
}
