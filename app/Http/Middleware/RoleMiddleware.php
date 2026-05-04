<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        // Ambil role user dan ubah ke lowercase agar konsisten
        $userRole = strtolower(Auth::user()->role->nama_role);

        // Cek apakah role user ada dalam daftar yang diizinkan (semua diubah ke lowercase)
        if (!in_array($userRole, array_map('strtolower', $roles))) {
            // DEBUG: Hapus baris di bawah ini jika sudah normal
            // dd('Role User: ' . $userRole, 'Role yang diminta: ', $roles);

            abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
