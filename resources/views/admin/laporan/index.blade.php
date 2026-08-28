@extends('layouts.dashboard')

@section('content')

{{-- =========================================================
     CSS STYLES UNTUK KOP, DOT-LEADERS, & TAB NAVIGASI
     ========================================================= --}}
<style>
    /* =========================
       KOP LAPORAN
       ========================= */
    .laporan-kop {
        width: 100%;
        padding: 18px 0 12px;
        margin-bottom: 24px;
        border-bottom: 3px double #111;
    }

    .laporan-kop-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: calc(100% - 24px);
        margin: 0 auto;
    }

    .laporan-kop-logo {
        width: 78px;
        height: 78px;
        object-fit: contain;
        flex-shrink: 0;
    }

    .laporan-kop-tengah {
        flex: 1;
        text-align: center;
        padding: 0 20px;
    }

    .laporan-kop-tengah .nama-bumdes {
        margin: 0 0 5px;
        font-size: 18px;
        font-weight: 700;
        line-height: 1.25;
        color: #172033;
    }

    .laporan-kop-tengah .nama-unit {
        margin: 0 0 6px;
        font-size: 18px;
        font-weight: 700;
        line-height: 1.25;
        color: #172033;
    }

    .laporan-kop-tengah .alamat {
        margin: 0;
        font-size: 12px;
        line-height: 1.4;
        color: #333;
    }

    /* =========================
       JUDUL LAPORAN
       ========================= */
    .laporan-judul {
        text-align: center;
        margin-bottom: 28px;
    }

    .laporan-judul h5 {
        margin: 0 0 6px;
        font-size: 20px;
        font-weight: 700;
        color: #111111;
        letter-spacing: .3px;
    }

    .laporan-judul p {
        margin: 0;
        font-size: 14px;
        color: #6c757d;
    }

    /* =========================
       DOT LEADERS (GARIS TITIK-TITIK)
       ========================= */
    .dots-row {
        display: flex;
        align-items: baseline;
        width: 100%;
        font-size: 14.5px;
    }

    .dots-text {
        white-space: nowrap;
        padding-right: 6px;
        color: #212529;
    }

    .dots-line {
        flex-grow: 1;
        border-bottom: 2px dotted #888;
        margin: 0 6px;
        position: relative;
        top: -3px;
    }

    .dots-value {
        white-space: nowrap;
        padding-left: 6px;
        font-weight: 600;
        color: #111827;
    }

    .indent-1 {
        padding-left: 20px;
    }

    .indent-2 {
        padding-left: 40px;
    }

    .section-header-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-top: 14px;
        margin-bottom: 8px;
    }

    .subtotal-row-dot {
        font-size: 15px;
        font-weight: 700;
        margin-top: 6px;
        margin-bottom: 6px;
    }

    /* =========================
       CUSTOM TABS NAVIGASI
       ========================= */
    .custom-laporan-tabs {
        border-bottom: 2px solid #e2e8f0;
    }

    .custom-laporan-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        color: #64748b;
        background: transparent;
        transition: all 0.2s ease-in-out;
        font-size: 15px;
    }

    .custom-laporan-tabs .nav-link:hover {
        color: #0f172a;
        border-bottom-color: #cbd5e1;
    }

    .custom-laporan-tabs .nav-link.active {
        color: #0d6efd;
        border-bottom: 3px solid #0d6efd;
        background: transparent;
    }

    /* =========================
       RESPONSIVE KOP
       ========================= */
    @media (max-width: 768px) {
        .laporan-kop {
            padding: 14px 0 10px;
        }

        .laporan-kop-logo {
            width: 58px;
            height: 58px;
        }

        .laporan-kop-tengah {
            padding: 0 10px;
        }

        .laporan-kop-tengah .nama-bumdes {
            font-size: 13px;
        }

        .laporan-kop-tengah .nama-unit {
            font-size: 15px;
        }

        .laporan-kop-tengah .alamat {
            font-size: 9px;
        }

        .laporan-judul h5 {
            font-size: 18px;
        }

        .laporan-judul p {
            font-size: 13px;
        }
    }
