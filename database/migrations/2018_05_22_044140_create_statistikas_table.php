<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatistikasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistikas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('date');
            $table->integer('table_number');
            $table->double('earning');
            $table->string('information');
            $table->string('nama_pelanggan');
            $table->string('operatorname');
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
        Schema::dropIfExists('statistikas');
    }
}
