@extends('layouts.dashboard')

@section('content')

<style>

/* ==========================================================
   RIWAYAT LAPORAN LABA RUGI
========================================================== */

/* ==========================================================
   PAGE HEADER
========================================================== */

.page-header{

    margin-top:-6px;

    margin-bottom:20px;

}

.page-title{

    margin:0;

    font-size:22px;

    font-weight:800;

    color:#0f172a;

    line-height:1.2;

}

.page-subtitle{

    margin-top:8px;

    font-size:16px;

    color:#64748b;

    font-weight:400;

}

/* ==========================
   CARD
========================== */

.dash-panel-card-pro{

    background:#ffffff;

    border:none;

    border-radius:18px;

    box-shadow:0 6px 20px rgba(15,23,42,.06);

    overflow:hidden;

}

.dash-panel-body{

    padding:18px 20px;

}

/* ==========================
   CARD STATISTIK
========================== */

.stat-card{

    height:100%;

}

.stat-card .dash-panel-body{

    min-height:105px;

    padding:16px;

    display:flex;

    flex-direction:column;

    justify-content:center;

    align-items:center;

    text-align:center;

}

/* ==========================
   ICON
========================== */

.stat-icon{

    width:42px;

    height:42px;

    margin:0 auto 10px;

    border-radius:12px;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:18px;

    transition:.25s;

}

.stat-icon.stat-primary{

    background:#eef6ff;

    color:#2563eb;

}

.stat-icon.stat-success{

    background:#ecfdf5;

    color:#16a34a;

}

.stat-icon.stat-warning{

    background:#fffbeb;

    color:#f59e0b;

}

/* ==========================
   TITLE
========================== */

.stat-title{

    font-size:13px;

    font-weight:600;

    color:#64748b;

    margin-bottom:4px;

    line-height:1.4;

}

/* ==========================
   VALUE
========================== */

.stat-value{

    font-size:22px;

    font-weight:800;

    color:#0f172a;

    line-height:1.2;

}

.stat-value.stat-success{

    color:#16a34a;

}

.stat-value.stat-warning{

    color:#f59e0b;

}

.stat-value.stat-primary{

    color:#2563eb;

}

/* ==========================
   HOVER
========================== */

.stat-card:hover{

    transform:translateY(-2px);

    transition:.25s;

}

/* ==========================
   FILTER
========================== */

.filter-card{

     margin-bottom:22px;

}

.form-label{

    font-size:14px;

    font-weight:600;

    color:#475569;

    margin-bottom:6px;

}

.form-control{

    height:44px;

    border-radius:12px;

    border:1px solid #dbe3ec;

    font-size:14px;

    box-shadow:none;

}

.form-control:focus{

    border-color:#2563eb;

    box-shadow:0 0 0 .15rem rgba(37,99,235,.12);

}

/* ==========================
   BUTTON
========================== */

.btn{

    border-radius:12px;

    font-size:14px;

    font-weight:700;

}

.btn-primary,
.btn-secondary,
.btn-success,
.btn-danger,
.btn-outline-danger{

    height:42px;

    display:flex;

    align-items:center;

    justify-content:center;

    gap:6px;

    padding:0 18px;

}

/* ==========================================================
   TABLE
========================================================== */

.table-responsive{

    border-radius:16px;

    overflow:hidden;

}

.riwayat-table{

    width:100%;

    margin-bottom:0;

    border-collapse:collapse;

}

.riwayat-table thead{

    background:#f8fafc;

}

.riwayat-table thead th{

    padding:11px 8px;

    text-align:center;

    vertical-align:middle;

    background:#f8fafc;

    color:#475569;

    font-size:13px;

    font-weight:700;

    border-bottom:1px solid #e5e7eb;

    white-space:nowrap;

}

.riwayat-table tbody td{

    padding:12px 8px;

    text-align:center;

    vertical-align:middle;

    font-size:14px;

    color:#1e293b;

    border-bottom:1px solid #eef2f7;

    transition:.25s;

}

.riwayat-table tbody tr:hover{

    background:#f8fbff;

}

.riwayat-table tbody tr:last-child td{

    border-bottom:none;

}

/* ==========================================================
   NOMINAL
========================================================== */

