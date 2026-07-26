@extends('layouts.dashboard')

@section('content')

<style>

/* ==========================
   CARD
========================== */

.dash-panel-card-pro{

    background:#ffffff;

    border:none;

    border-radius:18px;

    box-shadow:0 6px 18px rgba(15,23,42,.06);

    overflow:hidden;

    margin-bottom:18px;

}

.dash-panel-header{

    padding:18px 22px;

    border-bottom:1px solid #eef2f7;

}

.dash-panel-header h3,
.dash-panel-header h5{

    margin:0;

    font-size:24px;

    font-weight:800;

    color:#0f172a;

    line-height:1.2;

}

.dash-panel-body{

    padding:20px 22px;

}

/* ==========================
   LABEL
========================== */

.form-label{

    margin-bottom:5px;

    font-size:14px;

    font-weight:600;

    color:#475569;

}

/* ==========================
   INPUT
========================== */

.form-control,
.form-select{

    height:44px;

    border:1px solid #dbe3ec;

    border-radius:12px;

    font-size:14px;

    color:#1e293b;

    box-shadow:none;

    transition:.2s;

}

.form-control::placeholder{

    color:#94a3b8;

}

.form-control:focus,
.form-select:focus{

    border-color:#2563eb;

    box-shadow:0 0 0 .15rem rgba(37,99,235,.12);

}

input[readonly]{

    background:#f8fafc;

}

/* ==========================
   BUTTON
========================== */

.btn-primary{

    height:42px;

    padding:0 18px;

    border-radius:12px;

    font-size:14px;

    font-weight:700;

}

.btn-outline-secondary{

    height:42px;

    padding:0 18px;

    border-radius:12px;

    font-size:14px;

    font-weight:700;

}

.btn-reset{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    gap:6px;

    height:42px;

    padding:0 16px;

    border-radius:12px;

    border:1px solid #dbe2ea;

    background:#ffffff;

    color:#475569;

    font-size:13px;

    font-weight:600;

    text-decoration:none;

    transition:.25s;

}

.btn-reset:hover{

    background:#f8fbff;

    border-color:#cfd8e3;

    color:#2563eb;

}

/* ==========================
   TOTAL DATA
========================== */

.total-data-chip{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    padding:7px 9px;

    border-radius:999px;

    background:#edf6ff;

    color:#12365f;

    font-size:13px;

    font-weight:700;

    margin-top:3px;

}

/* ==========================
   FORM PENCARIAN
========================== */

.form-pencarian{

    display:flex;

    align-items:center;

    justify-content:flex-end;

    gap:8px;

}

.form-pencarian .form-control{

    width:220px;

    height:42px;

    padding:0 14px;

    border-radius:12px;

    font-size:14px;

}

.form-pencarian .btn{

    height:42px;

    min-width:100px;

    padding:0 16px;

    border-radius:12px;

    font-size:13px;

    font-weight:700;

    display:flex;

    align-items:center;

    justify-content:center;

}

/* ==========================
   BUTTON TAMPILKAN
========================== */

.btn-tampilkan{

    height:42px !important;

    min-width:105px;

    padding:0 18px;

    border-radius:12px;

    font-size:13px;

    font-weight:700;

}

/* ==========================
   ALERT
========================== */

.alert{

    border-radius:12px;

    padding:12px 16px;

    font-size:14px;

}

/* ==========================================================
   TABLE
========================================================== */

.table-responsive{

    border-radius:16px;

}

.table-pengeluaran{

    width:100%;

    border-collapse:collapse;

    margin-bottom:0;

}

.table{

    margin-bottom:0;

}

/* ==========================
   HEADER
========================== */

.table-pengeluaran thead{

    background:#f8fafc;

}

.table-pengeluaran thead th{

    padding:14px 10px;

    text-align:center;

    font-size:13px;

    font-weight:700;

    color:#475569;

    text-transform:uppercase;

    letter-spacing:.4px;

    border-bottom:1px solid #e5e7eb;

    white-space:nowrap;

}

/* ==========================
   BODY
========================== */

.table-pengeluaran tbody td{

    padding:13px 10px;

    font-size:14px;

    color:#1e293b;

    border-bottom:1px solid #eef2f7;

    vertical-align:middle;

    text-align:center;

}

.table-pendapatan tbody tr:last-child td{

    border-bottom:none;

}

.table-pengeluaran tbody tr{

    transition:.2s ease;

}

.table-pengeluaran tbody tr:hover{

    background:#f8fbff;

}

/* ==========================
   KOLOM
========================== */

.col-no{

    width:55px;

    text-align:center;

}

.col-tanggal{

    width:120px;

    text-align:center;

    white-space:nowrap;

}

