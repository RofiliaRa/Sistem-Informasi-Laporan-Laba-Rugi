@extends('layouts.dashboard')

@section('content')

<style>

/* ======================================================
   DASHBOARD DIREKTUR
====================================================== */

.direktur-table thead th{
    font-size:15px;
    font-weight:700;
    padding:18px 16px;
}

.direktur-table tbody td{
    font-size:15px;
    font-weight:500;
    padding:18px 16px;
    vertical-align:middle;
}

.direktur-table .dash-badge{
    min-width:100px;
    padding:8px 18px;
    font-size:14px;
    font-weight:600;
    border-radius:999px;
}

.direktur-laporan-card .card-header{
    border-bottom:0;
    padding:24px 28px 12px;
}

.direktur-laporan-card .card-body{
    padding:0 28px 24px;
}

.direktur-table tbody tr:last-child td{
    border-bottom:none;
}

</style>

{{-- ========================================================= --}}
{{-- HERO DASHBOARD --}}
{{-- ========================================================= --}}

<div class="card border-0 shadow-sm dashboard-hero mb-4">

    <div class="card-body">

        <div class="row align-items-center">

            <div class="col-lg-9">

                <span class="dashboard-date">

                    <i class="bi bi-calendar3 me-2"></i>

                    {{ $todayText }}

                </span>

                <h1 class="dashboard-title mt-3">

                    Selamat Datang

                </h1>

                <p class="dashboard-subtitle mb-0">

                    Sistem Informasi Laporan Laba Rugi Unit Usaha Fotokopi Jayadirana

                </p>

            </div>

            <div class="col-lg-3 text-lg-end mt-4 mt-lg-0">

                <span class="dashboard-role">

                    <i class="bi bi-person-badge-fill me-2"></i>

                    Direktur

                </span>

            </div>

        </div>

    </div>

</div>

{{-- ========================================================= --}}
{{-- CARD STATISTIK --}}
{{-- ========================================================= --}}

<div class="row g-3 mb-4">

    <div class="col-lg-4">

        <div class="dashboard-stat-card income h-100">

            <div class="stat-top">

                <div class="stat-icon">

                    <i class="bi bi-arrow-down-circle"></i>

                </div>

                <div>

                    <div class="stat-title">

                        Total Pendapatan

                    </div>

                    <small>

                        {{ $periodeAktif }}

                    </small>

                </div>

            </div>

            <div class="stat-value text-success">

                Rp {{ number_format($totalPendapatan,0,',','.') }}

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="dashboard-stat-card expense h-100">

            <div class="stat-top">

                <div class="stat-icon">

                    <i class="bi bi-arrow-up-circle"></i>

                </div>

                <div>

                    <div class="stat-title">

                        Total Pengeluaran

                    </div>

                    <small>

                        {{ $periodeAktif }}

                    </small>

                </div>

            </div>

            <div class="stat-value text-danger">

                Rp {{ number_format($totalPengeluaran,0,',','.') }}

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="dashboard-stat-card {{ $labaBersih >= 0 ? 'profit' : 'expense' }} h-100">

            <div class="stat-top">

                <div class="stat-icon">

                    <i class="bi bi-cash-stack"></i>

                </div>

                <div>

                    <div class="stat-title">

                        {{ $labaBersih >= 0 ? 'Laba Bersih' : 'Rugi Bersih' }}

                    </div>

                    <small>

                        {{ $periodeAktif }}

                    </small>

                </div>

            </div>

            <div class="stat-value {{ $labaBersih >= 0 ? 'text-primary' : 'text-danger' }}">

                Rp {{ number_format(abs($labaBersih),0,',','.') }}

            </div>

        </div>

    </div>

</div>

{{-- ========================================================= --}}
{{-- GRAFIK KEUANGAN --}}
{{-- ========================================================= --}}

<div class="card chart-card mb-4">

    <div class="card-header bg-white border-0 pt-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <h5 class="fw-bold text-primary mb-0">

                <i class="bi bi-graph-up-arrow me-2"></i>

                Grafik Keuangan Bulanan

            </h5>

            <span class="dash-chip">

                {{ $periodeAktif }}

            </span>

        </div>

    </div>

    <div class="card-body pt-2">

        <canvas
            id="direkturFinanceChart"
            height="70">
        </canvas>

    </div>

