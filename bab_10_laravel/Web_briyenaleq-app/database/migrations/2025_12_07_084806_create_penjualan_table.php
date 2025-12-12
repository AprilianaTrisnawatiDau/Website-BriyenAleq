<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama', 100);
            $table->string('produk', 100);
            $table->text('alamat');
            $table->enum('kategori', ['Ternak', 'Tani']);
            $table->decimal('harga', 12, 2);
            $table->string('foto')->nullable();
            $table->timestamps();

            $table->index('tanggal');
            $table->index('kategori');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
