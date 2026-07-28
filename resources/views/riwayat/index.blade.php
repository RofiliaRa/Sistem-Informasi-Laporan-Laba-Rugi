@extends('layouts.dashboard')

@section('content')

{{-- PAGE HEADER --}}
@include('partials.page-header', [
    'title' => 'Riwayat Laporan Laba Rugi',
    'subtitle' => 'Arsip dan riwayat laporan keuangan yang telah tersimpan'
])

{{-- CARD STATISTIK --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        @include('partials.stat-card', [
            'icon' => 'bi bi-file-earmark-text',
            'iconBg' => 'stat-primary',
            'title' => 'Total Laporan',
            'value' => $totalLaporan ?? 0
        ])
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        @include('partials.stat-card', [
            'icon' => 'bi bi-calendar-check',
            'iconBg' => 'stat-primary',
            'title' => 'Tahun Aktif',
            'value' => request('bulan') ? date('Y', strtotime(request('bulan'))) : now()->year
        ])
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        @include('partials.stat-card', [
            'icon' => 'bi bi-check-circle',
            'iconBg' => 'stat-success',
            'title' => 'Laporan Final',
            'value' => $totalFinal ?? 0,
            'valueClass' => 'stat-success'
        ])
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        @include('partials.stat-card', [
            'icon' => 'bi bi-hourglass-split',
            'iconBg' => 'stat-warning',
            'title' => 'Laporan Draft',
            'value' => $totalDraft ?? 0,
            'valueClass' => 'stat-warning'
        ])
    </div>
</div>

{{-- FILTER PERIODE --}}
@include('partials.filter-periode', [
    'action' => auth()->user()->role == 'admin' ? route('admin.riwayat.index') : route('direktur.riwayat.index'),
    'showReset' => true
])

{{-- DATA RIWAYAT LAPORAN --}}
<div class="dash-panel-card-pro">
    @include('partials.panel-header', [
        'title' => 'Data Riwayat Laporan',
        'icon' => 'bi bi-clock-history',
        'total' => $laporans->total(),
        'totalLabel' => 'Laporan'
    ])

    <div class="dash-panel-body">
        <div class="table-responsive">
            <table class="riwayat-table">
                <thead>
                    <tr>
                        <th width="60" class="text-center">No</th>
                        <th class="text-start">Periode</th>
                        <th class="text-start">Pendapatan</th>
                        <th class="text-start">Pengeluaran</th>
                        <th class="text-start">Laba / Rugi</th>
                        <th width="120" class="text-center">Status</th>
                        <th width="80" class="text-center">PDF</th>
                        @if(auth()->user()->role == 'admin')
                            <th width="180" class="text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                @forelse($laporans as $laporan)
                    <tr>
                        <td class="text-center">
                            {{ $laporans->firstItem() + $loop->index }}
                        </td>

                        <td class="text-start fw-semibold">
                            {{ \Carbon\Carbon::create()->month($laporan->bulan)->translatedFormat('F') }}
                            {{ $laporan->tahun }}
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

                        <td class="text-center">
                            <a
                                href="{{ auth()->user()->role == 'admin'
                                    ? route('admin.laporan.pdf', ['bulan' => $laporan->tahun.'-'.str_pad($laporan->bulan,2,'0',STR_PAD_LEFT)])
                                    : route('direktur.laporan.pdf', ['bulan' => $laporan->tahun.'-'.str_pad($laporan->bulan,2,'0',STR_PAD_LEFT)]) }}"
                                class="btn btn-danger btn-sm btn-action"
                                title="Download PDF"
                            >
                                <i class="bi bi-file-earmark-pdf-fill"></i>
                            </a>
                        </td>

                        @if(auth()->user()->role == 'admin')
                            <td class="text-center">
                                <div class="action-group">
                                    @if($laporan->status != 'final')
                                        <form
                                            action="{{ route('admin.riwayat.finalisasi', $laporan->id) }}"
                                            method="POST"
                                            class="form-final"
                                        >
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="from" value="riwayat">
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
                                                class="btn btn-outline-danger btn-action"
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
                    @include('partials.empty-table', [
                        'colspan' => auth()->user()->role == 'admin' ? 8 : 7,
                        'message' => 'Belum ada laporan tersimpan.'
                    ])
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">
            <div class="pagination-info">
                Menampilkan
                <strong>{{ $laporans->firstItem() ?? 0 }}</strong>
                -
                <strong>{{ $laporans->lastItem() ?? 0 }}</strong>
                dari
                <strong>{{ $laporans->total() }}</strong>
                laporan
            </div>

            <div>
                {{ $laporans->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
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