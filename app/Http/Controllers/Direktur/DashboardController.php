<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Pendapatan;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    public function index()
    {
        Carbon::setLocale('id');

        /*
|--------------------------------------------------------------------------
| FINALISASI OTOMATIS BULAN SEBELUMNYA
|--------------------------------------------------------------------------
*/

        $today = Carbon::today();

        if ($today->day == 1) {

            $bulanSebelumnya = $today->copy()->subMonth();

            Laporan::where('bulan', $bulanSebelumnya->month)
                ->where('tahun', $bulanSebelumnya->year)
                ->where('status', 'draft')
                ->update([
                    'status' => 'final',
                ]);
        }

        $now = Carbon::now();

        $totalPendapatan = Pendapatan::whereYear('tanggal', $now->year)
            ->whereMonth('tanggal', $now->month)
            ->sum('total');

        $totalPengeluaran = Pengeluaran::whereYear('tanggal', $now->year)
            ->whereMonth('tanggal', $now->month)
            ->sum('total');

        $labaBersih = $totalPendapatan - $totalPengeluaran;

        $laporanTerbaru = Laporan::orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->take(3)
            ->get();

        $periode = CarbonPeriod::create($now->copy()->startOfMonth(), $now->copy()->endOfMonth());

        $chartLabels = [];
        $chartPendapatan = [];
        $chartPengeluaran = [];

        foreach ($periode as $tanggal) {
            $chartLabels[] = $tanggal->format('d');
            $chartPendapatan[] = (float) Pendapatan::whereDate('tanggal', $tanggal->format('Y-m-d'))->sum('total');
            $chartPengeluaran[] = (float) Pengeluaran::whereDate('tanggal', $tanggal->format('Y-m-d'))->sum('total');
        }

        return view('direktur.dashboard', [
            'totalPendapatan' => $totalPendapatan,
            'totalPengeluaran' => $totalPengeluaran,
            'labaBersih' => $labaBersih,
            'laporanTerbaru' => $laporanTerbaru,
            'riwayatLaporan' => $laporanTerbaru,
            'periodeAktif' => $now->translatedFormat('F Y'),
            'todayText' => $now->translatedFormat('l, d F Y'),
            'chartLabels' => $chartLabels,
            'chartPendapatan' => $chartPendapatan,
            'chartPengeluaran' => $chartPengeluaran,
        ]);
    }
}
