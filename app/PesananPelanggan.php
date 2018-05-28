<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PesananPelanggan extends Model
{

    protected $fillable = ['kode_hidangan','nomor_meja','nama_pelanggan','kuantitas'];

    public function hidangans()
    {
        return $this->belongsToMany(Hidangan::class);
    }
}
