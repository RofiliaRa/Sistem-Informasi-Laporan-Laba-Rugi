@extends('layouts.dashboard')

@section('content')

{{-- HERO DASHBOARD --}}
@include('partials.dashboard-hero', [
    'todayText' => $todayText,
    'roleTitle' => 'Ketua Unit'
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
                    <div class="stat-title">Total Beban Usaha</div>
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
                    <div class="stat-title">{{ $statusKeuangan }}</div>
                    <small>{{ $periodeAktif }}</small>
                </div>
            </div>
            <div class="stat-value {{ $labaBersih >= 0 ? 'text-primary' : 'text-danger' }}">
                Rp {{ number_format(abs($labaBersih), 0, ',', '.') }}
            </div>
        </div>
    </div>
</div>

{{-- GRAFIK KEUANGAN --}}
<div class="card chart-card mb-4 border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 pt-4 px-4">
        <h5 class="fw-bold text-primary mb-0">
            <i class="bi bi-graph-up-arrow me-2"></i> Grafik Pendapatan dan Beban Usaha
        </h5>
    </div>
    <div class="card-body pt-2 px-4 pb-4">
        <canvas id="adminFinanceChart" height="220"></canvas>
    </div>
</div>

{{-- RINGKASAN TRANSAKSI TERBARU --}}
<div class="card transaksi-card mb-4 border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 py-4 px-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="fw-bold text-primary mb-1">Ringkasan Transaksi Terbaru</h4>
                <small class="text-muted">3 transaksi terakhir yang diinput</small>
            </div>
        </div>
    </div>

    <div class="card-body pt-0 px-4 pb-4">
        @if($transaksiTerbaru->isEmpty())
            <div class="alert alert-light border mb-0 text-center py-4">
                <i class="bi bi-info-circle me-2"></i> Belum ada transaksi yang diinput.
            </div>
        @else
            <div class="table-responsive">
                <table class="table dash-table-pro text-nowrap align-middle mb-0">
                    <thead>
                        <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Jam</th>
                        <th class="text-center">Jenis</th>
                        <th class="text-center col-keterangan">Keterangan</th>
                        <th class="text-end">Nominal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($transaksiTerbaru as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('d M Y') }}
                                </td>
                                <td class="text-center">{{ $item['jam'] }}</td>
                                <td class="text-center">
                                    @if($item['jenis'] == 'Pendapatan')
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-semibold">
                                            Pendapatan
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2 fw-semibold">
                                            Beban Usaha
                                        </span>
                                    @endif
                                </td>
                                <td class="fw-semibold col-keterangan">
                                {{ $item['keterangan'] }}
                                </td>
                                <td class="text-end fw-bold {{ $item['jenis'] == 'Pendapatan' ? 'text-success' : 'text-danger' }}">
                                    Rp {{ number_format($item['nominal'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <hr class="my-4">

            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <div class="summary-card">
                        <div class="summary-icon bg-primary-subtle text-primary">
                            <i class="bi bi-receipt fs-4"></i>
                        </div>
                        <div class="summary-content">
                            <small class="text-muted">Total Transaksi</small>
                            <h4 class="mb-0 fw-bold">{{ $totalTransaksi }} Data</h4>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="summary-card">
                        <div class="summary-icon bg-warning-subtle text-warning">
                            <i class="bi bi-file-earmark-text fs-4"></i>
                        </div>
                        <div class="summary-content">
                            <small class="text-muted">Status Laporan</small>
                            <h4 class="mb-0 fw-bold">
                                @if($laporanTerakhir)
                                    @if($laporanTerakhir->status == 'final')
                                        <span class="badge bg-success rounded-pill px-3 py-2">Final</span>
                                    @else
                                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Draft</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary rounded-pill px-3 py-2">Belum Ada</span>
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
                    label: 'Beban Usaha',
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