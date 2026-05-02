<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

    protected $table = 'member';

    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory;

    protected $fillable = ['nama', 'alamat', 'jenis_kelamin', 'telepon'];

    public function transaksis() {
        return $this->hasMany(Transaksi::class);
    }

}
