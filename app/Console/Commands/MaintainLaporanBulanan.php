<?php

namespace App\Console\Commands;

use App\Models\Laporan;
use App\Models\Pendapatan;
use App\Models\Pengeluaran;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class MaintainLaporanBulanan extends Command
{
    protected $signature = 'laporan:maintain';
    protected $description = 'Tutup laporan bulanan setiap tanggal 1 dan hapus data lebih dari 3 tahun';

    public function handle(): int
    {
        $now = Carbon::now();

        if ($now->day === 1) {
            $periode = $now->copy()->subMonth();
            $start = $periode->copy()->startOfMonth();
            $end = $periode->copy()->endOfMonth();

            $totalPendapatan = Pendapatan::whereBetween('tanggal', [$start, $end])->sum('total');
            $totalPengeluaran = Pengeluaran::whereBetween('tanggal', [$start, $end])->sum('total');
            $labaKotor = $totalPendapatan;
            $labaBersih = $totalPendapatan - $totalPengeluaran;

            Laporan::updateOrCreate(
                [
                    'bulan' => $periode->month,
                    'tahun' => $periode->year,
                ],
                [
                    'total_pendapatan' => $totalPendapatan,
                    'hpp' => 0,
                    'total_pengeluaran' => $totalPengeluaran,
                    'pajak' => 0,
                    'laba_kotor' => $labaKotor,
                    'laba_bersih' => $labaBersih,
                    'status' => 'closed',
                ]
            );

            $this->info('Laporan bulan sebelumnya berhasil ditutup.');
        }

        $batas = Carbon::now()->subYears(3)->startOfDay();

        Pendapatan::whereDate('tanggal', '<', $batas)->delete();
        Pengeluaran::whereDate('tanggal', '<', $batas)->delete();

        Laporan::where(function ($query) use ($batas) {
            $query->where('tahun', '<', $batas->year)
                ->orWhere(function ($q) use ($batas) {
                    $q->where('tahun', $batas->year)
                        ->where('bulan', '<', $batas->month);
                });
        })->delete();

        $this->info('Data lebih dari 3 tahun berhasil dibersihkan.');

        return self::SUCCESS;
    }
}