.col-nama{

    width:auto;

    text-align:left !important;

}

.col-jenis{

    width:150px;

    text-align:center;

}

.col-jumlah{

    width:80px;

    text-align:center;

}

.col-harga{

    width:130px;

    text-align:center;

    white-space:nowrap;

}

.col-total{

    width:150px;

    text-align:center;

    white-space:nowrap;

    font-weight:700;

}

.col-aksi{

    width:160px;

    text-align:center;

}

/* ==========================
   ISI
========================== */

.nama-barang{

    word-break:break-word;

}

.nominal{

    white-space:nowrap;

}

/* ==========================
   BADGE JENIS
========================== */

.table-pengeluaran .badge{

    padding:6px 14px;

    border-radius:999px;

    font-size:12px;

    font-weight:600;

}

/* ==========================
   BUTTON AKSI
========================== */

.col-aksi .d-flex{

    justify-content:center;

    align-items:center;

    gap:8px;

}

.col-aksi .btn{

    min-width:68px;

    height:36px;

    border-radius:10px;

    padding:0 12px;

    display:inline-flex;

    justify-content:center;

    align-items:center;

    gap:6px;

    font-size:13px;

    font-weight:600;

    transition:.2s;

}

.col-aksi .btn:hover{

    transform:translateY(-1px);

}

.btn-edit{

    border-color:#2563eb;

    color:#2563eb;

}

.btn-hapus{

    background:#dc2626;

    border-color:#dc2626;

}

/* ==========================
   PAGINATION
========================== */

.pagination{

    gap:8px;

}

.pagination .page-link{

    border:none;

    border-radius:10px;

    min-width:38px;

    height:38px;

    display:flex;

    justify-content:center;

    align-items:center;

    color:#12365f;

    font-size:13px;

    font-weight:700;

}

.pagination .page-item.active .page-link{

    background:#12365f;

    color:#ffffff;

}

.pagination .page-link:hover{

    background:#edf6ff;

}

/* ==========================
   RESPONSIVE
========================== */

@media(max-width:992px){

    .dash-panel-header{

        flex-direction:column;

        align-items:flex-start!important;

        gap:16px;

    }

    .table-responsive{

        overflow:auto;

    }

    .table-pengeluaran{

        min-width:1050px;

    }

}

</style>

<div class="dash-panel-card-pro mb-4">

    <div class="dash-panel-header d-flex justify-content-between align-items-center">

        <h3 class="page-title mb-0" id="formTitle">
            Input Pengeluaran
        </h3>

        @if(isset($laporanFinal) && $laporanFinal)

<div class="ms-auto">

    <span class="badge bg-success rounded-pill px-3 py-2">

        Laporan Bulan Ini Sudah Final

    </span>

</div>

@endif

    </div>

    <div class="dash-panel-body">

        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif

        @if(session('error'))

            <div class="alert alert-danger">
                {{ session('error') }}
            </div>

        @endif

        @if($errors->any())

            <div class="alert alert-danger">

                <ul class="mb-0">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form
            id="pengeluaranForm"
            action="{{ route('admin.pengeluaran.store') }}"
            method="POST"
        >

            @csrf

            <input
                type="hidden"
                name="_method"
                id="formMethod"
                value="POST"
            >

            <div class="row g-3">

    {{-- TANGGAL --}}
    <div class="col-md-4">

        <label class="form-label">
            Tanggal
        </label>

        <input
            type="date"
            name="tanggal"
            id="tanggalInput"
            class="form-control"
            value="{{ date('Y-m-d') }}"
            required
            {{ isset($laporanFinal) && $laporanFinal ? 'disabled' : '' }}
        >

    </div>

    {{-- NAMA PENGELUARAN --}}
    <div class="col-md-4">

        <label class="form-label">
            Nama Pengeluaran
        </label>

        <input
            type="text"
            name="nama_barang"
            id="namaBarangInput"
            class="form-control"
            placeholder="Contoh: Pembelian Kertas A4"
            required
            {{ isset($laporanFinal) && $laporanFinal ? 'disabled' : '' }}
        >

    </div>

    {{-- JENIS PENGELUARAN --}}
    <div class="col-md-4">

        <label class="form-label">
            Jenis Pengeluaran
        </label>

        <select
            name="jenis_pengeluaran"
            id="jenisPengeluaranInput"
            class="form-select"
            required
            {{ isset($laporanFinal) && $laporanFinal ? 'disabled' : '' }}
        >

            <option value="">
                -- Pilih Jenis Pengeluaran --
            </option>

            <option value="Pembelian Persediaan">
                Pembelian Persediaan
            </option>

            <option value="Operasional Lainnya">
                Operasional Lainnya
            </option>

        </select>

    </div>

    {{-- JUMLAH --}}
    <div class="col-md-2">

        <label class="form-label">
            Jumlah
        </label>

        <input
            type="number"
            name="jumlah"
            id="jumlahInput"
            class="form-control"
            min="1"
            required
            {{ isset($laporanFinal) && $laporanFinal ? 'disabled' : '' }}
        >

    </div>

    {{-- HARGA --}}
    <div class="col-md-3">

        <label class="form-label">
            Harga
        </label>

        <input
            type="number"
            name="harga"
            id="hargaInput"
            class="form-control"
            min="0"
            required
            {{ isset($laporanFinal) && $laporanFinal ? 'disabled' : '' }}
        >

    </div>

    {{-- TOTAL --}}
    <div class="col-md-3">

        <label class="form-label">
            Total Harga
        </label>

        <input
            type="text"
            id="totalHargaView"
            class="form-control"
            value="Rp 0"
            readonly
        >

    </div>

