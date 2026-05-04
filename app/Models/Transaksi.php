<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    /** @use HasFactory<\Database\Factories\TransaksiFactory> */
    use HasFactory;
protected $fillable = [
    'outlet_id',
    'kode_invoice',
    'member_id',
    'tanggal',
    'batas_waktu',
    'tanggal_bayar',
    'biaya_tambahan',
    'diskon',
    'pajak',
    'status',
    'dibayar',
    'user_id',
    // 'keterangan'
];

public function outlet() { return $this->belongsTo(Outlet::class); }
public function member() { return $this->belongsTo(Member::class); }
public function user() { return $this->belongsTo(User::class); }
public function details() { return $this->hasMany(DetailTransaksi::class); }
public function pembayaran() { return $this->hasOne(Pembayaran::class); }

}
