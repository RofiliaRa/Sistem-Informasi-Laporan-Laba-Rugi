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
                ->update(['status' => 'final']);
        }

        $bulan = $request->bulan ?? now()->format('Y-m');
        $m = date('m', strtotime($bulan));
        $y = date('Y', strtotime($bulan));

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA PENDAPATAN & PENGELUARAN
        |--------------------------------------------------------------------------
        */
        $pendapatan = Pendapatan::with('category')
            ->whereYear('tanggal', $y)
            ->whereMonth('tanggal', $m)
            ->get();

        $pengeluaran = Pengeluaran::whereYear('tanggal', $y)
            ->whereMonth('tanggal', $m)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | KAS & LAPORAN SEBELUMNYA
        |--------------------------------------------------------------------------
        */
        $currDate = Carbon::parse($bulan.'-01');
        $prevDate = $currDate->copy()->subMonth();
        $laporanSebelumnya = Laporan::where('bulan', $prevDate->month)
            ->where('tahun', $prevDate->year)
            ->first();

        $saldoKasLalu = $laporanSebelumnya ? $laporanSebelumnya->total_kas_akhir : 0;

        /*
        |--------------------------------------------------------------------------
        | AMBIL / BUAT LAPORAN AKTIF
        |--------------------------------------------------------------------------
        */
        $laporanAktif = Laporan::firstOrCreate(
            ['bulan' => $m, 'tahun' => $y],
            [
                'status' => 'draft',
                'modal_tahunan' => 0,
                'persediaan_awal' => 0,
                'persediaan_akhir' => 0,
                'pendapatan_non_usaha' => 0,
                'pph' => 0,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | KALKULASI MULTI-STEP LABA RUGI & KAS
        |--------------------------------------------------------------------------
        */
        $pendapatanJasa = $pendapatan->filter(function ($item) {
            return strtolower(trim($item->category->nama_kategori ?? '')) === 'jasa';
        })->sum('total');

        $pendapatanBarang = $pendapatan->filter(function ($item) {
            return strtolower(trim($item->category->nama_kategori ?? '')) !== 'jasa';
        })->sum('total');

        $totalPendapatan = $pendapatan->sum('total');

        $pembelianPersediaan = $pengeluaran->where('jenis_pengeluaran', 'Pembelian Persediaan')->sum('total');
        $bebanOperasional = $pengeluaran->where('jenis_pengeluaran', 'Operasional Lainnya')->sum('total');
        $totalPengeluaran = $pengeluaran->sum('total');

        $persediaanAwal = $laporanAktif ? $laporanAktif->persediaan_awal : 0;
        $persediaanAkhir = $laporanAktif ? $laporanAktif->persediaan_akhir : 0;
        $modalTahunan = $laporanAktif ? $laporanAktif->modal_tahunan : 0;
        $pendapatanNonUsaha = $laporanAktif ? $laporanAktif->pendapatan_non_usaha : 0;
        $pph = $laporanAktif ? $laporanAktif->pph : 0;

        $hpp = $persediaanAwal + $pembelianPersediaan - $persediaanAkhir;
        $labaKotor = $totalPendapatan - $hpp;
        $totalBebanUsaha = $bebanOperasional;
        $labaUsaha = $labaKotor - $totalBebanUsaha;
        $labaSebelumPajak = $labaUsaha + $pendapatanNonUsaha;
        $labaBersih = $labaSebelumPajak - $pph;

        $saldoKasAwal = $modalTahunan + $saldoKasLalu;
        $totalKasAkhir = $saldoKasAwal + $labaBersih;

        if ($laporanAktif && $laporanAktif->status != 'final') {
            $laporanAktif->update([
                'total_pendapatan' => $totalPendapatan,
                'total_pengeluaran' => $totalPengeluaran,
                'laba_bersih' => $labaBersih,
                'hpp' => $hpp,
                'laba_kotor' => $labaKotor,
                'laba_usaha' => $labaUsaha,
                'saldo_kas_awal' => $saldoKasAwal,
                'total_kas_akhir' => $totalKasAkhir,
            ]);
        }

        $pendapatanPerKategori = $pendapatan
            ->groupBy(function ($item) {
                return $item->category->nama_kategori ?? 'Lainnya';
            })
            ->map(function ($items) {
                return $items->sum('total');
            });

        $pengeluaranKategori = collect([
            'Pembelian Persediaan' => $pembelianPersediaan,
            'Operasional Lainnya' => $bebanOperasional,
        ])->filter(function ($total) {
            return $total > 0;
        });

        return view('admin.laporan.index', [
            'periode' => Carbon::parse($bulan.'-01')->translatedFormat('F Y'),
            'bulan' => $bulan,
            'laporanAktif' => $laporanAktif,
            'totalPendapatan' => $totalPendapatan,
            'totalPengeluaran' => $totalPengeluaran,
            'labaBersih' => $labaBersih,
            'pendapatanJasa' => $pendapatanJasa,
            'pendapatanBarang' => $pendapatanBarang,
            'pembelianPersediaan' => $pembelianPersediaan,
            'bebanOperasional' => $bebanOperasional,
            'persediaanAwal' => $persediaanAwal,
            'persediaanAkhir' => $persediaanAkhir,
            'hpp' => $hpp,
            'labaKotor' => $labaKotor,
            'totalBebanUsaha' => $totalBebanUsaha,
            'labaUsaha' => $labaUsaha,
            'pendapatanNonUsaha' => $pendapatanNonUsaha,
            'labaSebelumPajak' => $labaSebelumPajak,
            'pph' => $pph,
            'modalTahunan' => $modalTahunan,
            'saldoKasLalu' => $saldoKasLalu,
            'saldoKasAwal' => $saldoKasAwal,
            'totalKasAkhir' => $totalKasAkhir,
            'pendapatanPerKategori' => $pendapatanPerKategori,
            'pengeluaranKategori' => $pengeluaranKategori,
            'pendapatan' => $pendapatan,
            'pengeluaran' => $pengeluaran,
        ]);
    }

    public function updateDetail(Request $request)
    {
        $request->validate([
            'laporan_id' => 'required|exists:laporans,id',
            'modal_tahunan' => 'nullable|numeric|min:0',
            'persediaan_awal' => 'nullable|numeric|min:0',
            'persediaan_akhir' => 'nullable|numeric|min:0',
            'pendapatan_non_usaha' => 'nullable|numeric|min:0',
            'pph' => 'nullable|numeric|min:0',
        ]);

        $laporan = Laporan::findOrFail($request->laporan_id);

        if ($laporan->status === 'final') {
            return redirect()->back()->with('warning', 'Laporan yang sudah final tidak dapat diubah.');
        }

        $laporan->update([
            'modal_tahunan' => $request->modal_tahunan ?? 0,
            'persediaan_awal' => $request->persediaan_awal ?? 0,
            'persediaan_akhir' => $request->persediaan_akhir ?? 0,
            'pendapatan_non_usaha' => $request->pendapatan_non_usaha ?? 0,
            'pph' => $request->pph ?? 0,
        ]);

        return redirect()->back()->with('success', 'Rincian laporan berhasil diperbarui.');
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

        $namaFile = 'Laporan Laba Rugi Bulan '.
            Carbon::parse($bulan.'-01')->translatedFormat('F Y').
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
        $m = date('m', strtotime($bulan));
        $y = date('Y', strtotime($bulan));

        $pendapatan = Pendapatan::with('category')
            ->whereYear('tanggal', $y)
            ->whereMonth('tanggal', $m)
            ->orderBy('tanggal', 'asc')
            ->get();

        $pengeluaran = Pengeluaran::whereYear('tanggal', $y)
            ->whereMonth('tanggal', $m)
            ->orderBy('tanggal', 'asc')
            ->get();

        if ($pendapatan->isEmpty() && $pengeluaran->isEmpty()) {
            return redirect()
                ->route('admin.laporan.index', ['bulan' => $bulan])
                ->with('warning', 'Belum terdapat transaksi pada periode yang dipilih.');
        }

        $laporan = Laporan::firstOrCreate(
            ['bulan' => $m, 'tahun' => $y],
            ['status' => 'draft']
        );

        $currDate = Carbon::parse($bulan.'-01');
        $prevDate = $currDate->copy()->subMonth();
        $laporanSebelumnya = Laporan::where('bulan', $prevDate->month)
            ->where('tahun', $prevDate->year)
            ->first();

        $saldoKasLalu = $laporanSebelumnya ? $laporanSebelumnya->total_kas_akhir : 0;

        $pendapatanJasa = $pendapatan->filter(function ($item) {
            return strtolower(trim($item->category->nama_kategori ?? '')) === 'jasa';
        })->sum('total');

        $pendapatanBarang = $pendapatan->filter(function ($item) {
            return strtolower(trim($item->category->nama_kategori ?? '')) !== 'jasa';
        })->sum('total');

        $totalPendapatan = $pendapatan->sum('total');
        $pembelianPersediaan = $pengeluaran->where('jenis_pengeluaran', 'Pembelian Persediaan')->sum('total');
        $bebanOperasional = $pengeluaran->where('jenis_pengeluaran', 'Operasional Lainnya')->sum('total');
        $totalPengeluaran = $pengeluaran->sum('total');

        $persediaanAwal = $laporan->persediaan_awal;
        $persediaanAkhir = $laporan->persediaan_akhir;
        $modalTahunan = $laporan->modal_tahunan;
        $pendapatanNonUsaha = $laporan->pendapatan_non_usaha;
        $pph = $laporan->pph;

        $hpp = $persediaanAwal + $pembelianPersediaan - $persediaanAkhir;
        $labaKotor = $totalPendapatan - $hpp;
        $totalBebanUsaha = $bebanOperasional;
        $labaUsaha = $labaKotor - $totalBebanUsaha;
        $labaSebelumPajak = $labaUsaha + $pendapatanNonUsaha;
        $labaBersih = $labaSebelumPajak - $pph;

        $saldoKasAwal = $modalTahunan + $saldoKasLalu;
        $totalKasAkhir = $saldoKasAwal + $labaBersih;

        if ($laporan->status != 'final') {
            $laporan->update([
                'total_pendapatan' => $totalPendapatan,
                'total_pengeluaran' => $totalPengeluaran,
                'laba_bersih' => $labaBersih,
                'hpp' => $hpp,
                'laba_kotor' => $labaKotor,
                'laba_usaha' => $labaUsaha,
                'saldo_kas_awal' => $saldoKasAwal,
                'total_kas_akhir' => $totalKasAkhir,
            ]);
        }

        $pengeluaranKategori = collect([
            'Pembelian Persediaan' => $pembelianPersediaan,
            'Operasional Lainnya' => $bebanOperasional,
        ])->filter(function ($total) {
            return $total > 0;
        });

        $pdf = Pdf::loadView('admin.laporan.pdf', [
            'periode' => Carbon::parse($bulan.'-01')->translatedFormat('F Y'),
            'bulan' => $bulan,
            'pendapatan' => $pendapatan,
            'pengeluaran' => $pengeluaran,
            'pendapatanJasa' => $pendapatanJasa,
            'pendapatanBarang' => $pendapatanBarang,
            'totalPendapatan' => $totalPendapatan,
            'pembelianPersediaan' => $pembelianPersediaan,
            'bebanOperasional' => $bebanOperasional,
            'totalPengeluaran' => $totalPengeluaran,
            'persediaanAwal' => $persediaanAwal,
            'persediaanAkhir' => $persediaanAkhir,
            'hpp' => $hpp,
            'labaKotor' => $labaKotor,
            'totalBebanUsaha' => $totalBebanUsaha,
            'labaUsaha' => $labaUsaha,
            'pendapatanNonUsaha' => $pendapatanNonUsaha,
            'labaSebelumPajak' => $labaSebelumPajak,
            'pph' => $pph,
            'labaBersih' => $labaBersih,
            'modalTahunan' => $modalTahunan,
            'saldoKasLalu' => $saldoKasLalu,
            'saldoKasAwal' => $saldoKasAwal,
            'totalKasAkhir' => $totalKasAkhir,
            'pengeluaranKategori' => $pengeluaranKategori,
            'status' => $laporan->status,
        ])->setPaper('a4');

        $pdf->render();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $font = $pdf->getDomPDF()->getFontMetrics()->getFont('Helvetica', 'normal');
        $canvas->page_text(470, 815, 'Halaman {PAGE_NUM} dari {PAGE_COUNT}', $font, 10, [0, 0, 0]);

        $namaFile = 'Laporan Laba Rugi Bulan '.
            Carbon::parse($bulan.'-01')->translatedFormat('F Y').
            '.pdf';

        return $pdf->download($namaFile);
    }
}
