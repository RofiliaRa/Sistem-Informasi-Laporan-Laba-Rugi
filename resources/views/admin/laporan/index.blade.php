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

.dash-panel-body{

    padding:20px 22px;

}

/* ==========================
   BODY LAPORAN
========================== */

.laporan-body{

    padding:22px 28px;

}

.laporan-body .text-center{

    margin-bottom:22px !important;

}

.laporan-body h2{

    font-size:20px;

}

.laporan-body h3{

    font-size:20px;

}

.laporan-body h6{

    font-size:20px;

}

/* ==========================
   HEADER LAPORAN
========================== */

.page-header{

    display:flex;

    justify-content:space-between;

    align-items:flex-start;

    gap:24px;

    margin-bottom:24px;

}

.page-title{

    margin:0;

    font-size:20px;

    font-weight:800;

    color:#0f172a;

}

.page-subtitle{

    margin-top:6px;

    font-size:16px;

    color:#64748b;

}

.header-left{

    display:flex;

    flex-direction:column;

}

.header-title{

    display:flex;

    align-items:center;

    gap:14px;

    flex-wrap:wrap;

}

.header-action{

    display:flex;

    align-items:center;

    gap:10px;

    flex-wrap:wrap;

}

.status-badge{

    display:inline-flex;

    align-items:center;

    gap:6px;

    padding:6px 14px;

    height:38px;

    border-radius:999px;

    font-size:13px;

    font-weight:700;

}

.status-badge i{

    font-size:14px;

}

/* ==========================
   FILTER PERIODE
========================== */

.form-label{

    font-size:14px;

    font-weight:600;

    color:#475569;

    margin-bottom:6px;

}

.form-control{

    height:44px;

    border:1px solid #dbe3ec;

    border-radius:12px;

    font-size:14px;

    box-shadow:none;

}

.form-control:focus{

    border-color:#2563eb;

    box-shadow:0 0 0 .15rem rgba(37,99,235,.12);

}

.btn{

    border-radius:12px;

}

.btn-primary{

    height:42px;

    padding:0 22px;

    font-size:14px;

    font-weight:700;

}

.btn-success{

    height:42px;

    padding:0 22px;

    font-size:14px;

    font-weight:700;

}

.btn-danger{

    height:42px;

    padding:0 22px;

    font-size:14px;

    font-weight:700;

}

.btn-secondary{

    height:42px;

    padding:0 22px;

    font-size:14px;

    font-weight:700;

}

.header-action .btn{

    height:42px;

    display:flex;

    align-items:center;

    justify-content:center;

    gap:6px;

    padding:0 18px;

    border-radius:12px;

    font-size:14px;

    font-weight:700;

}

/* ==========================================================
   CARD RINGKASAN
========================================================== */

.row.mb-4 .dash-panel-body{

    min-height:105px;

    padding:16px;

    display:flex;

    flex-direction:column;

    justify-content:center;

    align-items:center;

    text-align:center;

}

.row.mb-4 .dash-panel-body i{

    width:42px;

    height:42px;

    display:flex;

    justify-content:center;

    align-items:center;

    margin-bottom:10px;

    border-radius:12px;

    font-size:18px;

}

.row.mb-4 .dash-panel-body h6{

    margin:0 0 6px;

    font-size:13px;

    font-weight:600;

    color:#64748b;

    line-height:1.4;

}

.row.mb-4 .dash-panel-body h3{

    margin:0;

    font-size:22px;

    font-weight:800;

    line-height:1.2;

}

/* ==========================================================
   JUDUL BAGIAN
========================================================== */

.section-title td{

    padding-top:12px;

    padding-bottom:8px;

    font-size:17px;

    font-weight:700;

    color:#0f172a;

}

/* ==========================================================
   TABEL LAPORAN
========================================================== */

.laporan-table td{

    padding:7px 8px;

    font-size:15px;

    vertical-align:middle;

    color:#334155;

}

/* ==========================================================
   NAMA AKUN
========================================================== */

.akun{

    padding-left:35px !important;

}

/* ==========================================================
   NOMINAL
========================================================== */

.nominal{

    width:220px;

    text-align:right;

    white-space:nowrap;

    font-size:16px;

    font-weight:600;

    color:#0f172a;

}

/* ==========================================================
   SUB TOTAL
========================================================== */

.subtotal-row td{

    border-top:1px solid #d1d5db;

    padding-top:10px;

    padding-bottom:8px;

    font-size:17px;

    font-weight:700;

    color:#0f172a;

}

/* ==========================================================
   GRAND TOTAL
========================================================== */

.grand-total-row td{

    border-top:2px solid #0f172a;

    padding-top:12px;

    padding-bottom:10px;

    font-size:18px;

    font-weight:800;

    letter-spacing:.3px;

}

.grand-total-row .nominal{

    font-size:20px;

    font-weight:800;

}

/* ==========================================================
   WARNA
========================================================== */

.text-success{

    color:#198754 !important;

}

.text-danger{

    color:#c62828 !important;

}

