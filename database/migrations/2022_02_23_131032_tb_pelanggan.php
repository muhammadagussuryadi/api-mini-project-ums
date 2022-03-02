<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbPelanggan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pelanggan', function(Blueprint $table){
            $table->string('id_pelanggan', 50)->primary();
            $table->string('nama', 50);
            $table->string('domisili', 100);
            $table->string('jenis_kelamin',10);
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
        Schema::dropIfExists('tb_pelanggan');
    }
}
