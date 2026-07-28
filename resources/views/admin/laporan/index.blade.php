@extends('layouts.dashboard')

@section('content')

{{-- PAGE HEADER & ACTIONS --}}
<div class="dash-panel-card-pro mb-4">
    <div class="dash-panel-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                <h3 class="fw-bold mb-0">Laporan Laba Rugi</h3>

                @if(!$laporanAktif)
                    <span class="badge bg-secondary rounded-pill px-3 py-2 fs-6">
                        <i class="bi bi-info-circle-fill me-1"></i> Belum Ada Transaksi
                    </span>
                @elseif($laporanAktif->status == 'final')
                    <span class="badge bg-success rounded-pill px-3 py-2 fs-6">
                        <i class="bi bi-check-circle-fill me-1"></i> Final • {{ $periode }}
                    </span>
                @else
                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fs-6">
                        <i class="bi bi-pencil-square me-1"></i> Draft • {{ $periode }}
                    </span>
                @endif
            </div>

            <small class="text-muted">
                Unit Usaha Fotokopi Jayadirana
            </small>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            {{-- ADMIN FINALISASI BUTTON --}}
            @if(auth()->user()->role == 'admin')
                @if($laporanAktif)
                    @if($laporanAktif->status != 'final')
                        <form
                            action="{{ route('admin.riwayat.finalisasi', $laporanAktif->id) }}"
                            method="POST"
                            class="form-finalisasi m-0"
                        >
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="bulan" value="{{ $bulan }}">
                            <input type="hidden" name="from" value="laporan">
                            <button type="submit" class="btn btn-success d-inline-flex align-items-center justify-content-center gap-2 px-3 py-2 rounded-3 fw-bold">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Finalisasi Laporan</span>
                            </button>
                        </form>
                    @else
                        <button class="btn btn-secondary d-inline-flex align-items-center justify-content-center gap-2 px-3 py-2 rounded-3 fw-bold" disabled>
                            <i class="bi bi-lock-fill"></i>
                            <span>Laporan Sudah Final</span>
                        </button>
                    @endif
                @endif
            @endif

            {{-- DOWNLOAD PDF --}}
            @if($laporanAktif)
                <a
                    href="{{ auth()->user()->role == 'admin'
                        ? route('admin.laporan.pdf', ['bulan' => request('bulan', now()->format('Y-m'))])
                        : route('direktur.laporan.pdf', ['bulan' => request('bulan', now()->format('Y-m'))]) }}"
                    class="btn btn-danger d-inline-flex align-items-center justify-content-center gap-2 px-3 py-2 rounded-3 fw-bold"
                >
                    <i class="bi bi-file-earmark-pdf-fill"></i>
                    <span>Download PDF</span>
                </a>
            @else
                <button
                    class="btn btn-danger d-inline-flex align-items-center justify-content-center gap-2 px-3 py-2 rounded-3 fw-bold"
                    disabled
                >
                    <i class="bi bi-file-earmark-pdf-fill"></i>
                    <span>Download PDF</span>
                </button>
            @endif
        </div>
    </div>
</div>

{{-- FILTER PERIODE --}}
@include('partials.filter-periode', [
    'action' => auth()->user()->role == 'admin' ? route('admin.laporan.index') : route('direktur.laporan.index')
])

