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

.table-pendapatan{

    width:100%;

    border-collapse:collapse;

    margin-bottom:0;

}

/* ==========================
   HEADER
========================== */

.table-pendapatan thead{

    background:#f8fafc;

}

.table-pendapatan thead th{

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

.table-pendapatan tbody td{

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

.table-pendapatan tbody tr{

    transition:.2s ease;

}

.table-pendapatan tbody tr:hover{

    background:#f8fbff;

}

/* ==========================
   LEBAR KOLOM
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

    width:140px;

    text-align:center;

    white-space:nowrap;

    font-weight:700;

}

.col-aksi{

    width:170px;

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

    .table-pendapatan{

        min-width:1000px;

    }

}
</style>

<div class="dash-panel-card-pro mb-4">

    <div class="dash-panel-header d-flex justify-content-between align-items-center">

        <h3 class="page-title mb-0" id="formTitle">
            Input Pendapatan
        </h3>


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

        <form id="pendapatanForm" action="{{ route('admin.pendapatan.store') }}" method="POST">

            @csrf

            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="row g-3">

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
                    >

                </div>

                <div class="col-md-4">

                    <label class="form-label">
                        Kategori
                    </label>

                    <select
                        name="category_id"
                        id="categorySelect"
                        class="form-select"
                        required
                    >

                        <option value="">
                            -- Pilih Kategori --
                        </option>

                        @foreach($categories as $cat)

                            <option
                                value="{{ $cat->id }}"
                                data-name="{{ strtolower($cat->nama_kategori) }}"
                            >
                                {{ $cat->nama_kategori }}
                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- LIST JASA --}}

                <div class="col-md-4 d-none" id="jasaSelectWrapper">

                    <label class="form-label">
                        Nama Jasa
                    </label>

                    <select
                        id="jasaSelect"
                        class="form-select"
                    >

                        <option value="">
                            -- Pilih Jasa --
                        </option>

                        <option value="Print Hitam Putih" data-harga="500" data-type="fixed">
                            Print Hitam Putih
                        </option>

                        <option value="Print Warna Non Full" data-harga="1000" data-type="fixed">
                            Print Warna Non Full
                        </option>

                        <option value="Print Warna Full" data-harga="1500" data-type="fixed">
                            Print Warna Full
                        </option>

                        <option value="Cetak Foto Ukuran 2x3" data-harga="500" data-type="fixed">
                            Cetak Foto Ukuran 2x3
                        </option>

                        <option value="Cetak Foto Ukuran 3x4" data-harga="750" data-type="fixed">
                            Cetak Foto Ukuran 3x4
                        </option>

                        <option value="Cetak Foto Ukuran 4x6" data-harga="1000" data-type="fixed">
                            Cetak Foto Ukuran 4x6
                        </option>

                        <option value="Cetak Foto Ukuran 2R" data-harga="2000" data-type="fixed">
                            Cetak Foto Ukuran 2R
                        </option>

                        <option value="Cetak Foto Ukuran 3R" data-harga="3000" data-type="fixed">
                            Cetak Foto Ukuran 3R
                        </option>

                        <option value="Cetak Foto Ukuran 4R" data-harga="4000" data-type="fixed">
                            Cetak Foto Ukuran 4R
                        </option>

                        <option value="Cetak Foto Ukuran 5R" data-harga="5000" data-type="fixed">
                            Cetak Foto Ukuran 5R
                        </option>

                        <option value="Cetak Foto Ukuran 6R" data-harga="6000" data-type="fixed">
                            Cetak Foto Ukuran 6R
                        </option>

                        <option value="Cetak Foto Ukuran 8R" data-harga="7000" data-type="fixed">
                            Cetak Foto Ukuran 8R
                        </option>

                        <option value="Fotokopi" data-harga="0" data-type="fotokopi">
                            Fotokopi
                        </option>

                        <option value="Fotokopi Bolak Balik" data-harga="500" data-type="fixed">
                            Fotokopi Bolak Balik
                        </option>

                        <option value="Fotokopi Ukuran A3" data-harga="1000" data-type="fixed">
                            Fotokopi Ukuran A3
                        </option>

                        <option value="Laminating Dokumen A4/F4" data-harga="3500" data-type="fixed">
                            Laminating Dokumen A4/F4
                        </option>

                        <option value="Laminating Dokumen Kecil Seukuran KTP" data-harga="2000" data-type="fixed">
                            Laminating Dokumen Kecil Seukuran KTP
                        </option>

                        <option value="Jilid Lakban" data-harga="3000" data-type="fixed">
                            Jilid Lakban
                        </option>

                    </select>

                </div>

                {{-- INPUT BARANG --}}

                <div class="col-md-4" id="manualNamaWrapper">

                    <label class="form-label">
                        Nama Barang
                    </label>

                    <input
                        type="text"
                        name="nama_barang"
                        id="namaBarangInput"
                        class="form-control"
                        placeholder="Contoh: Kertas A4, Pulpen, Map"
                        required
                    >

                </div>

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
                    >

                </div>

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
                    >

                </div>

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

            <div class="d-flex gap-2 mt-4">

                <button
                    type="submit"
                    class="btn btn-primary"
                    id="submitButton"
                >
                    Simpan Pendapatan
                </button>

                <button
                    type="button"
                    class="btn btn-outline-secondary d-none"
                    id="cancelEditButton"
                >
                    Batal Edit
                </button>

            </div>

        </form>

    </div>

</div>

<div class="dash-panel-card-pro">

    <div class="dash-panel-header d-flex justify-content-between align-items-center">

    <div class="d-flex align-items-center gap-3">

        <h3 class="page-title mb-0">
    Data Pendapatan
</h3>

        <span class="total-data-chip">
            Total Data : {{ $pendapatans->total() }}
        </span>

    </div>

    <form class="form-pencarian" method="GET" action="{{ route('admin.pendapatan.index') }}">

        <input
            type="text"
            id="searchInput"
            name="search"
            class="form-control"
            placeholder="Cari Transaksi..."
            value="{{ request('search') }}"
        >

        <button type="submit" class="btn btn-primary btn-tampilkan">
            Tampilkan
        </button>

        @if(request('search'))
            <a href="{{ route('admin.pendapatan.index') }}"
               class="btn btn-reset">
                <i class="bi bi-arrow-counterclockwise"></i>
                Reset
            </a>
        @endif

    </form>

</div>

    <div class="dash-panel-body">

        
        @if($pendapatans->isEmpty())

    @if(request('search'))

        <div class="alert alert-warning text-center mb-0">

            <i class="bi bi-search me-2"></i>

            Data pendapatan yang dicari tidak ditemukan.

        </div>

    @else

        <div class="alert alert-light border mb-0">

            Belum ada data pendapatan

        </div>

    @endif

        @else

            <div class="table-responsive">

                <table class="table table-pendapatan align-middle mb-0">

                    <thead>

                        <tr>

                             <th class="col-no text-center">
                                No.
                            </th>

                            <th class="col-tanggal text-center">
                                Tanggal
                            </th>

                           <th class="col-kategori fw-bold">
                                Kategori
                            </th>

                            <th class="col-nama">
                                Nama Barang / Jasa
                            </th>

                            <th class="col-jumlah text-center">
                                Jumlah
                            </th>

                            <th class="col-harga text-center">
                                Harga
                            </th>

                            <th class="col-total text-center">
                                Total
                            </th>

                            <th class="col-aksi text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($pendapatans as $item)

                            <tr>

                                <td class="col-no">
                                    {{ $pendapatans->firstItem() + $loop->index }}
                                </td>

                                <td class="col-tanggal">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                                </td>

                                <td class="col-kategori text-center align-middle">
                                    {{ $item->category->nama_kategori ?? '-' }}
                                </td>

                                <td class="col-nama nama-barang">
                                    {{ $item->nama_barang }}
                                </td>

                                <td class="col-jumlah text-center">
                                    {{ $item->jumlah }}
                                </td>

                                <td class="col-harga nominal text-center">

    Rp {{ number_format($item->harga,0,',','.') }}

</td>

                                <td class="col-total fw-bold nominal text-center">

    Rp {{ number_format($item->total,0,',','.') }}

</td>

                                <td class="col-aksi text-center">

                                    <div class="d-flex justify-content-center gap-2">

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-primary btn-edit"
                                            data-update-url="{{ route('admin.pendapatan.update', $item->id) }}"
                                            data-tanggal="{{ $item->tanggal }}"
                                            data-category-id="{{ $item->category_id }}"
                                            data-category-name="{{ strtolower($item->category->nama_kategori ?? '') }}"
                                            data-nama-barang="{{ $item->nama_barang }}"
                                            data-jumlah="{{ $item->jumlah }}"
                                            data-harga="{{ $item->harga }}"
                                        >
                                             <i class="bi bi-pencil-square"></i>

                                                 Edit

                                            </button>
                                        <form
                                            action="{{ route('admin.pendapatan.destroy', $item->id) }}"
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

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

               </table>

            </div>
<div class="mt-4 d-flex justify-content-center">
    {{ $pendapatans->links() }}
</div>


        @endif

    </div>

</div>

@endsection

@push('scripts')

<script>

const categorySelect = document.getElementById('categorySelect');

const jasaSelectWrapper = document.getElementById('jasaSelectWrapper');
const jasaSelect = document.getElementById('jasaSelect');

const manualNamaWrapper = document.getElementById('manualNamaWrapper');

const namaBarangInput = document.getElementById('namaBarangInput');

const jumlahInput = document.getElementById('jumlahInput');
const hargaInput = document.getElementById('hargaInput');

const totalHargaView = document.getElementById('totalHargaView');

function formatRupiah(angka) {

    return 'Rp ' + Number(angka || 0).toLocaleString('id-ID');

}

function isKategoriJasa(namaKategori) {

    return namaKategori.includes('jasa');

}

function hitungHargaFotokopi(jumlah) {

    if (jumlah >= 1 && jumlah <= 10) return 500;
    if (jumlah >= 11 && jumlah <= 20) return 300;
    if (jumlah > 20) return 250;

    return 0;

}

function tampilkanModeForm() {

    const selected = categorySelect.options[categorySelect.selectedIndex];

    const namaKategori = selected
        ? (selected.getAttribute('data-name') || '')
        : '';

    if (isKategoriJasa(namaKategori)) {

        jasaSelectWrapper.classList.remove('d-none');

        manualNamaWrapper.classList.add('d-none');

        namaBarangInput.removeAttribute('required');

        hargaInput.readOnly = true;

    } else {

        jasaSelectWrapper.classList.add('d-none');

        manualNamaWrapper.classList.remove('d-none');

        namaBarangInput.setAttribute('required', true);

        hargaInput.readOnly = false;

    }

}

function hitungTotal() {

    const jumlah = parseInt(jumlahInput.value) || 0;

    let harga = parseFloat(hargaInput.value) || 0;

    const selectedJasa = jasaSelect.options[jasaSelect.selectedIndex];

    if (selectedJasa) {

        const type = selectedJasa.getAttribute('data-type');

        if (type === 'fotokopi') {

            harga = hitungHargaFotokopi(jumlah);

            hargaInput.value = harga;

        } else {

            const hargaJasa = selectedJasa.getAttribute('data-harga');

            if (hargaJasa) {

                harga = hargaJasa;

                hargaInput.value = hargaJasa;

            }

        }

    }

    totalHargaView.value = formatRupiah(jumlah * harga);

}

categorySelect.addEventListener('change', tampilkanModeForm);

jasaSelect.addEventListener('change', function () {

    namaBarangInput.value = this.value;

    hitungTotal();

});

jumlahInput.addEventListener('input', hitungTotal);

hargaInput.addEventListener('input', hitungTotal);

document.addEventListener('DOMContentLoaded', function () {

    tampilkanModeForm();

    hitungTotal();

});

/*
|--------------------------------------------------------------------------
| EDIT DATA
|--------------------------------------------------------------------------
*/

const pendapatanForm = document.getElementById('pendapatanForm');
const formMethod = document.getElementById('formMethod');

const formTitle = document.getElementById('formTitle');

const submitButton = document.getElementById('submitButton');
const cancelEditButton = document.getElementById('cancelEditButton');

document.querySelectorAll('.btn-edit').forEach(button => {

    button.addEventListener('click', function () {

        pendapatanForm.action = this.dataset.updateUrl;

        formMethod.value = 'PUT';

        formTitle.textContent = 'Edit Pendapatan';

        submitButton.textContent = 'Simpan Perubahan';

        cancelEditButton.classList.remove('d-none');

        document.getElementById('tanggalInput').value = this.dataset.tanggal;

        categorySelect.value = this.dataset.categoryId;

        document.getElementById('namaBarangInput').value = this.dataset.namaBarang;

        jumlahInput.value = this.dataset.jumlah;

        hargaInput.value = this.dataset.harga;

        tampilkanModeForm();

        if (isKategoriJasa(this.dataset.categoryName)) {

            jasaSelect.value = this.dataset.namaBarang;

        }

        hitungTotal();

        window.scrollTo({

            top: 0,
            behavior: 'smooth'

        });

    });

});

/*
|--------------------------------------------------------------------------
| BATAL EDIT
|--------------------------------------------------------------------------
*/

cancelEditButton.addEventListener('click', function () {

    pendapatanForm.action = "{{ route('admin.pendapatan.store') }}";

    formMethod.value = 'POST';

    formTitle.textContent = 'Input Pendapatan';

    submitButton.textContent = 'Simpan Pendapatan';

    cancelEditButton.classList.add('d-none');

    pendapatanForm.reset();

    document.getElementById('totalHargaView').value = 'Rp 0';

    tampilkanModeForm();

});

document.querySelectorAll('.btn-hapus').forEach(button => {

    button.addEventListener('click', function () {

        let form = this.closest('.form-hapus');

        Swal.fire({

            title: 'Hapus Data?',
            text: 'Apakah Anda yakin ingin menghapus data ini?',
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

/*
|--------------------------------------------------------------------------
| PENCARIAN OTOMATIS
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchInput');

    if (!searchInput) return;

    searchInput.addEventListener('input', function () {

        // jika kolom dikosongkan
        if (this.value.trim() === '') {

            window.location.href = "{{ route('admin.pendapatan.index') }}";

        }

    });

});

</script>

@endpush