.nominal-profit{

    color:#16a34a;

    font-weight:700;

}

.nominal-loss{

    color:#dc2626;

    font-weight:700;

}

/* ==========================================================
   STATUS BADGE
========================================================== */

.status-badge{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    min-width:92px;

    height:32px;

    padding:0 16px;

    border-radius:999px;

    font-size:12px;

    font-weight:700;

}

.status-final{

    background:#dcfce7;

    color:#166534;

}

.status-draft{

    background:#fef3c7;

    color:#92400e;

}

.status-lock{

    background:#e5e7eb;

    color:#475569;

}

/* ==========================================================
   ACTION BUTTON
========================================================== */

.action-group{

    display:flex;

    justify-content:center;

    align-items:center;

    gap:10px;

    flex-wrap:nowrap;

}

.action-group form{

    margin:0;

}

.btn-action{

    height:36px;

    min-width:36px;

    padding:0 14px;

    display:flex;

    justify-content:center;

    align-items:center;

    border-radius:10px;

    font-size:13px;

    font-weight:600;

}

.btn-action i{

    font-size:15px;

}

.btn-final{

    background:#198754;

    border-color:#198754;

    color:#ffffff;

}

.btn-final:hover{

    background:#157347;

    border-color:#146c43;

    color:#ffffff;

}

/* ==========================================================
   EMPTY STATE
========================================================== */

.empty-state{

    padding:40px 20px;

    text-align:center;

    color:#94a3b8;

    font-size:15px;

}

.empty-state i{

    font-size:34px;

    margin-bottom:10px;

}

/* ==========================================================
   PANEL HEADER
========================================================== */

.dash-panel-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:16px 20px;

    border-bottom:1px solid #eef2f7;

}

.dash-panel-header h3{

    margin:0;

    font-size:18px;

    font-weight:700;

    color:#12365f;

}

.total-data-chip{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    padding:8px 16px;

    border-radius:999px;

    background:#eef6ff;

    color:#12365f;

    font-size:13px;

    font-weight:700;

}

/* ==========================================================
   PAGINATION
========================================================== */

.pagination{

    gap:6px;

}

.pagination .page-link{

    min-width:40px;

    height:40px;

    display:flex;

    align-items:center;

    justify-content:center;

    border:none;

    border-radius:10px;

    color:#12365f;

    font-size:14px;

    font-weight:600;

}

.pagination .page-item.active .page-link{

    background:#12365f;

    color:#ffffff;

}

.pagination .page-link:hover{

    background:#eaf3fb;

    color:#12365f;

}

.pagination-info{

    font-size:14px;

    color:#64748b;

}

.pagination-info strong{

    color:#12365f;

    font-weight:700;

}

/* ==========================================================
   RESPONSIVE
========================================================== */

@media (max-width:992px){

    .riwayat-table{

        min-width:980px;

    }

    .action-group{

        flex-wrap:wrap;

    }

}

</style>

<div class="container-fluid pt-2 pb-4">

    <!-- ===========================
     PAGE HEADER
=========================== -->

<div class="page-header">

    <div>

        <h1 class="page-title">
            Riwayat Laporan Laba Rugi
        </h1>

        <p class="page-subtitle mb-0">
            Unit Usaha Fotokopi Jayadirana
        </p>

    </div>

</div>

{{-- CARD STATISTIK --}}

