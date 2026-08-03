@extends('layouts.dashboard')

@section('content')

{{-- PAGE HEADER / INPUT PENDAPATAN PANEL --}}
<div class="dash-panel-card-pro mb-4">
    <div class="dash-panel-header d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
        <h3 class="page-title mb-0" id="formTitle">
            Input Pendapatan
        </h3>

        @if(isset($laporanFinal) && $laporanFinal)
            <div class="ms-sm-auto">
                <span class="badge bg-success rounded-pill px-3 py-2">
                    <i class="bi bi-check-circle-fill me-1"></i> Laporan Bulan Ini Sudah Final
                </span>
            </div>
        @endif
    </div>

    <div class="dash-panel-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form id="pendapatanForm" action="{{ route('admin.pendapatan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="row g-3">
                {{-- TANGGAL --}}
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold">Tanggal</label>
<input
    type="text"
    name="tanggal"
    id="tanggalInput"
    class="form-control"
    value="{{ date('Y-m-d') }}"
    autocomplete="off"
    required
    {{ isset($laporanFinal) && $laporanFinal ? 'disabled' : '' }}
>
                </div>

                {{-- KATEGORI --}}
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold">Kategori</label>
                    <select
                        name="category_id"
                        id="categorySelect"
                        class="form-select"
                        required
                        {{ isset($laporanFinal) && $laporanFinal ? 'disabled' : '' }}
                    >
                        <option value="">-- Pilih Kategori --</option>
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
                <div class="col-12 col-md-4 d-none" id="jasaSelectWrapper">
                    <label class="form-label fw-semibold">Nama Jasa</label>
                    <select id="jasaSelect" class="form-select">
                        <option value="">-- Pilih Jasa --</option>
                        <option value="Print Hitam Putih" data-harga="500" data-type="fixed">Print Hitam Putih</option>
                        <option value="Print Warna Non Full" data-harga="1000" data-type="fixed">Print Warna Non Full</option>
                        <option value="Print Warna Full" data-harga="1500" data-type="fixed">Print Warna Full</option>
                        <option value="Cetak Foto Ukuran 2x3" data-harga="500" data-type="fixed">Cetak Foto Ukuran 2x3</option>
                        <option value="Cetak Foto Ukuran 3x4" data-harga="750" data-type="fixed">Cetak Foto Ukuran 3x4</option>
                        <option value="Cetak Foto Ukuran 4x6" data-harga="1000" data-type="fixed">Cetak Foto Ukuran 4x6</option>
                        <option value="Cetak Foto Ukuran 2R" data-harga="2000" data-type="fixed">Cetak Foto Ukuran 2R</option>
                        <option value="Cetak Foto Ukuran 3R" data-harga="3000" data-type="fixed">Cetak Foto Ukuran 3R</option>
                        <option value="Cetak Foto Ukuran 4R" data-harga="4000" data-type="fixed">Cetak Foto Ukuran 4R</option>
                        <option value="Cetak Foto Ukuran 5R" data-harga="5000" data-type="fixed">Cetak Foto Ukuran 5R</option>
                        <option value="Cetak Foto Ukuran 6R" data-harga="6000" data-type="fixed">Cetak Foto Ukuran 6R</option>
                        <option value="Cetak Foto Ukuran 8R" data-harga="7000" data-type="fixed">Cetak Foto Ukuran 8R</option>
                        <option value="Fotokopi" data-harga="0" data-type="fotokopi">Fotokopi</option>
                        <option value="Fotokopi Bolak Balik" data-harga="500" data-type="fixed">Fotokopi Bolak Balik</option>
                        <option value="Fotokopi Ukuran A3" data-harga="1500" data-type="fixed">Fotokopi Ukuran A3</option>
                        <option value="Laminating Dokumen A4/F4" data-harga="3500" data-type="fixed">Laminating Dokumen A4/F4</option>
                        <option value="Laminating Dokumen Kecil Seukuran KTP" data-harga="2000" data-type="fixed">Laminating Dokumen Kecil Seukuran KTP</option>
                        <option value="Jilid Lakban" data-harga="3000" data-type="fixed">Jilid Lakban</option>
                    </select>
                </div>

                {{-- INPUT BARANG --}}
                <div class="col-12 col-md-4" id="manualNamaWrapper">
                    <label class="form-label fw-semibold">Nama Barang</label>
                    <input
                        type="text"
                        name="nama_barang"
                        id="namaBarangInput"
                        class="form-control"
                        placeholder="Contoh: Kertas A4, Pulpen, Map"
                        required
                        {{ isset($laporanFinal) && $laporanFinal ? 'disabled' : '' }}
                    >
                </div>

                {{-- JUMLAH --}}
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold">Jumlah</label>
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
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold">Harga (Satuan)</label>
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
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold">Total Harga</label>
                    <input
                        type="text"
                        id="totalHargaView"
                        class="form-control bg-light fw-bold text-end"
                        value="Rp 0"
                        readonly
                    >
                </div>
            </div>

            @if(!isset($laporanFinal) || !$laporanFinal)
                <div class="btn-form-mobile-full d-flex flex-column flex-md-row gap-2 mt-4">
                    <button
                        type="submit"
                        class="btn btn-primary px-4 py-2"
                        id="submitButton"
                    >
                        <i class="bi bi-save me-1"></i> Simpan Pendapatan
                    </button>

                    <button
                        type="button"
                        class="btn btn-outline-secondary px-4 py-2 d-none"
                        id="cancelEditButton"
                    >
                        <i class="bi bi-x-circle me-1"></i> Batal Edit
                    </button>
                </div>
            @endif
        </form>
    </div>
</div>

{{-- DATA PENDAPATAN PANEL --}}
<div class="dash-panel-card-pro">
    <div class="dash-panel-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <h3 class="mb-0 fw-bold">Data Pendapatan</h3>
            <span class="total-data-chip">
                Total {{ $pendapatans->total() }} Data
            </span>
        </div>

        <form
            class="d-flex align-items-center justify-content-end gap-2"
            method="GET"
            action="{{ route('admin.pendapatan.index') }}"
        >
            <input
            type="text"
            id="searchInput"
            name="search"
            placeholder="Cari Transaksi..."
            class="form-control"
            style="width: 300px;"
            value="{{ request('search') }}"
        >

            <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center gap-2 px-3">
            <i class="bi bi-search"></i>
            <span>Cari</span>
            </button>

            @if(request('search'))
                <a href="{{ route('admin.pendapatan.index') }}" class="btn btn-secondary d-flex align-items-center justify-content-center gap-2 px-3">
                <i class="bi bi-arrow-clockwise"></i>
                    <span>Reset</span>
                </a>
            @endif
        </form>
    </div>

    <div class="dash-panel-body">
        <div class="table-responsive">
            <table class="table table-pendapatan text-nowrap align-middle mb-0">
                <thead>
                    <tr>
                        <th width="60" class="text-center">No</th>
                        <th width="120" class="text-center">Tanggal</th>
                        <th width="140" class="text-center">Kategori</th>
                        <th class="text-start">Nama Barang / Jasa</th>
                        <th width="70" class="text-center">Jumlah</th>
                        <th width="110" class="text-center">Harga</th>
                        <th width="120" class="text-center">Total</th>
                        <th width="160" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($pendapatans as $item)
                    <tr>
                        <td class="text-center">
                            {{ $pendapatans->firstItem() + $loop->index }}
                        </td>

                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                        </td>

                        <td class="text-center">
                            @if(strtolower($item->category->nama_kategori ?? '') == 'jasa')
                                <span class="badge bg-primary rounded-pill px-3 py-2 badge-fixed">
                                    Jasa
                                </span>
                            @else
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2 badge-fixed">
                                    {{ $item->category->nama_kategori ?? 'ATK & Lainnya' }}
                                </span>
                            @endif
                        </td>

                        <td class="text-start fw-semibold">
                            {{ $item->nama_barang }}
                        </td>

                        <td class="text-center">
                            {{ number_format($item->jumlah, 0, ',', '.') }}
                        </td>

                        <td class="text-center">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </td>

                        <td class="text-center fw-bold text-success">
                            Rp {{ number_format($item->total, 0, ',', '.') }}
                        </td>

                        <td class="text-center">
                            @if(isset($laporanFinal) && $laporanFinal)
                                <span class="badge bg-secondary rounded-pill px-3 py-2">
                                    Terkunci
                                </span>
                            @else
                                <div class="action-group justify-content-center">
                                    <button
                                        type="button"
                                        class="btn btn-outline-primary btn-action btn-edit"
                                        data-update-url="{{ route('admin.pendapatan.update', $item->id) }}"
                                        data-tanggal="{{ $item->tanggal }}"
                                        data-category-id="{{ $item->category_id }}"
                                        data-category-name="{{ strtolower($item->category->nama_kategori ?? '') }}"
                                        data-nama-barang="{{ $item->nama_barang }}"
                                        data-jumlah="{{ $item->jumlah }}"
                                        data-harga="{{ $item->harga }}"
                                    >
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </button>

                                    <form
                                        action="{{ route('admin.pendapatan.destroy', $item->id) }}"
                                        method="POST"
                                        class="form-hapus d-inline"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="button"
                                            class="btn btn-outline-danger btn-action btn-hapus"
                                        >
                                            <i class="bi bi-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    @include('partials.empty-table', [
                        'colspan' => 8,
                        'message' => request('search') ? 'Data pendapatan yang dicari tidak ditemukan.' : 'Belum ada data pendapatan.'
                    ])
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $pendapatans->links() }}
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script>
    
    /*
|--------------------------------------------------------------------------
| FLATPICKR TANGGAL
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", function () {

    flatpickr("#tanggalInput", {

        locale: "id",

        dateFormat: "Y-m-d",

        altInput: true,

        altFormat: "d F Y",

        allowInput: false,

        defaultDate: document.getElementById("tanggalInput").value

    });

});

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