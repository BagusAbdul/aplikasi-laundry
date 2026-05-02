<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $table = 'paket';
    /** @use HasFactory<\Database\Factories\PaketFactory> */
    use HasFactory;

    protected $fillable = ['outlet_id', 'jenis', 'nama_paket', 'harga'];

    public function outlet() {
        return $this->belongsTo(Outlet::class);
    }
}
