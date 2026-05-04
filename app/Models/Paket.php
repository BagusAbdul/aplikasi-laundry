<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paket extends Model
{
    protected $table = 'paket';
    protected $fillable = ['outlet_id', 'jenis', 'nama_paket', 'harga'];

    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class, 'paket_id');
    }
}
