<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {

            $table->id();

            $table->integer('bulan');

            $table->integer('tahun');

            $table->decimal('total_pendapatan', 15, 2)->default(0);

            $table->decimal('total_pengeluaran', 15, 2)->default(0);

            $table->decimal('laba_bersih', 15, 2)->default(0);

            $table->string('status')->default('draft');

            $table->string('file_pdf')->nullable();

            $table->string('file_excel')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
