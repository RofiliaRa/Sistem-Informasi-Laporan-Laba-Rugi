<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $pengeluarans = Pengeluaran::query()
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->when($search, function ($query) use ($search) {

                $query->where('nama_barang', 'like', "%{$search}%");

            })
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();
        /*
        |--------------------------------------------------------------------------
        | CEK LAPORAN BULAN AKTIF
        |--------------------------------------------------------------------------
        */

        $laporanFinal = Laporan::where('bulan', now()->format('m'))
            ->where('tahun', now()->format('Y'))
            ->where('status', 'final')
            ->exists();

        return view('admin.pengeluaran.index', compact(
            'pengeluarans',
            'laporanFinal',
            'search'
        ));
    }

    public function store(Request $request)
    {
        $data = $this->validatePengeluaran($request);

        /*
        |--------------------------------------------------------------------------
        | CEK STATUS LAPORAN
        |--------------------------------------------------------------------------
        */

        $tanggal = Carbon::parse($data['tanggal']);
        /*
|--------------------------------------------------------------------------
| HANYA BOLEH INPUT BULAN BERJALAN
|--------------------------------------------------------------------------
*/

        if (
            $tanggal->month != now()->month ||
            $tanggal->year != now()->year
        ) {

            return redirect()
                ->route('admin.pengeluaran.index')
                ->with(
                    'error',
                    'Data hanya dapat ditambahkan pada bulan yang sedang berjalan.'
                );

        }

        $laporan = Laporan::where('bulan', $tanggal->month)
            ->where('tahun', $tanggal->year)
            ->where('status', 'final')
            ->first();

        if ($laporan) {

            return redirect()
                ->route('admin.pengeluaran.index')
                ->with('error', 'Periode laporan sudah final, data tidak dapat ditambahkan');

        }

        $data['total'] = $data['jumlah'] * $data['harga'];

        Pengeluaran::create($data);

        return redirect()
            ->route('admin.pengeluaran.index')
            ->with('success', 'Data pengeluaran berhasil disimpan.');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATA
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        /*
        |--------------------------------------------------------------------------
        | CEK STATUS LAPORAN
        |--------------------------------------------------------------------------
        */

        $tanggalLama = Carbon::parse($pengeluaran->tanggal);

        $laporan = Laporan::where('bulan', $tanggalLama->month)
            ->where('tahun', $tanggalLama->year)
            ->where('status', 'final')
            ->first();

        if ($laporan) {

            return redirect()
                ->route('admin.pengeluaran.index')
                ->with('error', 'Laporan final tidak dapat diedit');

        }

        $data = $this->validatePengeluaran($request);

        $tanggalBaru = Carbon::parse($data['tanggal']);

        /*
        |--------------------------------------------------------------------------
        | HANYA BOLEH EDIT BULAN BERJALAN
        |--------------------------------------------------------------------------
        */

        if (
            $tanggalBaru->month != now()->month ||
            $tanggalBaru->year != now()->year
        ) {

            return redirect()
                ->route('admin.pengeluaran.index')
                ->with(
                    'error',
                    'Data bulan sebelumnya sudah terkunci.'
                );

        }

        $data['total'] = $data['jumlah'] * $data['harga'];

        $pengeluaran->update($data);

        return redirect()
            ->route('admin.pengeluaran.index')
            ->with('success', 'Data pengeluaran berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS DATA
    |--------------------------------------------------------------------------
    */

    public function destroy(Pengeluaran $pengeluaran)
    {
        /*
        |--------------------------------------------------------------------------
        | CEK STATUS LAPORAN
        |--------------------------------------------------------------------------
        */

        $tanggal = Carbon::parse($pengeluaran->tanggal);
        /*
|--------------------------------------------------------------------------
| HANYA BOLEH HAPUS BULAN BERJALAN
|--------------------------------------------------------------------------
*/

        if (
            $tanggal->month != now()->month ||
            $tanggal->year != now()->year
        ) {

            return redirect()
                ->route('admin.pengeluaran.index')
                ->with(
                    'error',
                    'Data bulan sebelumnya sudah terkunci.'
                );

        }

        $laporan = Laporan::where('bulan', $tanggal->month)
            ->where('tahun', $tanggal->year)
            ->where('status', 'final')
            ->first();

        if ($laporan) {

            return redirect()
                ->route('admin.pengeluaran.index')
                ->with('error', 'Laporan final tidak dapat dihapus');

        }

        $pengeluaran->delete();

        return redirect()
            ->route('admin.pengeluaran.index')
            ->with('success', 'Data pengeluaran berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDASI
    |--------------------------------------------------------------------------
    */

    private function validatePengeluaran(Request $request): array
    {
        return $request->validate([
            'tanggal' => ['required', 'date'],
            'nama_barang' => ['required', 'string', 'max:255'],

            'jenis_pengeluaran' => [
                'required',
                'in:Pembelian Persediaan,Operasional Lainnya',
            ],

            'jumlah' => ['required', 'integer', 'min:1'],
            'harga' => ['required', 'numeric', 'min:0'],
        ]);
    }
}
