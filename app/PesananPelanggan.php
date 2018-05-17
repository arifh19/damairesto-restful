<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PesananPelanggan extends Model
{
    protected $fillable = ['hidangan_id','nomor_meja','nama_pelanggan','kuantitas'];

    public function hidangans()
    {
        return $this->belongsToMany(Hidangan::class);
    }
}
