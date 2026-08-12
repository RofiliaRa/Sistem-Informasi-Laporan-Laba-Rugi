<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Laporan;
use App\Models\Pendapatan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PendapatanController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('nama_kategori')
            ->get();

        $search = $request->search;

        $pendapatans = Pendapatan::with('category')

         // hanya bulan berjalan
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)

         // pencarian
            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('nama_barang', 'like', "%{$search}%")
                        ->orWhereHas('category', function ($kategori) use ($search) {

                            $kategori->where('nama_kategori', 'like', "%{$search}%");

                        });

                });

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

        return view('admin.pendapatan.index', compact(
            'categories',
            'pendapatans',
            'laporanFinal',
            'search'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $data = $this->validatePendapatan($request);

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
                ->route('admin.pendapatan.index')
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
                ->route('admin.pendapatan.index')
                ->with('error', 'Periode laporan sudah final, data tidak dapat ditambahkan');
        }

        $data['total'] = $data['jumlah'] * $data['harga'];

        Pendapatan::create($data);

        return redirect()
            ->route('admin.pendapatan.index')
            ->with('success', 'Data pendapatan berhasil disimpan.');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATA
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Pendapatan $pendapatan)
    {
        $tanggalLama = Carbon::parse($pendapatan->tanggal);

        $laporan = Laporan::where('bulan', $tanggalLama->month)
            ->where('tahun', $tanggalLama->year)
            ->where('status', 'final')
            ->first();

        if ($laporan) {

            return redirect()
                ->route('admin.pendapatan.index')
                ->with('error', 'Laporan final tidak dapat diedit');
        }

        $data = $this->validatePendapatan($request);

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
                ->route('admin.pendapatan.index')
                ->with(
                    'error',
                    'Data bulan sebelumnya sudah terkunci.'
                );

        }
        $data['total'] = $data['jumlah'] * $data['harga'];

        $pendapatan->update($data);

        return redirect()
            ->route('admin.pendapatan.index')
            ->with('success', 'Data pendapatan berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS DATA
    |--------------------------------------------------------------------------
    */

    public function destroy(Pendapatan $pendapatan)
    {
        $tanggal = Carbon::parse($pendapatan->tanggal);
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
                ->route('admin.pendapatan.index')
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
                ->route('admin.pendapatan.index')
                ->with('error', 'Laporan final tidak dapat dihapus');
        }

        $pendapatan->delete();

        return redirect()
            ->route('admin.pendapatan.index')
            ->with('success', 'Data pendapatan berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDASI
    |--------------------------------------------------------------------------
    */

    private function validatePendapatan(Request $request): array
    {
        return $request->validate([
            'tanggal' => ['required', 'date'],
            'category_id' => ['required', 'exists:categories,id'],
            'nama_barang' => ['required', 'string', 'max:255'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'harga' => ['required', 'numeric', 'min:0'],
        ]);
    }
}
