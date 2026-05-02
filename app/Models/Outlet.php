<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $table = 'outlet';
    /** @use HasFactory<\Database\Factories\OutletFactory> */
    use HasFactory;

public function users() {
    return $this->hasMany(User::class);
}
public function pakets() {
    return $this->hasMany(Paket::class);
}
}
