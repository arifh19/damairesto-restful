<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Hidangan;

class Pesanan extends Model
{
    protected $fillable = ['hidangan_id','kode_hidangan','nomor_meja','nama_pelanggan','kuantitas'];

    public function hidangans()
    {
        return $this->belongsToMany(Hidangan::class);
    }
}
