<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHidanganPesananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hidangan_pesanan', function (Blueprint $table) {
            $table->increments('id');
            //$table->integer('hidangan_id')->unsigned();
            $table->string('hidangan_kode_hidangan');
            $table->integer('pesanan_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hidangan_pesanan');
    }
}
