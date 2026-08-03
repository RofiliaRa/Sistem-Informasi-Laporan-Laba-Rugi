<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendapatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')
                ->nullable()
                ->constrained('laporans')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->date('tanggal');
            $table->foreignId('category_id')
                ->constrained('categories');
            $table->string('nama_barang');
            $table->integer('jumlah');
            $table->decimal('harga', 10, 2);
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendapatans');
    }
};