/* ==========================================================
   LEADER DOTS
========================================================== */

.dots-row{

    display:flex;

    align-items:flex-end;

    width:100%;

}

.dots-text{

    white-space:nowrap;

}

.dots-line{

    flex:1;

    border-bottom:1px dotted #94a3b8;

    margin:0 8px 4px;

}

.dots-value{

    min-width:120px;

    text-align:right;

    white-space:nowrap;

    font-weight:500;

}

</style>

<div class="container-fluid">

    {{-- ===========================
         HEADER
    ============================ --}}
    <div class="page-header">

        <div class="header-left">

            <div class="header-title">

                <h2 class="page-title">
                    Laporan Laba Rugi
                </h2>

                @if(!$laporanAktif)

                    <span class="badge bg-secondary status-badge">

                        <i class="bi bi-info-circle-fill"></i>

                        Belum Ada Transaksi

                    </span>

                @elseif($laporanAktif->status == 'final')

                    <span class="badge bg-success status-badge">

                        <i class="bi bi-check-circle-fill"></i>

                        Final • {{ $periode }}

                    </span>

                @else

                    <span class="badge bg-warning text-dark status-badge">

                        <i class="bi bi-pencil-square"></i>

                        Draft • {{ $periode }}

                    </span>

                @endif

            </div>

            <div class="page-subtitle">

                Unit Usaha Fotokopi Jayadirana

            </div>

        </div>

        <div class="header-action">

            {{-- ===========================
                 ADMIN SAJA
            ============================ --}}
            @if(auth()->user()->role == 'admin')

                @if($laporanAktif)

                    @if($laporanAktif->status != 'final')

                        <form
                            action="{{ route('admin.riwayat.finalisasi', $laporanAktif->id) }}"
                            method="POST"
                            class="form-finalisasi"
                        >

                            @csrf
                            @method('PUT')

                            <input
                                type="hidden"
                                name="bulan"
                                value="{{ $bulan }}"
                            >

                            <input
    type="hidden"
    name="from"
    value="laporan"
>

                            <button
                                type="submit"
                                class="btn btn-success"
                            >

                                <i class="bi bi-check-circle-fill me-1"></i>

                                Finalisasi Laporan

                            </button>

                        </form>

                    @else

                        <button
                            class="btn btn-secondary"
                            disabled
                        >

                            <i class="bi bi-lock-fill me-1"></i>

                            Laporan Sudah Final

                        </button>

                    @endif

                @endif

            @endif

            {{-- ===========================
                 DOWNLOAD PDF
            ============================ --}}

            @if($laporanAktif)

                <a
                    href="{{ auth()->user()->role == 'admin'
                        ? route('admin.laporan.pdf', ['bulan' => request('bulan', now()->format('Y-m'))])
                        : route('direktur.laporan.pdf', ['bulan' => request('bulan', now()->format('Y-m'))]) }}"
                    class="btn btn-danger"
                >

                    <i class="bi bi-file-earmark-pdf-fill me-1"></i>

                    Download PDF

                </a>

            @else

                <button
                    class="btn btn-danger"
                    disabled
                >

                    <i class="bi bi-file-earmark-pdf-fill me-1"></i>

                    Download PDF

                </button>

            @endif

        </div>

    </div>

    {{-- ===========================
         FILTER PERIODE
    ============================ --}}
    <div class="dash-panel-card-pro mb-4">

        <div class="dash-panel-body">

            <form
                method="GET"
                action="{{ auth()->user()->role == 'admin'
                    ? route('admin.laporan.index')
                    : route('direktur.laporan.index') }}"
            >

                <div class="row align-items-end">

                    <div class="col-md-4">

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

                    <div class="col-md-2">

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >

                            Tampilkan

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>
    
   {{-- CARD RINGKASAN --}}

<div class="row mb-4">

    {{-- TOTAL PENDAPATAN --}}
    <div class="col-md-4">

        <div class="dash-panel-card-pro h-100">

            <div class="dash-panel-body text-center">

                <i class="bi bi-cash-stack text-success fs-2 mb-3"></i>

                <h6 class="text-muted mb-2">
                    Total Pendapatan
                </h6>

                <h3 class="fw-bold text-success mb-0">
                    Rp {{ number_format($totalPendapatan,0,',','.') }}
                </h3>

            </div>

        </div>

    </div>

    {{-- TOTAL PENGELUARAN --}}
    <div class="col-md-4">

        <div class="dash-panel-card-pro h-100">

            <div class="dash-panel-body text-center">

                <i class="bi bi-wallet2 text-danger fs-2 mb-3"></i>

                <h6 class="text-muted mb-2">
                    Total Pengeluaran
                </h6>

                <h3 class="fw-bold text-danger mb-0">
                    Rp {{ number_format($totalPengeluaran,0,',','.') }}
                </h3>

            </div>

        </div>

    </div>

    {{-- LABA / RUGI --}}
    <div class="col-md-4">

        <div class="dash-panel-card-pro h-100">

            <div class="dash-panel-body text-center">

                @if($labaBersih >= 0)

                    <i class="bi bi-graph-up-arrow text-success fs-2 mb-3"></i>

                @else

                    <i class="bi bi-graph-down-arrow text-danger fs-2 mb-3"></i>

                @endif

                <h6 class="text-muted mb-2">

                    {{ $labaBersih >= 0 ? 'Laba Bersih' : 'Rugi Bersih' }}

                </h6>

                <h3 class="fw-bold text-primary mb-0">

                    Rp {{ number_format(abs($labaBersih),0,',','.') }}

                </h3>

            </div>

        </div>

    </div>