</style>


{{-- PAGE HEADER & ACTIONS --}}
<div class="dash-panel-card-pro mb-4">
    <div class="dash-panel-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">

        <div>
            <div class="d-flex align-items-center gap-2 flex-nowrap mb-1">
                <h3 class="fw-bold mb-0">
                    Laporan Keuangan Unit Usaha
                </h3>

                @if($laporanAktif && $laporanAktif->status == 'final')
                    <span class="badge bg-success rounded-pill px-3 py-2 fs-6">
                        <i class="bi bi-check-circle-fill me-1"></i>
                        Final • {{ $periode }}
                    </span>
                @else
                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fs-6">
                        <i class="bi bi-pencil-square me-1"></i>
                        Draft • {{ $periode }}
                    </span>
                @endif
            </div>

            <small class="text-muted">
                Unit Usaha Fotokopi Jayadirana — BUM Desa Kalitinggar Makmur
            </small>
        </div>


        <div class="header-action-mobile-full d-flex flex-wrap align-items-center gap-2 flex-shrink-0">

            {{-- TOMBOL EDIT VARIABEL LAPORAN (ADMIN DRAFT ONLY) --}}
            @if(auth()->user()->role == 'admin' && (!$laporanAktif || $laporanAktif->status != 'final'))
                <button
                    type="button"
                    class="btn btn-outline-primary d-inline-flex align-items-center justify-content-center gap-2 px-3 py-2 rounded-3 fw-bold"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEditDetail"
                >
                    <i class="bi bi-sliders"></i>
                    <span>Input Variabel Pendukung</span>
                </button>
            @endif

            {{-- ADMIN FINALISASI BUTTON --}}
            @if(auth()->user()->role == 'admin' && $laporanAktif)
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

                        <button
                            type="submit"
                            class="btn btn-success d-inline-flex align-items-center justify-content-center gap-2 px-3 py-2 rounded-3 fw-bold"
                        >
                            <i class="bi bi-check-circle-fill"></i>
                            <span class="text-nowrap">Finalisasi</span>
                        </button>
                    </form>
                @else
                    <button class="btn btn-secondary d-inline-flex align-items-center justify-content-center gap-2 px-3 py-2 rounded-3 fw-bold" disabled>
                        <i class="bi bi-lock-fill"></i>
                        <span>Laporan Sudah Final</span>
                    </button>
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

                {{-- DOWNLOAD EXCEL --}}
                <a
                    href="{{ auth()->user()->role == 'admin'
                        ? route('admin.laporan.excel', ['bulan' => request('bulan', now()->format('Y-m'))])
                        : route('direktur.laporan.excel', ['bulan' => request('bulan', now()->format('Y-m'))]) }}"
                    class="btn btn-success d-inline-flex align-items-center justify-content-center gap-2 px-3 py-2 rounded-3 fw-bold"
                >
                    <i class="bi bi-file-earmark-excel-fill"></i>
                    <span>Download Excel</span>
                </a>
            @else
                <button class="btn btn-danger d-inline-flex align-items-center justify-content-center gap-2 px-3 py-2 rounded-3 fw-bold" disabled>
                    <i class="bi bi-file-earmark-pdf-fill"></i>
                    <span>Download PDF</span>
                </button>
                <button class="btn btn-success d-inline-flex align-items-center justify-content-center gap-2 px-3 py-2 rounded-3 fw-bold" disabled>
                    <i class="bi bi-file-earmark-excel-fill"></i>
                    <span>Download Excel</span>
                </button>
            @endif

        </div>

    </div>
</div>


{{-- FILTER PERIODE --}}
@include('partials.filter-periode', [
    'action' => auth()->user()->role == 'admin'
        ? route('admin.laporan.index')
        : route('direktur.laporan.index')
])


