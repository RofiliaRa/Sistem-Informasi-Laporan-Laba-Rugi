<?php

namespace App\Console\Commands;

use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoDeleteOldReports extends Command
{
    /**
     * Nama command.
     */
    protected $signature = 'app:auto-delete-old-reports';

    /**
     * Deskripsi command.
     */
    protected $description = 'Menghapus laporan yang berusia lebih dari 3 tahun';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /*
        |--------------------------------------------------------------------------
        | BATAS TANGGAL 3 TAHUN
        |--------------------------------------------------------------------------
        */

        $batas = Carbon::now()->subYears(3);

        /*
        |--------------------------------------------------------------------------
        | HAPUS DATA
        |--------------------------------------------------------------------------
        */

        $jumlah = Laporan::whereRaw(
            "STR_TO_DATE(CONCAT(tahun,'-',bulan,'-01'), '%Y-%m-%d') < ?",
            [$batas->format('Y-m-d')]
        )->delete();

        /*
        |--------------------------------------------------------------------------
        | INFORMASI
        |--------------------------------------------------------------------------
        */

        $this->info($jumlah.' laporan berhasil dihapus.');
    }
}
