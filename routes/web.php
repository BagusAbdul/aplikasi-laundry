<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\Admin\OutletController;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Kasir\TransaksiController;

// Auth Routes
Route::get('/', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Group Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () { return view('dashboard.admin'); })->name('dashboard');
    Route::resource('outlet', OutletController::class);
    Route::resource('paket', PaketController::class);
    Route::resource('user', UserController::class);
    Route::resource('member', MemberController::class);
});

// Group Kasir
Route::middleware(['auth', 'role:kasir,admin'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', function () { return view('dashboard.kasir'); })->name('dashboard');
    Route::resource('member', MemberController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::get('transaksi/{transaksi}/pdf', [TransaksiController::class, 'exportPdf'])->name('kasir.transaksi.pdf');
    Route::get('/transaksi/{transaksi}/pdf', [App\Http\Controllers\Kasir\TransaksiController::class, 'exportPdf'])->name('transaksi.pdf');
    });

// Group Owner
Route::middleware(['auth', 'role:owner,admin'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.owner');
    })->name('dashboard');
    Route::get('/laporan', [App\Http\Controllers\Owner\LaporanController::class, 'index'])->name('laporan.index');
});