<div class="row mb-4">

    {{-- Total Laporan --}}
    <div class="col-md-3 mb-3">

        <div class="dash-panel-card-pro stat-card h-100">

            <div class="dash-panel-body text-center">

                <div class="stat-icon stat-primary">
                    <i class="bi bi-file-earmark-text"></i>
                </div>

                <div class="stat-title">
                    Total Laporan
                </div>

                <div class="stat-value">
                    {{ $totalLaporan }}
                </div>

            </div>

        </div>

    </div>

    {{-- Tahun Aktif --}}
    <div class="col-md-3 mb-3">

        <div class="dash-panel-card-pro stat-card h-100">

            <div class="dash-panel-body text-center">

                <div class="stat-icon stat-primary">
                    <i class="bi bi-calendar3"></i>
                </div>

                <div class="stat-title">
                    Tahun Aktif
                </div>

                <div class="stat-value">
                    {{ now()->year }}
                </div>

            </div>

        </div>

    </div>

    {{-- Laporan Final --}}
    <div class="col-md-3 mb-3">

        <div class="dash-panel-card-pro stat-card h-100">

            <div class="dash-panel-body text-center">

                <div class="stat-icon stat-success">
                    <i class="bi bi-check-circle"></i>
                </div>

                <div class="stat-title">
                    Laporan Final
                </div>

                <div class="stat-value stat-success">
                    {{ $totalFinal }}
                </div>

            </div>

        </div>

    </div>

    {{-- Laporan Draft --}}
    <div class="col-md-3 mb-3">

        <div class="dash-panel-card-pro stat-card h-100">

            <div class="dash-panel-body text-center">

                <div class="stat-icon stat-warning">
                    <i class="bi bi-pencil-square"></i>
                </div>

                <div class="stat-title">
                    Laporan Draft
                </div>

                <div class="stat-value stat-warning">
                    {{ $totalDraft }}
                </div>

            </div>

        </div>

    </div>

</div>

{{-- FILTER PERIODE --}}

<div class="dash-panel-card-pro mb-4">

    <div class="dash-panel-body">

        <form
    method="GET"
    action="{{ auth()->user()->role == 'admin'
        ? route('admin.riwayat.index')
        : route('direktur.riwayat.index') }}"
>

            <div class="row align-items-end g-3">

                <div class="col-lg-4 col-md-5">

                    <label class="form-label">
                        Pilih Periode
                    </label>

                    <input
                        type="month"
                        name="bulan"
                        class="form-control"
                        value="{{ request('bulan', now()->format('Y-m')) }}"
                    >

                </div>

                <div class="col-lg-2 col-md-3">

                    <button
                        type="submit"
                        class="btn btn-primary w-100">

                        <i class="bi bi-search"></i>

                        Tampilkan

                    </button>

                </div>

                <div class="col-lg-2 col-md-3">

                    <a
                        href="{{ auth()->user()->role == 'admin'
                        ? route('admin.riwayat.index')
                        : route('direktur.riwayat.index') }}"

                        class="btn btn-secondary w-100">

                        <i class="bi bi-arrow-clockwise"></i>

                        Reset

                    </a>

                </div>

            </div>

        </form>

    </div>

</div>

{{-- ==========================================================
     DATA RIWAYAT LAPORAN
========================================================== --}}

<div class="dash-panel-card-pro">

    {{-- Header Card --}}
    <div class="dash-panel-header d-flex justify-content-between align-items-center">

        <h3>
            <i class="bi bi-clock-history me-2"></i>
            Data Riwayat Laporan
        </h3>

        <span class="total-data-chip">
            Total {{ $laporans->total() }} Laporan
        </span>

    </div>

    {{-- Body --}}
    <div class="dash-panel-body">

        <div class="table-responsive">

            <table class="riwayat-table">

                <thead>

                    <tr>

                        <th style="width:60px;">No</th>

                        <th>Periode</th>

                        <th>Pendapatan</th>

                        <th>Pengeluaran</th>

                        <th>Laba / Rugi</th>

                        <th>Status</th>

                        <th style="width:90px;">PDF</th>

                       @if(auth()->user()->role == 'admin')

    <th style="width:190px;">
        Aksi
    </th>