{{-- CARD RINGKASAN (4 KARTU) --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        @include('partials.stat-card', [
            'icon' => 'bi bi-cash-stack text-success',
            'iconBg' => 'stat-success',
            'title' => 'Total Pendapatan',
            'value' => 'Rp ' . number_format($totalPendapatan, 0, ',', '.'),
            'valueClass' => 'text-success'
        ])
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        @include('partials.stat-card', [
            'icon' => 'bi bi-wallet2 text-danger',
            'iconBg' => 'stat-warning',
            'title' => 'Total Beban Usaha',
            'value' => 'Rp ' . number_format($totalPengeluaran, 0, ',', '.'),
            'valueClass' => 'text-danger'
        ])
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        @include('partials.stat-card', [
            'icon' => $labaBersih >= 0
                ? 'bi bi-graph-up-arrow text-success'
                : 'bi bi-graph-down-arrow text-danger',
            'iconBg' => 'stat-primary',
            'title' => $labaBersih >= 0 ? 'Laba Bersih' : 'Rugi Bersih',
            'value' => 'Rp ' . number_format(abs($labaBersih), 0, ',', '.'),
            'valueClass' => 'text-primary'
        ])
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        @include('partials.stat-card', [
            'icon' => 'bi bi-piggy-bank-fill text-info',
            'iconBg' => 'stat-primary',
            'title' => 'Total Kas Tersedia',
            'value' => 'Rp ' . number_format($totalKasAkhir, 0, ',', '.'),
            'valueClass' => 'text-dark'
        ])
    </div>
</div>


{{-- =========================================================
     NAVIGASI 2 TAB (LAPORAN LABA RUGI vs MUTASI KAS)
     ========================================================= --}}
<ul class="nav nav-tabs custom-laporan-tabs mb-4" id="laporanTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button
            class="nav-link active fw-bold px-4 py-3"
            id="laba-rugi-tab"
            data-bs-toggle="tab"
            data-bs-target="#laba-rugi"
            type="button"
            role="tab"
            aria-controls="laba-rugi"
            aria-selected="true"
        >
            <i class="bi bi-file-earmark-text-fill me-2"></i>
            Tab 1: Laporan Laba Rugi
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button
            class="nav-link fw-bold px-4 py-3"
            id="mutasi-kas-tab"
            data-bs-toggle="tab"
            data-bs-target="#mutasi-kas"
            type="button"
            role="tab"
            aria-controls="mutasi-kas"
            aria-selected="false"
        >
            <i class="bi bi-wallet2 me-2"></i>
            Tab 2: Mutasi & Total Kas Tersedia
        </button>
    </li>
</ul>


<div class="tab-content" id="laporanTabContent">

    {{-- =========================================================
         TAB 1: LAPORAN LABA RUGI (STANDAR SAK)
         ========================================================= --}}
    <div class="tab-pane fade show active" id="laba-rugi" role="tabpanel" aria-labelledby="laba-rugi-tab">

        <div class="dash-panel-card-pro">
            <div class="dash-panel-body laporan-body p-4">

                {{-- KOP LAPORAN --}}
                <div class="laporan-kop">
                    <div class="laporan-kop-inner">
                        <img src="{{ asset('images/logo bumdes.jpeg') }}" alt="Logo BUM Desa" class="laporan-kop-logo">
                        <div class="laporan-kop-tengah">
                            <p class="nama-bumdes">BUM DESA KALITINGGAR MAKMUR KALITINGGAR</p>
                            <p class="nama-unit">UNIT USAHA FOTOKOPI JAYADIRANA</p>
                            <p class="alamat">Desa Kalitinggar RT 01 RW 03, Karang Malang, Kec. Padamara, Kab. Purbalingga, 53372</p>
                        </div>
                        <img src="{{ asset('images/logo fc.jpeg') }}" alt="Logo Jayadirana" class="laporan-kop-logo">
                    </div>
                </div>

                {{-- JUDUL LAPORAN --}}
                <div class="laporan-judul">
                    <h5>LAPORAN LABA RUGI</h5>
                    <p>Periode Per {{ $periode }}</p>
                </div>

                {{-- LEMBAR TAMPILAN TITIK-TITIK (DOT LEADERS) --}}
                <div class="px-md-3">

                    {{-- 1. PENDAPATAN USAHA --}}
                    <div class="section-header-title">Pendapatan Usaha</div>

                    <div class="dots-row indent-1 mb-2">
                        <span class="dots-text">Pendapatan Jasa</span>
                        <span class="dots-line"></span>
                        <span class="dots-value">Rp {{ number_format($pendapatanJasa, 0, ',', '.') }}</span>
                    </div>

                    <div class="dots-row indent-1 mb-2">
                        <span class="dots-text">Pendapatan ATK dan Lain-Lain</span>
                        <span class="dots-line"></span>
                        <span class="dots-value">Rp {{ number_format($pendapatanBarang, 0, ',', '.') }}</span>
                    </div>

                    <div class="dots-row subtotal-row-dot mb-4">
                        <span class="dots-text fw-bold">Total Pendapatan</span>
                        <span class="dots-line"></span>
                        <span class="dots-value fw-bold text-success">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                    </div>


                    {{-- 2. HARGA POKOK PENJUALAN (HPP) --}}
                    <div class="section-header-title">Harga Pokok Penjualan (HPP)</div>

                    <div class="dots-row indent-1 mb-2">
                        <span class="dots-text">Persediaan Awal</span>
                        <span class="dots-line"></span>
                        <span class="dots-value">Rp {{ number_format($persediaanAwal, 0, ',', '.') }}</span>
                    </div>

                    <div class="dots-row indent-1 mb-2">
                        <span class="dots-text">Pembelian Persediaan / Bahan</span>
                        <span class="dots-line"></span>
                        <span class="dots-value">Rp {{ number_format($pembelianPersediaan, 0, ',', '.') }}</span>
                    </div>

                    <div class="dots-row indent-1 mb-2">
                        <span class="dots-text">Persediaan Akhir</span>
                        <span class="dots-line"></span>
                        <span class="dots-value">(Rp {{ number_format($persediaanAkhir, 0, ',', '.') }})</span>
                    </div>

                    <div class="dots-row subtotal-row-dot mb-2">
                        <span class="dots-text fw-bold">Total Harga Pokok Penjualan</span>
                        <span class="dots-line"></span>
                        <span class="dots-value fw-bold">Rp {{ number_format($hpp, 0, ',', '.') }}</span>
                    </div>

                    <div class="dots-row subtotal-row-dot mb-4">
                        <span class="dots-text fw-bold fs-6">Laba Kotor</span>
                        <span class="dots-line"></span>
                        <span class="dots-value fw-bold fs-6 text-primary">Rp {{ number_format($labaKotor, 0, ',', '.') }}</span>
                    </div>


                    {{-- 3. BEBAN USAHA --}}
                    <div class="section-header-title">Beban Usaha</div>

                    <div class="dots-row indent-1 mb-2">
                        <span class="dots-text">Beban Operasional & Lainnya</span>
                        <span class="dots-line"></span>
                        <span class="dots-value">Rp {{ number_format($bebanOperasional, 0, ',', '.') }}</span>
                    </div>

                    <div class="dots-row subtotal-row-dot mb-2">
                        <span class="dots-text fw-bold">Total Beban Usaha</span>
                        <span class="dots-line"></span>
                        <span class="dots-value fw-bold text-danger">Rp {{ number_format($totalBebanUsaha, 0, ',', '.') }}</span>
                    </div>

                    <div class="dots-row subtotal-row-dot mb-4">
                        <span class="dots-text fw-bold fs-6">Laba Usaha</span>
                        <span class="dots-line"></span>
                        <span class="dots-value fw-bold fs-6">Rp {{ number_format($labaUsaha, 0, ',', '.') }}</span>
                    </div>


                    {{-- 4. PENDAPATAN NON-OPERASIONAL & PAJAK --}}
                    <div class="section-header-title">Pendapatan Di Luar Usaha & Pajak</div>

                    <div class="dots-row indent-1 mb-2">
                        <span class="dots-text">Pendapatan Bunga / Non-Usaha</span>
                        <span class="dots-line"></span>
                        <span class="dots-value">Rp {{ number_format($pendapatanNonUsaha, 0, ',', '.') }}</span>
                    </div>

                    <div class="dots-row subtotal-row-dot mb-2">
                        <span class="dots-text fw-bold">Laba Bersih Sebelum Pajak</span>
                        <span class="dots-line"></span>
                        <span class="dots-value fw-bold">Rp {{ number_format($labaSebelumPajak, 0, ',', '.') }}</span>
                    </div>

                    <div class="dots-row indent-1 mb-2">
                        <span class="dots-text">Pajak Penghasilan (PPh)</span>
                        <span class="dots-line"></span>
                        <span class="dots-value">Rp {{ number_format($pph, 0, ',', '.') }}</span>
                    </div>


                    {{-- LABA / RUGI BERSIH SETELAH PAJAK --}}
                    <div class="p-3 bg-light rounded-3 border border-dark mt-4">
                        <div class="dots-row subtotal-row-dot m-0">
                            <span class="dots-text fw-bold fs-5 text-uppercase">
                                {{ $labaBersih >= 0 ? 'LABA BERSIH SETELAH PAJAK' : 'RUGI BERSIH SETELAH PAJAK' }}
                            </span>
                            <span class="dots-line"></span>
                            <span class="dots-value fw-bold fs-4 {{ $labaBersih >= 0 ? 'text-success' : 'text-danger' }}">
                                Rp {{ number_format(abs($labaBersih), 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>


    {{-- =========================================================
         TAB 2: MUTASI & TOTAL KAS TERSEDIA
         ========================================================= --}}
    <div class="tab-pane fade" id="mutasi-kas" role="tabpanel" aria-labelledby="mutasi-kas-tab">

        <div class="dash-panel-card-pro">
            <div class="dash-panel-body laporan-body p-4">

                {{-- KOP LAPORAN --}}
                <div class="laporan-kop">
                    <div class="laporan-kop-inner">
                        <img src="{{ asset('images/logo bumdes.jpeg') }}" alt="Logo BUM Desa" class="laporan-kop-logo">
                        <div class="laporan-kop-tengah">
                            <p class="nama-bumdes">BUM DESA KALITINGGAR MAKMUR KALITINGGAR</p>
                            <p class="nama-unit">UNIT USAHA FOTOKOPI JAYADIRANA</p>
                            <p class="alamat">Desa Kalitinggar RT 01 RW 03, Karang Malang, Kec. Padamara, Kab. Purbalingga, 53372</p>
                        </div>
                        <img src="{{ asset('images/logo fc.jpeg') }}" alt="Logo Jayadirana" class="laporan-kop-logo">
                    </div>
                </div>

                {{-- JUDUL LAPORAN --}}
                <div class="laporan-judul">
                    <h5>LAPORAN MUTASI & TOTAL KAS TERSEDIA</h5>
                    <p>Periode Per {{ $periode }}</p>
                </div>

                {{-- CONTENT MUTASI KAS --}}
                <div class="px-md-3">

                    <div class="section-header-title">1. Sumber Kas & Saldo Awal Periode</div>

                    <div class="dots-row indent-1 mb-2">
                        <span class="dots-text">Modal Disetor / Modal Awal Tahun BUM Desa</span>
                        <span class="dots-line"></span>
                        <span class="dots-value">Rp {{ number_format($modalTahunan, 0, ',', '.') }}</span>
                    </div>

                    <div class="dots-row indent-1 mb-2">
                        <span class="dots-text">Akumulasi Saldo Kas Periode Sebelumnya</span>
                        <span class="dots-line"></span>
                        <span class="dots-value">Rp {{ number_format($saldoKasLalu, 0, ',', '.') }}</span>
                    </div>

                    <div class="dots-row subtotal-row-dot mb-4">
                        <span class="dots-text fw-bold">Total Saldo Kas Awal Periode</span>
                        <span class="dots-line"></span>
                        <span class="dots-value fw-bold text-primary">Rp {{ number_format($saldoKasAwal, 0, ',', '.') }}</span>
                    </div>


                    <div class="section-header-title">2. Mutasi Operasional Periode Ini</div>

                    <div class="dots-row indent-1 mb-2">
                        <span class="dots-text">Laba / (Rugi) Bersih Periode Ini (dari Tab 1)</span>
                        <span class="dots-line"></span>
                        <span class="dots-value {{ $labaBersih >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ $labaBersih >= 0 ? '+' : '-' }} Rp {{ number_format(abs($labaBersih), 0, ',', '.') }}
                        </span>
                    </div>


                    {{-- TOTAL KAS AKHIR TERSEDIA --}}
                    <div class="p-3 bg-primary text-white rounded-3 mt-4">
                        <div class="dots-row subtotal-row-dot m-0">
                            <span class="dots-text fw-bold fs-5 text-white">
                                TOTAL KAS TERSEDIA (KAS AKHIR PERIODE)
                            </span>
                            <span class="dots-line" style="border-bottom-color: rgba(255,255,255,0.6);"></span>
                            <span class="dots-value fw-bold fs-4 text-white">
                                Rp {{ number_format($totalKasAkhir, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>

</div>


{{-- =========================================================
     MODAL EDIT VARIABEL LAPORAN (ADMIN ONLY)
     ========================================================= --}}
@if(auth()->user()->role == 'admin' && $laporanAktif)
<div class="modal fade" id="modalEditDetail" tabindex="-1" aria-labelledby="modalEditDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow border-0">
            <div class="modal-header bg-light border-0">
                <h5 class="modal-title fw-bold" id="modalEditDetailLabel">
                    <i class="bi bi-pencil-square text-primary me-2"></i>
                    Input Variabel Pendukung Laporan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.laporan.update-detail') }}" method="POST">
                @csrf
                <input type="hidden" name="laporan_id" value="{{ $laporanAktif->id }}">

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Modal Tahunan BUM Desa (Rp)</label>
                        <input
                            type="number"
                            name="modal_tahunan"
                            class="form-control"
                            value="{{ old('modal_tahunan', $modalTahunan) }}"
                            min="0"
                            step="any"
                        >
                        <small class="text-muted">Modal disetor BUM Desa untuk tahun ini.</small>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Persediaan Awal (Rp)</label>
                            <input
                                type="number"
                                name="persediaan_awal"
                                class="form-control"
                                value="{{ old('persediaan_awal', $persediaanAwal) }}"
                                min="0"
                                step="any"
                            >
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Persediaan Akhir (Rp)</label>
                            <input
                                type="number"
                                name="persediaan_akhir"
                                class="form-control"
                                value="{{ old('persediaan_akhir', $persediaanAkhir) }}"
                                min="0"
                                step="any"
                            >
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pendapatan Di Luar Usaha / Bunga (Rp)</label>
                        <input
                            type="number"
                            name="pendapatan_non_usaha"
                            class="form-control"
                            value="{{ old('pendapatan_non_usaha', $pendapatanNonUsaha) }}"
                            min="0"
                            step="any"
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pajak Penghasilan / PPh (Rp)</label>
                        <input
                            type="number"
                            name="pph"
                            class="form-control"
                            value="{{ old('pph', $pph) }}"
                            min="0"
                            step="any"
                        >
                    </div>
                </div>

                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-3 fw-bold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif


@if(session('warning'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'warning',
        title: 'Perhatian',
        text: '{{ session('warning') }}',
        confirmButtonColor: '#f59e0b'
    });
});
</script>
@endif

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        confirmButtonColor: '#10b981'
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