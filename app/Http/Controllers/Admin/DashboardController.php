<?php

namespace App\Http\Controllers\Admin;

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
            'status' => 'final'
        ]);
}

        $now = Carbon::now();

        $bulanAktif = $now->month;
        $tahunAktif = $now->year;

        /*
        |--------------------------------------------------------------------------
        | TOTAL BULAN BERJALAN
        |--------------------------------------------------------------------------
        */

        $totalPendapatan = Pendapatan::whereYear('tanggal', $tahunAktif)
            ->whereMonth('tanggal', $bulanAktif)
            ->sum('total');

        $totalPengeluaran = Pengeluaran::whereYear('tanggal', $tahunAktif)
            ->whereMonth('tanggal', $bulanAktif)
            ->sum('total');

        /*
        |--------------------------------------------------------------------------
        | LABA BERSIH
        |--------------------------------------------------------------------------
        */

        $labaBersih = $totalPendapatan - $totalPengeluaran;

        /*
        |--------------------------------------------------------------------------
        | STATUS KEUANGAN
        |--------------------------------------------------------------------------
        */

        $statusKeuangan = $labaBersih >= 0
            ? 'Laba Bersih'
            : 'Rugi Bersih';

        $statusKeuanganClass = $labaBersih >= 0
            ? 'profit'
            : 'loss';

        /*
|--------------------------------------------------------------------------
| TRANSAKSI TERBARU
|--------------------------------------------------------------------------
*/

$pendapatanTerbaru = Pendapatan::select(
    'id',
    'tanggal',
    'created_at',
    'nama_barang',
    'total'
)
->orderByDesc('created_at')
->get()
->map(function ($item) {

    return [

        'id'          => $item->id,

        'tanggal'     => $item->tanggal,

        'jam'         => $item->created_at
                            ? Carbon::parse($item->created_at)->format('H:i')
                            : '-',

        'jenis'       => 'Pendapatan',

        'keterangan'  => $item->nama_barang,

        'nominal'     => $item->total,

    ];

});

$pengeluaranTerbaru = Pengeluaran::select(
    'id',
    'tanggal',
    'created_at',
    'nama_barang',
    'total'
)
->orderByDesc('created_at')
->get()
->map(function ($item) {

    return [

        'id'          => $item->id,

        'tanggal'     => $item->tanggal,

        'jam'         => $item->created_at
                            ? Carbon::parse($item->created_at)->format('H:i')
                            : '-',

        'jenis'       => 'Pengeluaran',

        'keterangan'  => $item->nama_barang,

        'nominal'     => $item->total,

    ];

});

$transaksiTerbaru = $pendapatanTerbaru
    ->merge($pengeluaranTerbaru)
    ->sort(function ($a, $b) {

        $tanggalA = Carbon::parse($a['tanggal']);
        $tanggalB = Carbon::parse($b['tanggal']);

        if ($tanggalA->equalTo($tanggalB)) {

            return $b['id'] <=> $a['id'];

        }

        return $tanggalB->timestamp <=> $tanggalA->timestamp;

    })
    ->take(3)
    ->values();

        /*
|--------------------------------------------------------------------------
| STATUS LAPORAN BULAN BERJALAN
|--------------------------------------------------------------------------
*/

$laporanTerakhir = Laporan::firstOrCreate(

    [
        'bulan' => $bulanAktif,
        'tahun' => $tahunAktif,
    ],

    [
        'total_pendapatan' => 0,
        'total_pengeluaran' => 0,
        'laba_bersih' => 0,
        'status' => 'draft',
    ]

);
        /*
        |--------------------------------------------------------------------------
        | TOTAL DATA
        |--------------------------------------------------------------------------
        */

        $totalTransaksi =
    Pendapatan::whereYear('tanggal', $tahunAktif)
        ->whereMonth('tanggal', $bulanAktif)
        ->count()

    +

    Pengeluaran::whereYear('tanggal', $tahunAktif)
        ->whereMonth('tanggal', $bulanAktif)
        ->count();

       $totalLaporan = Laporan::where('tahun', $tahunAktif)
    ->count();

        $laporanFinal = Laporan::where('tahun', $tahunAktif)
    ->where('status', 'final')
    ->count();

        /*
        |--------------------------------------------------------------------------
        | GRAFIK HARIAN BULAN BERJALAN
        |--------------------------------------------------------------------------
        */

        $periode = CarbonPeriod::create(
            $now->copy()->startOfMonth(),
            $now->copy()->endOfMonth()
        );

        $chartLabels = [];
        $chartPendapatan = [];
        $chartPengeluaran = [];
        $chartLaba = [];

        foreach ($periode as $tanggal) {

            $labelTanggal = $tanggal->format('d');

            $pendapatanHarian = (float) Pendapatan::whereDate(
                'tanggal',
                $tanggal->format('Y-m-d')
            )->sum('total');

            $pengeluaranHarian = (float) Pengeluaran::whereDate(
                'tanggal',
                $tanggal->format('Y-m-d')
            )->sum('total');

            $chartLabels[] = $labelTanggal;

            $chartPendapatan[] = $pendapatanHarian;

            $chartPengeluaran[] = $pengeluaranHarian;

            $chartLaba[] = $pendapatanHarian - $pengeluaranHarian;
        }

        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE VIEW
        |--------------------------------------------------------------------------
        */

        return view('admin.dashboard', [

            'bulanAktif' => $bulanAktif,
            'tahunAktif' => $tahunAktif,

            'periodeAktif' => $now->translatedFormat('F Y'),

            'todayText' => $now->translatedFormat('l, d F Y'),

            'totalPendapatan' => $totalPendapatan,

            'totalPengeluaran' => $totalPengeluaran,

            'labaBersih' => $labaBersih,

            'statusKeuangan' => $statusKeuangan,

            'statusKeuanganClass' => $statusKeuanganClass,

            'transaksiTerbaru' => $transaksiTerbaru,

            'laporanTerakhir' => $laporanTerakhir,

            'totalTransaksi' => $totalTransaksi,

            'totalLaporan' => $totalLaporan,

            'laporanFinal' => $laporanFinal,

            'chartLabels' => $chartLabels,

            'chartPendapatan' => $chartPendapatan,

            'chartPengeluaran' => $chartPengeluaran,

            'chartLaba' => $chartLaba,

        ]);
    }
}