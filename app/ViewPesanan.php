<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ViewPesanan extends Model
{

    protected $fillable = ['nomor_meja','nama_pelanggan','nama_hidangan','kuantitas','harga'];
    //
}
