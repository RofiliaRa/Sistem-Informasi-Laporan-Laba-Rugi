<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Laba Rugi & Mutasi Kas</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
            color: #111827;
            margin: 25px 30px;
        }

        /* =========================
           KOP LAPORAN
           ========================= */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .kop-table td {
            border: none;
            vertical-align: middle;
        }

        .kop-logo-left, .kop-logo-right {
            width: 15%;
            text-align: center;
        }

        .kop-logo {
            width: 62px;
            height: 62px;
            object-fit: contain;
        }

        .kop-center {
            width: 70%;
            text-align: center;
            padding: 0 5px;
        }

        .kop-instansi {
            font-size: 13px;
            font-weight: bold;
            line-height: 1.2;
            text-transform: uppercase;
        }

        .kop-unit {
            font-size: 12px;
            font-weight: bold;
            line-height: 1.4;
            text-transform: uppercase;
            margin-top: 3px;
        }

        .kop-alamat {
            font-size: 9.5px;
            font-weight: normal;
            line-height: 1.4;
            margin-top: 3px;
        }

        .kop-garis {
            border-top: 2px solid #000;
            border-bottom: 1px solid #000;
            height: 3px;
            margin-top: 4px;
            margin-bottom: 14px;
        }

        /* =========================
           JUDUL LAPORAN
           ========================= */
        .judul-laporan {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .periode-laporan {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .dicetak-pada {
            text-align: center;
            font-size: 10px;
            color: #4b5563;
            margin-bottom: 16px;
        }

        /* =========================
           DOT LEADERS TABLE (PDF)
           ========================= */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .report-table td {
            padding: 5px 2px;
            vertical-align: bottom;
            border: none;
        }

        .section-header {
            font-size: 12px;
            font-weight: bold;
            color: #1f2937;
            padding-top: 10px;
            padding-bottom: 4px;
        }

        .item-label {
            font-size: 11px;
        }

        .indent-1 {
            padding-left: 18px !important;
        }

        .dot-line-cell {
            border-bottom: 1px dotted #6b7280 !important;
            height: 12px;
        }

        .item-value {
            text-align: right;
            font-size: 11px;
            white-space: nowrap;
        }

        .subtotal-row td {
            font-weight: bold;
            font-size: 11px;
            border-top: 1px solid #9ca3af;
            border-bottom: 1px solid #9ca3af;
            padding-top: 6px;
            padding-bottom: 6px;
        }

        .grand-total-box {
            margin-top: 15px;
            padding: 10px 12px;
            border: 2px solid #111827;
            background-color: #f9fafb;
            font-size: 13px;
            font-weight: bold;
        }

        /* =========================
           SIGNATURE BLOCK
           ========================= */
        .signature {
            margin-top: 25px;
        }

        .signature-date {
            text-align: right;
            margin-bottom: 15px;
            font-size: 11px;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }

        .signature-table td {
            border: none;
            text-align: center;
            vertical-align: top;
            font-size: 11px;
        }

        .signature-title {
            font-weight: bold;
            line-height: 1.4;
        }

        .signature-space {
            height: 45px;
        }

        .signature-name {
            font-weight: bold;
        }

        /* PAGE BREAK & WATERMARK */
        .page-break {
            page-break-after: always;
        }

        .watermark {
            position: fixed;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 100px;
            font-weight: bold;
            color: #999;
            opacity: 0.12;
            z-index: -1;
        }

        /* DETAIL TABLES */
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .detail-table th, .detail-table td {
            border: 1px solid #d1d5db;
            padding: 6px 8px;
            font-size: 10px;
        }

        .detail-table th {
            background: #1F4E78;
            color: white;
            text-align: center;
            font-weight: bold;
        }

        .text-center { text-align: center; }
        .text-end { text-align: right; }
    </style>
</head>
<body>

@if($status == 'draft')
    <div class="watermark">DRAFT</div>
@endif

{{-- =========================================================
     HALAMAN 1: LAPORAN LABA RUGI (MULTI-STEP)
     ========================================================= --}}

<table class="kop-table">
    <tr>
        <td class="kop-logo-left">
            <img src="{{ public_path('images/logo bumdes.jpeg') }}" class="kop-logo" alt="Logo BUM Desa">
        </td>
        <td class="kop-center">
            <div class="kop-instansi">BUM DESA KALITINGGAR MAKMUR KALITINGGAR</div>
            <div class="kop-unit">UNIT USAHA FOTOKOPI JAYADIRANA</div>
            <div class="kop-alamat">Desa Kalitinggar RT 01 RW 03, Karang Malang, Kec. Padamara, Kab. Purbalingga, 53372</div>
        </td>
        <td class="kop-logo-right">
            <img src="{{ public_path('images/logo fc.jpeg') }}" class="kop-logo" alt="Logo Jayadirana">
        </td>
    </tr>
</table>
<div class="kop-garis"></div>

<div class="judul-laporan">LAPORAN LABA RUGI</div>
<div class="periode-laporan">Periode {{ $periode }}</div>
<div class="dicetak-pada">
    Dicetak pada : {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }} pukul {{ \Carbon\Carbon::now()->format('H:i') }} WIB
</div>

<table class="report-table">
    {{-- PENDAPATAN USAHA --}}
    <tr>
        <td colspan="3" class="section-header">Pendapatan Usaha</td>
    </tr>
    <tr>
        <td class="item-label indent-1" width="45%">Pendapatan Jasa</td>
        <td class="dot-line-cell"></td>
        <td class="item-value" width="30%">Rp {{ number_format($pendapatanJasa, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td class="item-label indent-1">Pendapatan ATK dan Lain-Lain</td>
        <td class="dot-line-cell"></td>
        <td class="item-value">Rp {{ number_format($pendapatanBarang, 0, ',', '.') }}</td>
    </tr>
    <tr class="subtotal-row">
        <td>Total Pendapatan</td>
        <td></td>
        <td class="item-value" style="color:#15803d;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
    </tr>

    {{-- HPP --}}
    <tr>
        <td colspan="3" class="section-header">Harga Pokok Penjualan (HPP)</td>
    </tr>
    <tr>
        <td class="item-label indent-1">Persediaan Awal</td>
        <td class="dot-line-cell"></td>
        <td class="item-value">Rp {{ number_format($persediaanAwal, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td class="item-label indent-1">Pembelian Persediaan / Bahan</td>
        <td class="dot-line-cell"></td>
        <td class="item-value">Rp {{ number_format($pembelianPersediaan, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td class="item-label indent-1">Persediaan Akhir</td>
        <td class="dot-line-cell"></td>
        <td class="item-value">(Rp {{ number_format($persediaanAkhir, 0, ',', '.') }})</td>
    </tr>
    <tr class="subtotal-row">
        <td>Total Harga Pokok Penjualan</td>
        <td></td>
        <td class="item-value">Rp {{ number_format($hpp, 0, ',', '.') }}</td>
    </tr>
    <tr class="subtotal-row">
        <td style="font-size:12px;">Laba Kotor</td>
        <td></td>
        <td class="item-value" style="font-size:12px; color:#1d4ed8;">Rp {{ number_format($labaKotor, 0, ',', '.') }}</td>
    </tr>

    {{-- BEBAN USAHA --}}
    <tr>
        <td colspan="3" class="section-header">Beban Usaha</td>
    </tr>
    <tr>
        <td class="item-label indent-1">Beban Operasional & Lainnya</td>
        <td class="dot-line-cell"></td>
        <td class="item-value">Rp {{ number_format($bebanOperasional, 0, ',', '.') }}</td>
    </tr>
    <tr class="subtotal-row">
        <td>Total Beban Usaha</td>
        <td></td>
        <td class="item-value" style="color:#b91c1c;">Rp {{ number_format($totalBebanUsaha, 0, ',', '.') }}</td>
    </tr>
    <tr class="subtotal-row">
        <td style="font-size:12px;">Laba Usaha</td>
        <td></td>
        <td class="item-value" style="font-size:12px;">Rp {{ number_format($labaUsaha, 0, ',', '.') }}</td>
    </tr>

    {{-- NON OPERASIONAL & PAJAK --}}
    <tr>
        <td colspan="3" class="section-header">Pendapatan Di Luar Usaha & Pajak</td>
    </tr>
    <tr>
        <td class="item-label indent-1">Pendapatan Bunga / Non-Usaha</td>
        <td class="dot-line-cell"></td>
        <td class="item-value">Rp {{ number_format($pendapatanNonUsaha, 0, ',', '.') }}</td>
    </tr>
    <tr class="subtotal-row">
        <td>Laba Bersih Sebelum Pajak</td>
        <td></td>
        <td class="item-value">Rp {{ number_format($labaSebelumPajak, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td class="item-label indent-1">Pajak Penghasilan (PPh)</td>
        <td class="dot-line-cell"></td>
        <td class="item-value">Rp {{ number_format($pph, 0, ',', '.') }}</td>
    </tr>
</table>

<div class="grand-total-box">
    <table style="width:100%; border:none;">
        <tr>
            <td style="border:none; padding:0; font-size:13px; font-weight:bold;">
                {{ $labaBersih >= 0 ? 'LABA BERSIH SETELAH PAJAK' : 'RUGI BERSIH SETELAH PAJAK' }}
            </td>
            <td style="border:none; padding:0; text-align:right; font-size:14px; font-weight:bold; color:{{ $labaBersih >= 0 ? '#15803d' : '#b91c1c' }};">
                Rp {{ number_format(abs($labaBersih), 0, ',', '.') }}
            </td>
        </tr>
    </table>
</div>

{{-- SIGNATURE HALAMAN 1 --}}
<div class="signature">
    <div class="signature-date">
        Kalitinggar, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
    </div>
    <table class="signature-table">
        <tr>
            <td width="33%">
                <div class="signature-title">Mengetahui,<br>Ketua Unit Usaha Fotokopi<br>Jayadirana</div>
            </td>
            <td width="33%">
                <div class="signature-title">Diperiksa oleh,<br>Bendahara BUM Desa</div>
            </td>
            <td width="33%">
                <div class="signature-title">Disetujui oleh,<br>Direktur BUM Desa</div>
            </td>
        </tr>
        <tr>
            <td class="signature-space"></td>
            <td class="signature-space"></td>
            <td class="signature-space"></td>
        </tr>
        <tr>
            <td class="signature-name">(.......................................)</td>
            <td class="signature-name">(.......................................)</td>
            <td class="signature-name">(.......................................)</td>
        </tr>
    </table>
</div>


<div class="page-break"></div>

{{-- =========================================================
     HALAMAN 2: LAPORAN MUTASI & TOTAL KAS TERSEDIA
     ========================================================= --}}

<table class="kop-table">
    <tr>
        <td class="kop-logo-left">
            <img src="{{ public_path('images/logo bumdes.jpeg') }}" class="kop-logo" alt="Logo BUM Desa">
        </td>
        <td class="kop-center">
            <div class="kop-instansi">BUM DESA KALITINGGAR MAKMUR KALITINGGAR</div>
            <div class="kop-unit">UNIT USAHA FOTOKOPI JAYADIRANA</div>
            <div class="kop-alamat">Desa Kalitinggar RT 01 RW 03, Karang Malang, Kec. Padamara, Kab. Purbalingga, 53372</div>
        </td>
        <td class="kop-logo-right">
            <img src="{{ public_path('images/logo fc.jpeg') }}" class="kop-logo" alt="Logo Jayadirana">
        </td>
    </tr>
</table>
<div class="kop-garis"></div>

<div class="judul-laporan">LAPORAN MUTASI & TOTAL KAS TERSEDIA</div>
<div class="periode-laporan">Periode {{ $periode }}</div>
<div class="dicetak-pada">
    Dicetak pada : {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }} pukul {{ \Carbon\Carbon::now()->format('H:i') }} WIB
</div>

<table class="report-table">
    <tr>
        <td colspan="3" class="section-header">1. Sumber Kas & Saldo Awal Periode</td>
    </tr>
    <tr>
        <td class="item-label indent-1" width="50%">Modal Disetor / Modal Awal Tahun BUM Desa</td>
        <td class="dot-line-cell"></td>
        <td class="item-value" width="30%">Rp {{ number_format($modalTahunan, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td class="item-label indent-1">Akumulasi Saldo Kas Periode Sebelumnya</td>
        <td class="dot-line-cell"></td>
        <td class="item-value">Rp {{ number_format($saldoKasLalu, 0, ',', '.') }}</td>
    </tr>
    <tr class="subtotal-row">
        <td>Total Saldo Kas Awal Periode</td>
        <td></td>
        <td class="item-value" style="color:#1d4ed8;">Rp {{ number_format($saldoKasAwal, 0, ',', '.') }}</td>
    </tr>

    <tr>
        <td colspan="3" class="section-header">2. Mutasi Operasional Periode Ini</td>
    </tr>
    <tr>
        <td class="item-label indent-1">Laba / (Rugi) Bersih Periode Ini (dari Halaman 1)</td>
        <td class="dot-line-cell"></td>
        <td class="item-value" style="color:{{ $labaBersih >= 0 ? '#15803d' : '#b91c1c' }};">
            {{ $labaBersih >= 0 ? '+' : '-' }} Rp {{ number_format(abs($labaBersih), 0, ',', '.') }}
        </td>
    </tr>
</table>

<div class="grand-total-box" style="background:#1e293b; color:#ffffff; border-color:#0f172a;">
    <table style="width:100%; border:none;">
        <tr>
            <td style="border:none; padding:0; font-size:13px; font-weight:bold; color:#ffffff;">
                TOTAL KAS TERSEDIA (SALDO KAS AKHIR PERIODE)
            </td>
            <td style="border:none; padding:0; text-align:right; font-size:14px; font-weight:bold; color:#ffffff;">
                Rp {{ number_format($totalKasAkhir, 0, ',', '.') }}
            </td>
        </tr>
    </table>
</div>

{{-- SIGNATURE HALAMAN 2 --}}
<div class="signature">
    <div class="signature-date">
        Kalitinggar, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
    </div>
    <table class="signature-table">
        <tr>
            <td width="33%">
                <div class="signature-title">Mengetahui,<br>Ketua Unit Usaha Fotokopi<br>Jayadirana</div>
            </td>
            <td width="33%">
                <div class="signature-title">Diperiksa oleh,<br>Bendahara BUM Desa</div>
            </td>
            <td width="33%">
                <div class="signature-title">Disetujui oleh,<br>Direktur BUM Desa</div>
            </td>
        </tr>
        <tr>
            <td class="signature-space"></td>
            <td class="signature-space"></td>
            <td class="signature-space"></td>
        </tr>
        <tr>
            <td class="signature-name">(.......................................)</td>
            <td class="signature-name">(.......................................)</td>
            <td class="signature-name">(.......................................)</td>
        </tr>
    </table>
</div>

<div class="page-break"></div>

{{-- =========================================================
     HALAMAN 3: DETAIL PENDAPATAN
     ========================================================= --}}
<div class="text-center" style="margin-bottom:15px;">
    <h2 style="font-size:18px; font-weight:bold;">DETAIL PENDAPATAN</h2>
    <p style="font-size:12px;">Periode {{ $periode }}</p>
</div>

<table class="detail-table">
    <thead>
        <tr>
            <th width="6%">No</th>
            <th width="16%">Tanggal</th>
            <th width="20%">Kategori</th>
            <th width="30%">Nama Barang / Jasa</th>
            <th width="10%">Jumlah</th>
            <th width="18%">Total</th>
        </tr>
    </thead>
    <tbody>
    @forelse($pendapatan as $item)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
            <td>{{ $item->category->nama_kategori ?? '-' }}</td>
            <td>{{ $item->nama_barang }}</td>
            <td class="text-center">{{ $item->jumlah ?? 1 }}</td>
            <td class="text-end">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center">Tidak ada data pendapatan pada periode ini.</td>
        </tr>
    @endforelse
        <tr style="font-weight:bold; background:#e2e8f0;">
            <td colspan="5" class="text-end">TOTAL PENDAPATAN</td>
            <td class="text-end">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>

<div class="page-break"></div>

{{-- =========================================================
     HALAMAN 4: DETAIL PENGELUARAN
     ========================================================= --}}
<div class="text-center" style="margin-bottom:15px;">
    <h2 style="font-size:18px; font-weight:bold;">DETAIL PENGELUARAN</h2>
    <p style="font-size:12px;">Periode {{ $periode }}</p>
</div>

<table class="detail-table">
    <thead>
        <tr>
            <th width="6%">No</th>
            <th width="16%">Tanggal</th>
            <th width="24%">Jenis Pengeluaran</th>
            <th width="26%">Nama Barang / Keterangan</th>
            <th width="10%">Jumlah</th>
            <th width="18%">Total</th>
        </tr>
    </thead>
    <tbody>
    @forelse($pengeluaran as $item)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
            <td>{{ $item->jenis_pengeluaran }}</td>
            <td>{{ $item->nama_barang }} {{ $item->keterangan ? '('.$item->keterangan.')' : '' }}</td>
            <td class="text-center">{{ $item->jumlah ?? 1 }}</td>
            <td class="text-end">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center">Tidak ada data pengeluaran pada periode ini.</td>
        </tr>
    @endforelse
        <tr style="font-weight:bold; background:#e2e8f0;">
            <td colspan="5" class="text-end">TOTAL PENGELUARAN</td>
            <td class="text-end">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>

</body>
</html>