</div>

         @if(!isset($laporanFinal) || !$laporanFinal)

    <div class="d-flex gap-2 mt-4">

        <button
            type="submit"
            class="btn btn-primary"
            id="submitButton"
        >
            Simpan Pengeluaran
        </button>

        <button
            type="button"
            class="btn btn-outline-secondary d-none"
            id="cancelEditButton"
        >
            Batal Edit
        </button>

    </div>

@endif

        </form>

    </div>

</div>

<div class="dash-panel-card-pro">

    <div class="dash-panel-header d-flex justify-content-between align-items-center">

        <div class="d-flex align-items-center gap-3">

            <h3 class="page-title mb-0">
                Data Pengeluaran
            </h3>

            <span class="total-data-chip">
                Total Data : {{ $pengeluarans->total() }}
            </span>

        </div>

        <form
            class="form-pencarian"
            method="GET"
            action="{{ route('admin.pengeluaran.index') }}"
        >

            <input
                type="text"
                id="searchInput"
                name="search"
                class="form-control"
                placeholder="Cari Transaksi..."
                value="{{ request('search') }}"
            >

            <button
                type="submit"
                class="btn btn-primary btn-tampilkan"
            >
                Tampilkan
            </button>

            @if(request('search'))

                <a
                    href="{{ route('admin.pengeluaran.index') }}"
                    class="btn btn-reset"
                >
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Reset
                </a>

            @endif

        </form>

    </div>

    <div class="dash-panel-body">

        @if($pengeluarans->isEmpty())

            @if(request('search'))

                <div class="alert alert-warning text-center mb-0">

                    <i class="bi bi-search me-2"></i>

                    Data pengeluaran yang dicari tidak ditemukan.

                </div>

            @else

                <div class="alert alert-light border mb-0">

                    Belum ada data pengeluaran.

                </div>

            @endif

        @else

            <div class="table-responsive">

                <table class="table table-pengeluaran align-middle mb-0">

                   <thead>

    <tr>

        <th class="col-no">
            No.
        </th>

        <th class="col-tanggal">
            Tanggal
        </th>

        <th class="col-nama">
            Nama Pengeluaran
        </th>

        <th class="col-jenis">
            Jenis
        </th>

        <th class="col-jumlah">
            Jumlah
        </th>

        <th class="col-harga">
            Harga
        </th>

        <th class="col-total">
            Total
        </th>

        <th class="col-aksi">
            Aksi
        </th>

    </tr>

</thead>

<tbody>

@foreach($pengeluarans as $item)