</div>

    {{-- LAPORAN --}}

    <div class="dash-panel-card-pro">

    <div class="dash-panel-body laporan-body">

            <div class="text-center mb-5">

                <h6 class="mb-2 fw-bold">
                    BUM DESA KALITINGGAR MAKMUR KALITINGGAR
                </h6>

                <h2 class="fw-bold">
                    UNIT USAHA FOTOKOPI JAYADIRANA
                </h2>

                <h3 class="fw-bold">
                    LAPORAN LABA RUGI
                </h3>

                <p class="text-muted mb-2">
                    Periode {{ $periode }}
                </p>
      </div>

            {{-- LAPORAN LABA RUGI --}}

<div class="laporan-single-step">

<table class="table table-borderless laporan-table">

<tbody>

    {{-- =========================== --}}
    {{-- PENDAPATAN USAHA --}}
    {{-- =========================== --}}

    <tr class="section-title">

        <td colspan="2">

            Pendapatan Usaha

        </td>

    </tr>

    <tr>

        <td colspan="2">

    <div class="dots-row">

        <span class="dots-text">
            Pendapatan Jasa
        </span>

        <span class="dots-line"></span>

        <span class="dots-value">
            Rp {{ number_format($pendapatanPerKategori['Jasa'] ?? 0,0,',','.') }}
        </span>

    </div>

</td>
    </tr>

    <tr>

        <td colspan="2">

    <div class="dots-row">

        <span class="dots-text">
            Pendapatan Penjualan ATK dan Lain-Lain
        </span>

        <span class="dots-line"></span>

        <span class="dots-value">
            Rp {{ number_format($pendapatanPerKategori['ATK dan Lain-Lain'] ?? 0,0,',','.') }}
        </span>

    </div>

</td>

    </tr>

    <tr class="subtotal-row">

        <td>Total Pendapatan</td>

        <td class="nominal">

            Rp {{ number_format($totalPendapatan,0,',','.') }}

        </td>

    </tr>

    {{-- =========================== --}}
    {{-- BEBAN USAHA --}}
    {{-- =========================== --}}

    <tr class="section-title">

        <td colspan="2">

            Beban Usaha

        </td>

    </tr>

    @foreach($pengeluaranKategori as $jenis => $total)

        <tr>

           <td colspan="2">

    <div class="dots-row">

        <span class="dots-text">
            {{ 'Beban '.$jenis }}
        </span>

        <span class="dots-line"></span>

        <span class="dots-value">
            Rp {{ number_format($total,0,',','.') }}
        </span>

    </div>

</td>

        </tr>

    @endforeach

    <tr class="subtotal-row">

        <td>Total Beban</td>

        <td class="nominal">

            Rp {{ number_format($totalPengeluaran,0,',','.') }}

        </td>

    </tr>

    {{-- GARIS GANDA --}}

    <tr class="grand-total-row">

        <td>

            {{ $labaBersih >= 0 ? 'LABA BERSIH' : 'RUGI BERSIH' }}

        </td>

        <td class="nominal">

            <span class="{{ $labaBersih >= 0 ? 'text-success' : 'text-danger' }}">

                Rp {{ number_format(abs($labaBersih),0,',','.') }}

            </span>

        </td>

    </tr>

</tbody>

</table>

</div>

        </div>

    </div>  

    @if(session('warning'))

<script>

document.addEventListener('DOMContentLoaded', function () {

    Swal.fire({

        icon: 'warning',

        title: 'Laporan tidak dapat dibuat',

        text: '{{ session('warning') }}',

        confirmButtonColor: '#f59e0b'

    });

});

</script>

@endif

@push('scripts')

<script>

    /*
    |--------------------------------------------------------------------------
    | FINALISASI LAPORAN
    |--------------------------------------------------------------------------
    */

    document.addEventListener('DOMContentLoaded', function () {

    const forms = document.querySelectorAll('.form-finalisasi');

    if (forms.length > 0) {

        forms.forEach(form => {

            form.addEventListener('submit', function (e) {

                e.preventDefault();

                Swal.fire({

                    title: 'Finalisasi Laporan?',
                    text: 'Laporan final tidak dapat diubah lagi.',
                    icon: 'question',

                    showCancelButton: true,

                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#6c757d',

                    confirmButtonText: 'Ya, Finalisasi',
                    cancelButtonText: 'Batal'

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