@endif

                    </tr>

                </thead>

                <tbody>

                @forelse($laporans as $laporan)

                    <tr>

                        {{-- Nomor --}}
                        <td>
                            {{ $laporans->firstItem() + $loop->index }}
                        </td>

                        {{-- Periode --}}
                        <td>

                            {{ \Carbon\Carbon::create()
                                ->month($laporan->bulan)
                                ->translatedFormat('F') }}

                            {{ $laporan->tahun }}

                        </td>

                        {{-- Pendapatan --}}
                        <td>

                            Rp {{ number_format($laporan->total_pendapatan,0,',','.') }}

                        </td>

                        {{-- Pengeluaran --}}
                        <td>

                            Rp {{ number_format($laporan->total_pengeluaran,0,',','.') }}

                        </td>

                        {{-- Laba / Rugi --}}
                        <td>

                            @if($laporan->laba_bersih >= 0)

                                <span class="nominal-profit">

                                    Rp {{ number_format($laporan->laba_bersih,0,',','.') }}

                                </span>

                            @else

                                <span class="nominal-loss">

                                    Rp {{ number_format(abs($laporan->laba_bersih),0,',','.') }}

                                </span>

                            @endif

                        </td>

                        {{-- Status --}}
                        <td>

                            @if($laporan->status == 'final')

                                <span class="status-badge status-final">

                                    Final

                                </span>

                            @else

                                <span class="status-badge status-draft">

                                    Draft

                                </span>

                            @endif

                        </td>

                        {{-- PDF --}}
                        <td>

                            <a
                                href="{{ auth()->user()->role == 'admin'
    ? route('admin.laporan.pdf', ['bulan' => $laporan->tahun.'-'.str_pad($laporan->bulan,2,'0',STR_PAD_LEFT)])
    : route('direktur.laporan.pdf', ['bulan' => $laporan->tahun.'-'.str_pad($laporan->bulan,2,'0',STR_PAD_LEFT)]) }}"
                                class="btn btn-danger btn-sm btn-action"
                                title="Download PDF">

                                <i class="bi bi-file-earmark-pdf-fill"></i>

                            </a>

                        </td>

                        {{-- Aksi --}}
                        
@if(auth()->user()->role == 'admin')

<td>

    <div class="action-group">

        @if($laporan->status != 'final')

            <form
                action="{{ route('admin.riwayat.finalisasi', $laporan->id) }}"
                method="POST"
                class="form-final"
            >

                @csrf
                @method('PUT')

                <input
    type="hidden"
    name="from"
    value="riwayat"
>

                <button
                    type="submit"
                    class="btn btn-success btn-sm btn-action btn-final"
                >
                    Finalkan
                </button>

            </form>

            <form
                action="{{ route('admin.riwayat.destroy', $laporan->id) }}"
                method="POST"
                class="form-hapus"
            >

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="btn btn-outline-danger btn-sm btn-action"
                >
                    Hapus
                </button>

            </form>

        @else

            <span class="status-badge status-lock">
                Terkunci
            </span>

        @endif

    </div>

</td>

@endif

</tr>

@empty

<tr>

    <td colspan="{{ auth()->user()->role == 'admin' ? 8 : 7 }}">

        <div class="empty-state">

            <i class="bi bi-folder2-open fs-2 d-block mb-2"></i>

            Belum ada laporan tersimpan.

        </div>

    </td>

</tr>

@endforelse

</tbody>

</table>

</div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap mt-4">

    <div class="pagination-info">

        Menampilkan

        <strong>{{ $laporans->firstItem() ?? 0 }}</strong>

        -

        <strong>{{ $laporans->lastItem() ?? 0 }}</strong>

        dari

        <strong>{{ $laporans->total() }}</strong>

        laporan

    </div>

    {{ $laporans->links('vendor.pagination.bootstrap-5') }}

</div>

    </div>

</div>

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | HAPUS LAPORAN
    |--------------------------------------------------------------------------
    */

    const formHapus = document.querySelectorAll('.form-hapus');

    if (formHapus.length > 0) {

        formHapus.forEach(form => {

            form.addEventListener('submit', function (e) {

                e.preventDefault();

                Swal.fire({

                    title: 'Hapus Laporan?',
                    text: 'Data laporan akan dihapus permanen.',
                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',

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

    }

    /*
    |--------------------------------------------------------------------------
    | FINALISASI LAPORAN
    |--------------------------------------------------------------------------
    */

    const formFinal = document.querySelectorAll('.form-final');

    if (formFinal.length > 0) {

        formFinal.forEach(form => {

            form.addEventListener('submit', function (e) {

                e.preventDefault();

                Swal.fire({

                    title: 'Finalisasi Laporan?',
                    text: 'Laporan yang sudah difinalisasi tidak dapat diubah atau dihapus lagi.',
                    icon: 'question',

                    showCancelButton: true,

                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#6c757d',

                    confirmButtonText: 'Ya, Finalkan',
                    cancelButtonText: 'Batal',

                    reverseButtons: true

                }).then((result) => {

                    if (result.isConfirmed) {

                        form.submit();

                    }

                });

            });

        });

    }

});

</script>

@endpush

@endsection