<tr>

    <td class="col-no">
        {{ $pengeluarans->firstItem() + $loop->index }}
    </td>

    <td class="col-tanggal">
        {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
    </td>

    <td class="col-nama nama-barang">
        {{ $item->nama_barang }}
    </td>

    <td class="col-jenis">

        @if($item->jenis_pengeluaran == 'Pembelian Persediaan')

            <span class="badge bg-primary">
                Persediaan
            </span>

        @else

            <span class="badge bg-warning text-dark">
                Operasional
            </span>

        @endif

    </td>

    <td class="col-jumlah">
        {{ $item->jumlah }}
    </td>

    <td class="col-harga nominal">

        Rp {{ number_format($item->harga,0,',','.') }}

    </td>

    <td class="col-total nominal fw-bold">

        Rp {{ number_format($item->total,0,',','.') }}

    </td>

    <td class="col-aksi">

        @if(isset($laporanFinal) && $laporanFinal)

            <span class="text-muted small fw-semibold">

                Terkunci

            </span>

        @else

            <div class="d-flex justify-content-center gap-2">

                <button
                    type="button"
                    class="btn btn-sm btn-outline-primary btn-edit"
                    data-update-url="{{ route('admin.pengeluaran.update',$item->id) }}"
                    data-tanggal="{{ $item->tanggal }}"
                    data-nama-barang="{{ $item->nama_barang }}"
                    data-jenis="{{ $item->jenis_pengeluaran }}"
                    data-jumlah="{{ $item->jumlah }}"
                    data-harga="{{ $item->harga }}"
                >

                    <i class="bi bi-pencil-square"></i>

                    Edit

                </button>

                <form
                    action="{{ route('admin.pengeluaran.destroy',$item->id) }}"
                    method="POST"
                    class="form-hapus"
                >

                    @csrf

                    @method('DELETE')

                    <button
                        type="button"
                        class="btn btn-danger btn-sm btn-hapus"
                    >

                        <i class="bi bi-trash3"></i>

                        Hapus

                    </button>

                </form>

            </div>

        @endif

    </td>

</tr>

@endforeach

</tbody>
        </table>

        </div>

        <div class="mt-4 d-flex justify-content-center">

            {{ $pengeluarans->links() }}

        </div>

    @endif

    </div>

</div>

@endsection

@push('scripts')

<script>

    const storeUrl = "{{ route('admin.pengeluaran.store') }}";

    const formTitle = document.getElementById('formTitle');
    const pengeluaranForm = document.getElementById('pengeluaranForm');
    const formMethod = document.getElementById('formMethod');
    const submitButton = document.getElementById('submitButton');
    const cancelEditButton = document.getElementById('cancelEditButton');

    const tanggalInput = document.getElementById('tanggalInput');
    const namaBarangInput = document.getElementById('namaBarangInput');
    const jenisPengeluaranInput = document.getElementById('jenisPengeluaranInput');
    const jumlahInput = document.getElementById('jumlahInput');
    const hargaInput = document.getElementById('hargaInput');
    const totalHargaView = document.getElementById('totalHargaView');

    function formatRupiah(angka) {

        return 'Rp ' + Number(angka || 0).toLocaleString('id-ID');

    }

    function hitungTotal() {

        const jumlah = parseInt(jumlahInput.value) || 0;
        const harga = parseFloat(hargaInput.value) || 0;

        totalHargaView.value = formatRupiah(jumlah * harga);

    }

    function resetForm() {

        pengeluaranForm.action = storeUrl;

        formMethod.value = 'POST';

        formTitle.textContent = 'Input Pengeluaran';

        if(submitButton){

            submitButton.textContent = 'Simpan Pengeluaran';

        }

        if(cancelEditButton){

            cancelEditButton.classList.add('d-none');

        }

        tanggalInput.value = "{{ date('Y-m-d') }}";

        namaBarangInput.value = '';

        jenisPengeluaranInput.value = '';

        jumlahInput.value = '';

        hargaInput.value = '';

        totalHargaView.value = 'Rp 0';

    }

    jumlahInput?.addEventListener('input', hitungTotal);

    hargaInput?.addEventListener('input', hitungTotal);

    document.querySelectorAll('.btn-edit').forEach(button => {

        button.addEventListener('click', function () {

            pengeluaranForm.action = this.dataset.updateUrl;

            formMethod.value = 'PUT';

            formTitle.textContent = 'Edit Pengeluaran';

            submitButton.textContent = 'Simpan Perubahan';

            cancelEditButton.classList.remove('d-none');

            tanggalInput.value = this.dataset.tanggal;

            namaBarangInput.value = this.dataset.namaBarang;

            jenisPengeluaranInput.value = this.dataset.jenis;

            jumlahInput.value = this.dataset.jumlah;

            hargaInput.value = this.dataset.harga;

            hitungTotal();

            window.scrollTo({

                top: 0,

                behavior: 'smooth'

            });

        });

    });

    if(cancelEditButton){

        cancelEditButton.addEventListener('click', resetForm);

    }

    document.querySelectorAll('.btn-hapus').forEach(button => {

        button.addEventListener('click', function () {

            const form = this.closest('.form-hapus');

            Swal.fire({

                title: 'Hapus Data?',
                text: 'Apakah Anda yakin ingin menghapus data pengeluaran ini?',
                icon: 'warning',

                showCancelButton: true,

                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',

                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'

            }).then((result) => {

                if (result.isConfirmed) {

                    form.submit();

                }

            });

        });

    });

    document.addEventListener('DOMContentLoaded', hitungTotal);

/*
|--------------------------------------------------------------------------
| PENCARIAN OTOMATIS
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchInput');

    if (!searchInput) return;

    searchInput.addEventListener('input', function () {

        if (this.value.trim() === '') {

            window.location.href = "{{ route('admin.pengeluaran.index') }}";

        }

    });

});

</script>

@endpush