{{-- CARD RINGKASAN --}}
<div class="row g-3 mb-4">
    {{-- TOTAL PENDAPATAN --}}
    <div class="col-12 col-md-4">
        @include('partials.stat-card', [
            'icon' => 'bi bi-cash-stack text-success',
            'iconBg' => 'stat-success',
            'title' => 'Total Pendapatan',
            'value' => 'Rp ' . number_format($totalPendapatan, 0, ',', '.'),
            'valueClass' => 'text-success'
        ])
    </div>

    {{-- TOTAL PENGELUARAN --}}
    <div class="col-12 col-md-4">
        @include('partials.stat-card', [
            'icon' => 'bi bi-wallet2 text-danger',
            'iconBg' => 'stat-warning',
            'title' => 'Total Pengeluaran',
            'value' => 'Rp ' . number_format($totalPengeluaran, 0, ',', '.'),
            'valueClass' => 'text-danger'
        ])
    </div>

    {{-- LABA / RUGI BERSIH --}}
    <div class="col-12 col-md-4">
        @include('partials.stat-card', [
            'icon' => $labaBersih >= 0 ? 'bi bi-graph-up-arrow text-success' : 'bi bi-graph-down-arrow text-danger',
            'iconBg' => 'stat-primary',
            'title' => $labaBersih >= 0 ? 'Laba Bersih' : 'Rugi Bersih',
            'value' => 'Rp ' . number_format(abs($labaBersih), 0, ',', '.'),
            'valueClass' => 'text-primary'
        ])
    </div>
</div>

{{-- LEMBAR LAPORAN LABA RUGI --}}
<div class="dash-panel-card-pro">
    <div class="dash-panel-body laporan-body">
        {{-- JUDUL LAPORAN --}}
        <div class="text-center mb-0 pt-3">
            <h6 class="mb-1 fw-bold text-uppercase tracking-wide">
                BUM DESA KALITINGGAR MAKMUR KALITINGGAR
            </h6>
            <h4 class="fw-bold mb-1">
                UNIT USAHA FOTOKOPI JAYADIRANA
            </h4>
            <h5 class="fw-bold text-primary mb-1">
                LAPORAN LABA RUGI
            </h5>
            <p class="text-muted small mb-0">
                Periode {{ $periode }}
            </p>
        </div>

        {{-- TABEL LAPORAN --}}
        <div class="table-responsive">
            <table class="table table-borderless laporan-table mb-0">
                <tbody>
                    {{-- PENDAPATAN USAHA --}}
                    <tr class="section-title">
                        <td colspan="2">Pendapatan Usaha</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="dots-row">
                                <span class="dots-text">Pendapatan Jasa</span>
                                <span class="dots-line"></span>
                                <span class="dots-value text-end">
                                    Rp {{ number_format($pendapatanPerKategori['Jasa'] ?? 0, 0, ',', '.') }}
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="dots-row">
                                <span class="dots-text">Pendapatan Penjualan ATK dan Lain-Lain</span>
                                <span class="dots-line"></span>
                                <span class="dots-value text-end">
                                    Rp {{ number_format($pendapatanPerKategori['ATK dan Lain-Lain'] ?? 0, 0, ',', '.') }}
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr class="subtotal-row">
                        <td class="fw-bold">Total Pendapatan</td>
                        <td class="nominal text-end fw-bold text-success">
                            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                        </td>
                    </tr>

                    {{-- BEBAN USAHA --}}
                    <tr class="section-title">
                        <td colspan="2">Beban Usaha</td>
                    </tr>
                    @foreach($pengeluaranKategori as $jenis => $total)
                        <tr>
                            <td colspan="2">
                                <div class="dots-row">
                                    <span class="dots-text">Beban {{ $jenis }}</span>
                                    <span class="dots-line"></span>
                                    <span class="dots-value text-end">
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="subtotal-row">
                        <td class="fw-bold">Total Beban</td>
                        <td class="nominal text-end fw-bold text-danger">
                            Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                        </td>
                    </tr>

                    {{-- LABA BERSIH / RUGI BERSIH --}}
                    <tr class="grand-total-row">
                        <td class="fw-bold">
                            {{ $labaBersih >= 0 ? 'LABA BERSIH' : 'RUGI BERSIH' }}
                        </td>
                        <td class="nominal text-end fw-bold fs-5">
                            <span class="{{ $labaBersih >= 0 ? 'text-success' : 'text-danger' }}">
                                Rp {{ number_format(abs($labaBersih), 0, ',', '.') }}
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