</div>

{{-- ========================================================= --}}
{{-- LAPORAN BULANAN TERBARU --}}
{{-- ========================================================= --}}

<div class="card transaksi-card direktur-laporan-card mb-4">

    <div class="card-header bg-white">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <div>

                <h4 class="fw-bold text-primary mb-1">

                    <i class="bi bi-file-earmark-text me-2"></i>

                    Laporan Bulanan Terbaru

                </h4>

                <small class="text-muted">

                    Menampilkan 3 laporan laba rugi terbaru

                </small>

            </div>

        </div>

    </div>

    <div class="card-body">

        @if($laporanTerbaru->isEmpty())

            <div class="alert alert-light border text-center mb-0">

                Belum ada laporan bulanan.

            </div>

        @else

            <div class="table-responsive">

                <table class="table dash-table-pro direktur-table align-middle mb-0">

                    <thead>

                        <tr>

                            <th class="text-center">Periode</th>

                            <th class="text-center">Pendapatan</th>

                            <th class="text-center">Pengeluaran</th>

                            <th class="text-center" style="white-space: nowrap;">
    Laba/Rugi Bersih
</th>

                            <th class="text-center">Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($laporanTerbaru as $laporan)

                        <tr>

                            <td class="text-center">

                                {{ \Carbon\Carbon::create()->month((int)$laporan->bulan)->translatedFormat('F') }}
                                {{ $laporan->tahun }}

                            </td>

                            <td class="text-center">

                                <span class="text-success fw-semibold">

                                    Rp {{ number_format($laporan->total_pendapatan,0,',','.') }}

                                </span>

                            </td>

                            <td class="text-center">

                                <span class="text-danger fw-semibold">

                                    Rp {{ number_format($laporan->total_pengeluaran,0,',','.') }}

                                </span>

                            </td>

                            <td class="text-center fw-bold">

    @if($laporan->laba_bersih >= 0)

        <span class="text-success">
            Rp {{ number_format($laporan->laba_bersih,0,',','.') }}
        </span>

    @else

        <span class="text-danger">
            Rp {{ number_format(abs($laporan->laba_bersih),0,',','.') }}
        </span>

    @endif

</td>

                            <td class="text-center">

                                @if($laporan->status=='final')

                                    <span class="dash-badge success">

                                        Final

                                    </span>

                                @else

                                    <span class="dash-badge warning">

                                        Draft

                                    </span>

                                @endif

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @endif

    </div>

</div>

@push('scripts')

<script>

const direkturCtx = document.getElementById('direkturFinanceChart');

if (direkturCtx) {

    new Chart(direkturCtx, {

        type: 'line',

        data: {

            labels: @json($chartLabels),

            datasets: [

                {

                    label: 'Pendapatan',

                    data: @json($chartPendapatan),

                    borderColor: '#16a34a',

                    backgroundColor: 'rgba(22,163,74,.10)',

                    borderWidth: 3,

                    tension: .35,

                    fill: true,

                    pointRadius: 3,

                    pointHoverRadius: 5

                },

                {

                    label: 'Pengeluaran',

                    data: @json($chartPengeluaran),

                    borderColor: '#dc2626',

                    backgroundColor: 'rgba(220,38,38,.08)',

                    borderWidth: 3,

                    tension: .35,

                    fill: true,

                    pointRadius: 3,

                    pointHoverRadius: 5

                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: true,

            aspectRatio: 4,

            interaction: {

                mode: 'index',

                intersect: false

            },

            plugins: {

                legend: {

                    position: 'top',

                    labels: {

                        usePointStyle: true,

                        padding: 20,

                        font: {

                            size: 13,

                            weight: '600'

                        }

                    }

                },

                tooltip: {

                    mode: 'index',

                    intersect: false,

                    callbacks: {

                        label: function(context){

                            return context.dataset.label + ' : Rp ' +
                                Number(context.parsed.y).toLocaleString('id-ID');

                        }

                    }

                }

            },

            scales: {

                x: {

                    grid: {

                        display: false

                    }

                },

                y: {

                    beginAtZero: true,

                    ticks: {

                        callback: function(value){

                            return 'Rp ' + Number(value).toLocaleString('id-ID');

                        }

                    }

                }

            }

        }

    });

}

</script>

@endpush

@endsection