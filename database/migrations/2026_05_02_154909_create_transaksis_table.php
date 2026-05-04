<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
Schema::create('transaksi', function (Blueprint $table) {
    $table->id();
    $table->foreignId('outlet_id')->constrained('outlet')->onDelete('cascade');
    $table->string('kode_invoice', 100)->unique();
    $table->foreignId('member_id')->constrained('member')->onDelete('cascade');
    $table->dateTime('tanggal');
    $table->dateTime('batas_waktu');
    $table->dateTime('tanggal_bayar')->nullable();
    $table->integer('biaya_tambahan');
    $table->double('diskon');
    $table->integer('pajak');
    $table->enum('status', ['baru', 'proses', 'selesai', 'diambil'])->default('baru');
    $table->enum('dibayar', ['dibayar', 'belum_dibayar'])->default('belum_dibayar');
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
