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
        Schema::table('laporans', function (Blueprint $table) {
            $table->decimal('modal_tahunan', 15, 2)->default(0)->after('laba_bersih');
            $table->decimal('persediaan_awal', 15, 2)->default(0)->after('modal_tahunan');
            $table->decimal('persediaan_akhir', 15, 2)->default(0)->after('persediaan_awal');
            $table->decimal('hpp', 15, 2)->default(0)->after('persediaan_akhir');
            $table->decimal('laba_kotor', 15, 2)->default(0)->after('hpp');
            $table->decimal('laba_usaha', 15, 2)->default(0)->after('laba_kotor');
            $table->decimal('pendapatan_non_usaha', 15, 2)->default(0)->after('laba_usaha');
            $table->decimal('pph', 15, 2)->default(0)->after('pendapatan_non_usaha');
            $table->decimal('saldo_kas_awal', 15, 2)->default(0)->after('pph');
            $table->decimal('total_kas_akhir', 15, 2)->default(0)->after('saldo_kas_awal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn([
                'modal_tahunan',
                'persediaan_awal',
                'persediaan_akhir',
                'hpp',
                'laba_kotor',
                'laba_usaha',
                'pendapatan_non_usaha',
                'pph',
                'saldo_kas_awal',
                'total_kas_akhir',
            ]);
        });
    }
};
