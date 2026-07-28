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
        <canvas id="direkturFinanceChart" height="180"></canvas>
    </div>
</div>

{{-- RINGKASAN LAPORAN TERBARU --}}
<div class="card direktur-laporan-card mb-4 border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 py-4 px-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="fw-bold text-primary mb-1">Riwayat Laporan Keuangan</h4>
                <small class="text-muted">Laporan keuangan bulanan Unit Usaha Fotokopi Jayadirana</small>
            </div>
            <a href="{{ route('direktur.riwayat.index') }}" class="btn btn-outline-primary btn-sm rounded-3 px-3 py-2 fw-semibold">
                Lihat Semua Riwayat <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    <div class="card-body pt-0 px-4 pb-4">
        @if(!isset($riwayatLaporan) || $riwayatLaporan->isEmpty())
            <div class="alert alert-light border mb-0 text-center py-4">
                <i class="bi bi-info-circle me-2"></i> Belum ada data laporan keuangan.
            </div>
        @else
            <div class="table-responsive">
                <table class="table direktur-table text-nowrap align-middle mb-0">
                    <thead>
                        <tr>
                            <th width="60" class="text-center">No</th>
                            <th class="text-start">Periode</th>
                            <th class="text-end">Pendapatan</th>
                            <th class="text-end">Pengeluaran</th>
                            <th class="text-end">Laba / Rugi</th>
                            <th width="120" class="text-center">Status</th>
                            <th width="140" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayatLaporan as $laporan)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-start fw-semibold">
                                    {{ \Carbon\Carbon::create()->month($laporan->bulan)->translatedFormat('F') }} {{ $laporan->tahun }}
                                </td>
                                <td class="text-end">
                                    Rp {{ number_format($laporan->total_pendapatan, 0, ',', '.') }}
                                </td>
                                <td class="text-end">
                                    Rp {{ number_format($laporan->total_pengeluaran, 0, ',', '.') }}
                                </td>
                                <td class="text-end fw-bold {{ $laporan->laba_bersih >= 0 ? 'text-success' : 'text-danger' }}">
                                    Rp {{ number_format(abs($laporan->laba_bersih), 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    @if($laporan->status == 'final')
                                        <span class="badge bg-success rounded-pill px-3 py-2">Final</span>
                                    @else
                                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Draft</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('direktur.laporan.pdf', ['bulan' => sprintf('%04d-%02d', $laporan->tahun, $laporan->bulan)]) }}" class="btn btn-sm btn-outline-danger px-3 py-1 rounded-3">
                                        <i class="bi bi-file-earmark-pdf me-1"></i> PDF
                                    </a>
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