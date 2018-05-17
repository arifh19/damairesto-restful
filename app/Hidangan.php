<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hidangan extends Model
{
    protected $fillable = ['nama_hidangan','deskripsi','stok','harga','waktu'];

    public function pesanans()
    {
        return $this->belongsToMany(Pesanan::class);
    }
}
