@extends('layouts.dashboard')

@section('content')

{{-- ========================================================= --}}
{{-- HERO DASHBOARD --}}
{{-- ========================================================= --}}

<div class="card border-0 shadow-sm mb-4 dashboard-hero">

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

            <div class="col-lg-3 text-lg-end mt-3 mt-lg-0">

                <span class="dashboard-role">

                    <i class="bi bi-person-badge-fill me-2"></i>

                    Ketua Unit

                </span>

            </div>

        </div>

    </div>

</div>

{{-- ========================================================= --}}
{{-- CARD STATISTIK --}}
{{-- ========================================================= --}}

<div class="row g-2 mb-4">

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

        <div class="dashboard-stat-card {{ $labaBersih >=0 ? 'profit':'expense' }} h-100">

            <div class="stat-top">

                <div class="stat-icon">

                    <i class="bi bi-cash-stack"></i>

                </div>

                <div>

                    <div class="stat-title">

                        {{ $statusKeuangan }}

                    </div>

                    <small>

                        {{ $periodeAktif }}

                    </small>

                </div>

            </div>

            <div class="stat-value {{ $labaBersih >=0 ? 'text-primary':'text-danger' }}">

                Rp {{ number_format(abs($labaBersih),0,',','.') }}

            </div>

        </div>

    </div>

</div>

{{-- ========================================================= --}}
{{-- GRAFIK --}}
{{-- ========================================================= --}}

<div class="card chart-card mb-4">

    <div class="card-header bg-white border-0 pt-4">

        <h5 class="fw-bold text-primary mb-0">

            <i class="bi bi-graph-up-arrow me-2"></i>

            Grafik Pendapatan dan Pengeluaran

        </h5>

    </div>

    <div class="card-body pt-2">

        <canvas
            id="adminFinanceChart"
            height="180">
        </canvas>

    </div>

</div>

<div class="card transaksi-card mb-4">

    <div class="card-header bg-white border-0 py-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <div>

                <h4 class="fw-bold text-primary mb-1">

                    Ringkasan Transaksi Terbaru

                </h4>

                <small class="text-muted">

                    3 transaksi terakhir yang diinput

                </small>

            </div>

        </div>

    </div>

    <div class="card-body pt-0">

        @if($transaksiTerbaru->isEmpty())

            <div class="alert alert-light border mb-0 text-center">

                Belum ada transaksi yang diinput.

            </div>

        @else

            <div class="table-responsive">

                <table class="table dash-table-pro align-middle mb-0">

                    <colgroup>

                        <col class="col-no">

                        <col class="col-tanggal">

                        <col class="col-jam">

                        <col class="col-jenis">

                        <col class="col-keterangan">

                        <col class="col-nominal">

                    </colgroup>

                    <thead>

                        <tr>

                            <th class="text-center">No</th>

                            <th class="text-center">Tanggal</th>

                            <th class="text-center">Jam</th>

                            <th class="text-center">Jenis</th>

                            <th class="text-center">Keterangan</th>

                            <th class="text-center">Nominal</th>

                        </tr>

                    </thead>

                    <tbody>

    @foreach($transaksiTerbaru as $item)

        <tr>

            <td class="text-center">

                {{ $loop->iteration }}

            </td>

            <td class="text-center">

                {{ \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('d M Y') }}

            </td>

            <td class="text-center">

                {{ $item['jam'] }}

            </td>

            <td class="text-center">

                @if($item['jenis']=='Pendapatan')

                    <span class="dash-badge success">

                        Pendapatan

                    </span>

                @else

                    <span class="dash-badge danger">

                        Pengeluaran

                    </span>

                @endif

            </td>

            <td class="text-center">

                {{ $item['keterangan'] }}

            </td>

            <td class="text-center">

                @if($item['jenis']=='Pendapatan')

                    <span class="nominal-pendapatan">

                        Rp {{ number_format($item['nominal'],0,',','.') }}

                    </span>

                @else

                    <span class="nominal-pengeluaran">

                        Rp {{ number_format($item['nominal'],0,',','.') }}

                    </span>

                @endif

            </td>

        </tr>

    @endforeach

</tbody>

</table>

</div>

<hr class="my-4">

<div class="row g-3">

    <div class="col-md-6">

        <div class="summary-card">

            <div class="summary-icon bg-primary-subtle">

                <i class="bi bi-receipt"></i>

            </div>

            <div class="summary-content">

                <small>

                    Total Transaksi

                </small>

                <h4>

                    {{ $totalTransaksi }} Data

                </h4>

            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="summary-card">

            <div class="summary-icon bg-warning-subtle">

                <i class="bi bi-file-earmark-text"></i>

            </div>

            <div class="summary-content">

                <small>

                    Status Laporan

                </small>

                <h4>

                    @if($laporanTerakhir)

                        @if($laporanTerakhir->status=='final')

                            <span class="badge bg-success">

                                Final

                            </span>

                        @else

                            <span class="badge bg-warning text-dark">

                                Draft

                            </span>

                        @endif

                    @else

                        <span class="badge bg-secondary">

                            Belum Ada

                        </span>

                    @endif

                </h4>

            </div>

        </div>

    </div>

</div>

@endif

</div>

</div>

@endsection

@push('scripts')

<script>

/*
|--------------------------------------------------------------------------
| GRAFIK PENDAPATAN & PENGELUARAN
|--------------------------------------------------------------------------
*/

const adminCtx = document.getElementById('adminFinanceChart');

if (adminCtx) {

    new Chart(adminCtx, {

        type: 'line',

        data: {

            labels: @json($chartLabels),

            datasets: [

                {

                    label: 'Pendapatan',

                    data: @json($chartPendapatan),

                    borderColor: '#16a34a',

                    backgroundColor: 'rgba(22, 163, 74, 0.10)',

                    tension: 0.35,

                    fill: true

                },

                {

                    label: 'Pengeluaran',

                    data: @json($chartPengeluaran),

                    borderColor: '#dc2626',

                    backgroundColor: 'rgba(220, 38, 38, 0.08)',

                    tension: 0.35,

                    fill: true

                }

            ]

        },

        options: {

            responsive: true,

            plugins: {

                legend: {

                    position: 'top'

                }

            },

            interaction: {

                mode: 'index',

                intersect: false

            },

            scales: {

                y: {

                    beginAtZero: true

                }

            }

        }

    });

}

</script>

@endpush