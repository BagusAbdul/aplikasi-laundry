<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';
    /** @use HasFactory<\Database\Factories\DetailTransaksiFactory> */
    use HasFactory;

    protected $fillable = ['transaksi_id', 'paket_id', 'qty', 'subtotal'];

public function transaksi() { return $this->belongsTo(Transaksi::class); }
public function paket() { return $this->belongsTo(Paket::class); }
}
