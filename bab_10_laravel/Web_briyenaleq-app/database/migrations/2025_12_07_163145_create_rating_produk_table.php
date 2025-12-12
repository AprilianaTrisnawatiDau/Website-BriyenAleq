<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rating_produk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penjualan'); // ambil ID dari tabel penjualan
            $table->integer('rating');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rating_produk');
    }
};
