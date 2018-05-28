<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHidangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hidangans', function (Blueprint $table) {
            //$table->increments('id');
            $table->string('kode_hidangan')->unique();
            $table->string('nama_hidangan');
            $table->text('deskripsi');
            $table->integer('stok')->unsigned();
            $table->string('harga');
            $table->integer('waktu');
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
        Schema::dropIfExists('hidangans');
    }
}
