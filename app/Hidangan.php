<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hidangan extends Model
{
    protected $fillable = ['kode_hidangan','nama_hidangan','deskripsi','stok','harga','waktu'];
    //protected $guarded = 'kode_hidangan';
    //protected $columns = 'kode_hidangan';
    public $incrementing = false;
    protected $primaryKey  = 'kode_hidangan';

    public function pesanans()
    {
        return $this->belongsToMany(Pesanan::class);
    }
}
