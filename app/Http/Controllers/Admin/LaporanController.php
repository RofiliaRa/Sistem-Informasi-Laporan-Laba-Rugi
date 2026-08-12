<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LaporanExport;
use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Pendapatan;
use App\Models\Pengeluaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
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

        $bulan = $request->bulan ?? now()->format('Y-m');

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA PENDAPATAN
        |--------------------------------------------------------------------------
        */

        $pendapatan = Pendapatan::with('category')
            ->whereYear('tanggal', date('Y', strtotime($bulan)))
            ->whereMonth('tanggal', date('m', strtotime($bulan)))
            ->get();

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA PENGELUARAN
        |--------------------------------------------------------------------------
        */

        $pengeluaran = Pengeluaran::whereYear(
                'tanggal',
                date('Y', strtotime($bulan))
            )
            ->whereMonth(
                'tanggal',
                date('m', strtotime($bulan))
            )
            ->get();

        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        $totalPendapatan = $pendapatan->sum('total');

        $totalPengeluaran = $pengeluaran->sum('total');

        $labaBersih = $totalPendapatan - $totalPengeluaran;

        /*
        |--------------------------------------------------------------------------
        | AMBIL LAPORAN AKTIF
        |--------------------------------------------------------------------------
        */

        $laporanAktif = Laporan::where(
                'bulan',
                date('m', strtotime($bulan))
            )
            ->where(
                'tahun',
                date('Y', strtotime($bulan))
            )
            ->first();

        /*
        |--------------------------------------------------------------------------
        | JIKA TIDAK ADA TRANSAKSI
        |--------------------------------------------------------------------------
        */

        if ($pendapatan->isEmpty() && $pengeluaran->isEmpty()) {

            $laporanAktif = null;

        } else {

            /*
            |--------------------------------------------------------------------------
            | AMBIL / BUAT LAPORAN
            |--------------------------------------------------------------------------
            */

            if (!$laporanAktif) {

                $laporanAktif = Laporan::create([
                    'bulan' => date('m', strtotime($bulan)),
                    'tahun' => date('Y', strtotime($bulan)),
                    'total_pendapatan' => $totalPendapatan,
                    'total_pengeluaran' => $totalPengeluaran,
                    'laba_bersih' => $labaBersih,
                    'status' => 'draft',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | UPDATE JIKA MASIH DRAFT
            |--------------------------------------------------------------------------
            */

            if ($laporanAktif->status != 'final') {

                $laporanAktif->update([
                    'total_pendapatan' => $totalPendapatan,
                    'total_pengeluaran' => $totalPengeluaran,
                    'laba_bersih' => $labaBersih,
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PENDAPATAN PER KATEGORI
        |--------------------------------------------------------------------------
        */
        $pendapatanPerKategori = $pendapatan
    ->groupBy(function ($item) {
        return $item->category->nama_kategori ?? 'Lainnya';
    })
    ->map(function ($items) {
        return $items->sum('total');
    })
    ->filter(function ($total) {
        return $total > 0;
    });

        $pengeluaranKategori = collect([
            'Pembelian Persediaan' => $pengeluaran
                ->where('jenis_pengeluaran', 'Pembelian Persediaan')
                ->sum('total'),

            'Operasional Lainnya' => $pengeluaran
                ->where('jenis_pengeluaran', 'Operasional Lainnya')
                ->sum('total'),
        ])->filter(function ($total) {
            return $total > 0;
        });

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view('admin.laporan.index', [

            'periode' => Carbon::parse(
                $bulan . '-01'
            )->translatedFormat('F Y'),

            'bulan' => $bulan,

            'laporanAktif' => $laporanAktif,

            'totalPendapatan' => $totalPendapatan,

            'totalPengeluaran' => $totalPengeluaran,

            'labaBersih' => $labaBersih,

            'pendapatanPerKategori' => $pendapatanPerKategori,

            'pengeluaranKategori' => $pengeluaranKategori,

            'pendapatan' => $pendapatan,

            'pengeluaran' => $pengeluaran,

        ]);
    }

    public function downloadExcel(Request $request)
    {
        $bulan = $request->bulan ?? now()->format('Y-m');

        Carbon::setLocale('id');

        /*
        |--------------------------------------------------------------------------
        | AMBIL STATUS LAPORAN
        |--------------------------------------------------------------------------
        */

        $laporan = Laporan::where(
                'bulan',
                date('m', strtotime($bulan))
            )
            ->where(
                'tahun',
                date('Y', strtotime($bulan))
            )
            ->first();

        /*
        |--------------------------------------------------------------------------
        | STATUS DEFAULT
        |--------------------------------------------------------------------------
        */

        $status = $laporan?->status ?? 'draft';

        /*
        |--------------------------------------------------------------------------
        | WAKTU DOWNLOAD
        |--------------------------------------------------------------------------
        | Menggunakan waktu Indonesia (WIB)
        |--------------------------------------------------------------------------
        */

        $dicetakPada = Carbon::now('Asia/Jakarta');

        /*
        |--------------------------------------------------------------------------
        | NAMA FILE
        |--------------------------------------------------------------------------
        */

        $namaFile = 'Laporan Laba Rugi Bulan ' .
            Carbon::parse($bulan . '-01')->translatedFormat('F Y') .
            '.xlsx';

        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD EXCEL
        |--------------------------------------------------------------------------
        */

        return Excel::download(
            new LaporanExport(
                $bulan,
                $status,
                $dicetakPada
            ),
            $namaFile
        );
    }

    public function downloadPdf(Request $request)
    {
        Carbon::setLocale('id');

        $bulan = $request->bulan ?? now()->format('Y-m');

        /*
        |--------------------------------------------------------------------------
        | DATA PENDAPATAN
        |--------------------------------------------------------------------------
        */

        $pendapatan = Pendapatan::with('category')
            ->whereYear(
                'tanggal',
                date('Y', strtotime($bulan))
            )
            ->whereMonth(
                'tanggal',
                date('m', strtotime($bulan))
            )
            ->orderBy('tanggal', 'asc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | DATA PENGELUARAN
        |--------------------------------------------------------------------------
        */

        $pengeluaran = Pengeluaran::whereYear('tanggal', date('Y', strtotime($bulan)))
            ->whereMonth('tanggal', date('m', strtotime($bulan)))
            ->orderBy('tanggal', 'asc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        $totalPendapatan = $pendapatan->sum('total');

        $totalPengeluaran = $pengeluaran->sum('total');

        $labaBersih = $totalPendapatan - $totalPengeluaran;

        /*
        |--------------------------------------------------------------------------
        | VALIDASI DATA KOSONG
        |--------------------------------------------------------------------------
        */

        if ($pendapatan->isEmpty() && $pengeluaran->isEmpty()) {

            return redirect()
                ->route('admin.laporan.index', [
                    'bulan' => $bulan,
                ])
                ->with('warning', 'Belum terdapat transaksi pada periode yang dipilih.');
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE / CREATE LAPORAN
        |--------------------------------------------------------------------------
        */

        $laporan = Laporan::firstOrCreate(

            [
                'bulan' => date('m', strtotime($bulan)),
                'tahun' => date('Y', strtotime($bulan)),
            ],

            [
                'status' => 'draft',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | UPDATE JIKA MASIH DRAFT
        |--------------------------------------------------------------------------
        */

        if ($laporan->status != 'final') {

            $laporan->update([
                'total_pendapatan' => $totalPendapatan,
                'total_pengeluaran' => $totalPengeluaran,
                'laba_bersih' => $labaBersih,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | TOTAL PER KATEGORI
        |--------------------------------------------------------------------------
        */

        $pendapatanJasa = $pendapatan
            ->where('category_id', 1)
            ->sum('total');

        $pendapatanBarang = $pendapatan
            ->where('category_id', 2)
            ->sum('total');

        /*
        |--------------------------------------------------------------------------
        | PENGELUARAN PER JENIS
        |--------------------------------------------------------------------------
        */

        $pengeluaranKategori = collect([
            'Pembelian Persediaan' => $pengeluaran
                ->where('jenis_pengeluaran', 'Pembelian Persediaan')
                ->sum('total'),

            'Operasional Lainnya' => $pengeluaran
                ->where('jenis_pengeluaran', 'Operasional Lainnya')
                ->sum('total'),
        ])->filter(function ($total) {
            return $total > 0;
        });
        /*
        |--------------------------------------------------------------------------
        | GENERATE PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView('admin.laporan.pdf', [

            'periode' => Carbon::parse($bulan.'-01')->translatedFormat('F Y'),

            'bulan' => $bulan,

            'pendapatan' => $pendapatan,

            'pengeluaran' => $pengeluaran,

            'pendapatanJasa' => $pendapatanJasa,

            'pendapatanBarang' => $pendapatanBarang,

            'pengeluaranKategori' => $pengeluaranKategori,

            'totalPendapatan' => $totalPendapatan,

            'totalPengeluaran' => $totalPengeluaran,

            'labaBersih' => $labaBersih,

            'status' => $laporan->status,

        ])->setPaper('a4');

        $pdf->render();

        $canvas = $pdf->getDomPDF()->getCanvas();

        $font = $pdf->getDomPDF()->getFontMetrics()->getFont(
            'Helvetica',
            'normal'
        );

        $canvas->page_text(
            470,
            815,
            'Halaman {PAGE_NUM} dari {PAGE_COUNT}',
            $font,
            10,
            [0, 0, 0]
        );

        Carbon::setLocale('id');

        $namaFile = 'Laporan Laba Rugi Bulan '.
            Carbon::parse($bulan.'-01')->translatedFormat('F Y').
            '.pdf';

        return $pdf->download($namaFile);
    }
}
