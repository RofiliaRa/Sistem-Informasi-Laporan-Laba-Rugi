<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatLaporanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ROUTE BERDASARKAN ROLE
    |--------------------------------------------------------------------------
    */

    private function redirectRoute()
    {
        return Auth::user()->role === 'admin'
            ? 'admin.riwayat.index'
            : 'direktur.riwayat.index';
    }

    public function index(Request $request)
    {
        $query = Laporan::query();

        /*
        |--------------------------------------------------------------------------
        | FILTER PERIODE
        |--------------------------------------------------------------------------
        */

        if ($request->filled('bulan')) {

            $tahun = date('Y', strtotime($request->bulan));
            $bulan = date('m', strtotime($request->bulan));

            $query->where('tahun', $tahun)
                  ->where('bulan', $bulan);
        }

        /*
        |--------------------------------------------------------------------------
        | URUTKAN DATA
        |--------------------------------------------------------------------------
        */

        $laporans = $query
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->paginate(5)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | CARD STATISTIK
        |--------------------------------------------------------------------------
        */

        $totalLaporan = Laporan::count();

        $totalFinal = Laporan::where('status', 'final')->count();

        $totalDraft = Laporan::where('status', 'draft')->count();

        return view('riwayat.index', compact(
            'laporans',
            'totalLaporan',
            'totalFinal',
            'totalDraft'
        ));
    }

    public function finalisasi(Request $request, Laporan $laporan)
{
    /*
    |--------------------------------------------------------------------------
    | CEGAH FINAL GANDA
    |--------------------------------------------------------------------------
    */

    if ($laporan->status === 'final') {

        return $this->redirectAfterFinal($request, $laporan)
            ->with('error', 'Laporan sudah berstatus final.');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS
    |--------------------------------------------------------------------------
    */

    $laporan->update([
        'status' => 'final'
    ]);

    /*
    |--------------------------------------------------------------------------
    | KEMBALI KE HALAMAN ASAL
    |--------------------------------------------------------------------------
    */

    return $this->redirectAfterFinal($request, $laporan)
        ->with('success', 'Laporan berhasil difinalisasi.');
}


private function redirectAfterFinal(Request $request, Laporan $laporan)
{
    if ($request->from === 'laporan') {

        return redirect()->route('admin.laporan.index', [
            'bulan' => $laporan->tahun . '-' . str_pad($laporan->bulan, 2, '0', STR_PAD_LEFT),
        ]);

    }

    return redirect()->route($this->redirectRoute());
}


    /*
    |--------------------------------------------------------------------------
    | HAPUS LAPORAN
    |--------------------------------------------------------------------------
    */

    public function destroy(Laporan $laporan)
    {
        /*
        |--------------------------------------------------------------------------
        | CEGAH HAPUS LAPORAN FINAL
        |--------------------------------------------------------------------------
        */

        if ($laporan->status === 'final') {

            return redirect()
                ->route($this->redirectRoute())
                ->with('error', 'Laporan final tidak dapat dihapus.');
        }

        /*
        |--------------------------------------------------------------------------
        | HAPUS DATA
        |--------------------------------------------------------------------------
        */

        $laporan->delete();

        return redirect()
            ->route($this->redirectRoute())
            ->with('success', 'Laporan berhasil dihapus.');
    }
}