@extends('layouts.dashboard')

@section('content')

{{-- HERO DASHBOARD --}}
@include('partials.dashboard-hero', [
    'todayText' => $todayText,
    'roleTitle' => 'Direktur'
])

{{-- STATISTIK KEUANGAN --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="dashboard-stat-card income h-100">
            <div class="stat-top">
                <div class="stat-icon">
                    <i class="bi bi-arrow-down-circle"></i>
                </div>
                <div>
                    <div class="stat-title">Total Pendapatan</div>
                    <small>{{ $periodeAktif }}</small>
                </div>
            </div>
            <div class="stat-value text-success">
                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="dashboard-stat-card expense h-100">
            <div class="stat-top">
                <div class="stat-icon">
                    <i class="bi bi-arrow-up-circle"></i>
                </div>
                <div>
                    <div class="stat-title">Total Pengeluaran</div>
                    <small>{{ $periodeAktif }}</small>
                </div>
            </div>
            <div class="stat-value text-danger">
                Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="dashboard-stat-card {{ $labaBersih >= 0 ? 'profit' : 'expense' }} h-100">
            <div class="stat-top">
                <div class="stat-icon">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                    <div class="stat-title">{{ $labaBersih >= 0 ? 'Laba Bersih' : 'Rugi Bersih' }}</div>
                    <small>{{ $periodeAktif }}</small>
                </div>
            </div>
            <div class="stat-value {{ $labaBersih >= 0 ? 'text-primary' : 'text-danger' }}">
                Rp {{ number_format(abs($labaBersih), 0, ',', '.') }}
            </div>
        </div>
    </div>
</div>

{{-- GRAFIK KEUANGAN BULANAN --}}
<div class="card chart-card mb-4 border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 pt-4 px-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="fw-bold text-primary mb-0">
                <i class="bi bi-graph-up-arrow me-2"></i> Grafik Keuangan Bulanan
            </h5>
            <span class="total-data-chip">
                {{ $periodeAktif }}
            </span>
        </div>
    </div>
    <div class="card-body pt-2 px-4 pb-4">
    <div class="direktur-chart-wrapper">
        <canvas
            id="direkturFinanceChart"
            height="220">
        </canvas>
    </div>
</div>
</div>

{{-- RINGKASAN LAPORAN TERBARU --}}
<div class="card direktur-laporan-card mb-4 border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 py-4 px-4">
        <div>
            <h4 class="fw-bold text-primary mb-1">Laporan Bulanan Terbaru</h4>
            <small class="text-muted d-block">
                Menampilkan laporan laba rugi terbaru
            </small>
        </div>
    </div>

    <div class="card-body pt-0 px-4 pb-4">
        @if(!isset($laporanTerbaru) || $laporanTerbaru->isEmpty())
            <div class="alert alert-light border mb-0 text-center py-4">
                <i class="bi bi-info-circle me-2"></i> Belum ada data laporan laba rugi.
            </div>
        @else
            <div class="table-responsive">
                <table class="riwayat-table text-nowrap">
                    <thead>
                        <tr>
                            <th width="60" class="text-center">No</th>
                            <th class="text-start">Periode</th>
                            <th class="text-start">Pendapatan</th>
                            <th class="text-start">Pengeluaran</th>
                            <th class="text-start">Laba / Rugi</th>
                            <th width="120" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporanTerbaru->take(3) as $laporan)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-start fw-semibold">
                                    {{ \Carbon\Carbon::create()->month($laporan->bulan)->translatedFormat('F') }} {{ $laporan->tahun }}
                                </td>
                                <td class="text-start">
                                    Rp {{ number_format($laporan->total_pendapatan, 0, ',', '.') }}
                                </td>
                                <td class="text-start">
                                    Rp {{ number_format($laporan->total_pengeluaran, 0, ',', '.') }}
                                </td>
                                <td class="text-start">
                                    @if($laporan->laba_bersih >= 0)
                                        <span class="nominal-profit">
                                            Rp {{ number_format($laporan->laba_bersih, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="nominal-loss">
                                            Rp {{ number_format(abs($laporan->laba_bersih), 0, ',', '.') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
const direkturCtx = document.getElementById('direkturFinanceChart');

if (direkturCtx) {
    new Chart(direkturCtx, {
        type: 'line',
        data: {
            labels: @json($chartLabels ?? []),
            datasets: [
                {
                    label: 'Pendapatan',
                    data: @json($chartPendapatan ?? []),
                    borderColor: '#16a34a',
                    backgroundColor: 'rgba(22, 163, 74, 0.10)',
                    tension: 0.35,
                    fill: true
                },
                {
                    label: 'Pengeluaran',
                    data: @json($chartPengeluaran ?? []),
                    borderColor: '#dc2626',
                    backgroundColor: 'rgba(220, 38, 38, 0.08)',
                    tension: 0.35,
                    fill: true
                }
            ]
        },
        options: {
    responsive: true,
    maintainAspectRatio: false,


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