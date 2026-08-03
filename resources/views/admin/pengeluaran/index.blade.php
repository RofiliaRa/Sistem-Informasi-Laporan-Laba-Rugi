@extends('layouts.dashboard')

@section('content')

{{-- PAGE HEADER / INPUT PENGELUARAN PANEL --}}
<div class="dash-panel-card-pro mb-4">
    <div class="dash-panel-header d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
        <h3 class="page-title mb-0" id="formTitle">
            Input Pengeluaran
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

        <form
            id="pengeluaranForm"
            action="{{ route('admin.pengeluaran.store') }}"
            method="POST"
        >
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

                {{-- NAMA PENGELUARAN --}}
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold">Nama Pengeluaran</label>
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
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold">Jenis Pengeluaran</label>
                    <select
                        name="jenis_pengeluaran"
                        id="jenisPengeluaranInput"
                        class="form-select"
                        required
                        {{ isset($laporanFinal) && $laporanFinal ? 'disabled' : '' }}
                    >
                        <option value="">-- Pilih Jenis Pengeluaran --</option>
                        <option value="Pembelian Persediaan">Pembelian Persediaan</option>
                        <option value="Operasional Lainnya">Operasional Lainnya</option>
                    </select>
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
                        <i class="bi bi-save me-1"></i> Simpan Pengeluaran
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

{{-- DATA PENGELUARAN PANEL --}}
<div class="dash-panel-card-pro">
    <div class="dash-panel-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <h3 class="mb-0 fw-bold">Data Pengeluaran</h3>
            <span class="total-data-chip">
                Total {{ $pengeluarans->total() }} Data
            </span>
        </div>

        <form
            class="d-flex align-items-center justify-content-end gap-2"
            method="GET"
            action="{{ route('admin.pengeluaran.index') }}"
        >
            <input
            type="text"
            id="searchInput"
            name="search"
            placeholder="Cari Transaksi..."
            class="form-control"
            style="width: 300px;"
            value="{{ request('search') }}"
            class="d-flex align-items-center gap-2 w-100 w-md-auto"
            method="GET"
            action="{{ route('admin.pendapatan.index') }}"
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
            <table class="table table-pengeluaran text-nowrap align-middle mb-0">
                <thead>
                    <tr>
                        <th width="60" class="text-center">No</th>
                        <th width="120" class="text-center">Tanggal</th>
                        <th class="text-start">Nama Pengeluaran</th>
                        <th width="160" class="text-center">Jenis</th>
                        <th width="80" class="text-center">Jumlah</th>
                        <th width="140" class="text-center">Harga</th>
                        <th width="160" class="text-center">Total</th>
                        <th width="160" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($pengeluarans as $item)
                    <tr>
                        <td class="text-center">
                            {{ $pengeluarans->firstItem() + $loop->index }}
                        </td>

                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                        </td>

                        <td class="text-start fw-semibold">
                            {{ $item->nama_barang }}
                        </td>

                        <td class="text-center">
                            @if($item->jenis_pengeluaran == 'Pembelian Persediaan')
                                <span class="badge bg-primary rounded-pill px-3 py-2 badge-fixed">
                                    Persediaan
                                </span>
                            @else
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2 badge-fixed">
                                    Operasional
                                </span>
                            @endif
                        </td>

                        <td class="text-center">
                            {{ number_format($item->jumlah, 0, ',', '.') }}
                        </td>

                        <td class="text-end">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </td>

                        <td class="text-end fw-bold text-danger">
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
                                        data-update-url="{{ route('admin.pengeluaran.update', $item->id) }}"
                                        data-tanggal="{{ $item->tanggal }}"
                                        data-nama-barang="{{ $item->nama_barang }}"
                                        data-jenis="{{ $item->jenis_pengeluaran }}"
                                        data-jumlah="{{ $item->jumlah }}"
                                        data-harga="{{ $item->harga }}"
                                    >
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </button>

                                    <form
                                        action="{{ route('admin.pengeluaran.destroy', $item->id) }}"
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
                        'message' => request('search') ? 'Data pengeluaran yang dicari tidak ditemukan.' : 'Belum ada data pengeluaran.'
                    ])
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $pengeluarans->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    
        /*
    |--------------------------------------------------------------------------
    | FLATPICKR TANGGAL
    |--------------------------------------------------------------------------
    */

    flatpickr("#tanggalInput", {

        locale: "id",

        dateFormat: "Y-m-d",

        altInput: true,

        altFormat: "d F Y",

        allowInput: false,

        defaultDate: document.getElementById("tanggalInput").value

    });
    
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
            submitButton.innerHTML = '<i class="bi bi-save me-1"></i> Simpan Pengeluaran';
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

            if(submitButton){
                submitButton.innerHTML = '<i class="bi bi-pencil-square me-1"></i> Simpan Perubahan';
            }

            if(cancelEditButton){
                cancelEditButton.classList.remove('d-none');
            }

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
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            if (this.value.trim() === '') {
                window.location.href = "{{ route('admin.pengeluaran.index') }}";
            }
        });
    }

    hitungTotal();
});
</script>
@endpush

@endsection