<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>Laporan Laba Rugi</title>


    <style>

        /* =========================================================
           KOP LAPORAN
           ========================================================= */

        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .kop-table td {
            border: none;
            vertical-align: middle;
        }

        .kop-logo-left {
            width: 15%;
            text-align: center;
            vertical-align: middle;
        }

        .kop-logo-right {
            width: 15%;
            text-align: center;
            vertical-align: middle;
        }

        .kop-logo {
            width: 68px;
            height: 68px;
            object-fit: contain;
        }

        .kop-center {
            width: 70%;
            text-align: center;
            vertical-align: middle;
            padding: 0 8px;
        }

        .kop-instansi {
            font-size: 14px;
            font-weight: bold;
            line-height: 1.25;
            text-transform: uppercase;
            white-space: nowrap;
            margin: 0;
        }

        .kop-unit {
            font-size: 13px;
            font-weight: bold;
            line-height: 1.5;
            text-transform: uppercase;
            margin-top: 5px;
            white-space: nowrap;
        }

        .kop-alamat {
            font-size: 10px;
            font-weight: normal;
            line-height: 2;
            margin-top: 4px;
            text-align: center;
        }

        .kop-garis {
            border-top: 2px solid #000;
            border-bottom: 1px solid #000;
            height: 4px;
            margin-top: 4px;
            margin-bottom: 14px;
        }


        /* =========================================================
           TAMBAHAN KOP HALAMAN DETAIL
           ========================================================= */

        .detail-kop {
            width: 100%;
            margin-bottom: 0;
        }

        .detail-kop .kop-table {
            width: 100%;
            margin-bottom: 10px;
        }

        .detail-kop .kop-logo {
            width: 68px;
            height: 68px;
        }

        .detail-kop .kop-garis {
            margin-bottom: 18px;
        }


        /* =========================================================
           BODY
           ========================================================= */

        body {
            font-family: sans-serif;
            font-size: 11px;
            color: #111827;
            margin: 30px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        p {
            margin: 0;
        }


        /* =========================================================
           TEXT
           ========================================================= */

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .mb-20 {
            margin-bottom: 20px;
        }


        /* =========================================================
           HEADER
           ========================================================= */

        .header-bumdes {
            font-size: 16px;
            font-weight: bold;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin-top: 8px;
            letter-spacing: 0.5px;
        }

        .subtitle {
            font-size: 20px;
            margin-top: 10px;
            font-weight: bold;
        }

        .periode {
            margin-top: 8px;
            font-size: 14px;
            font-weight: bold;
        }


        /* =========================================================
           JUDUL LAPORAN
           PERBAIKAN SESUAI PERMINTAAN
           ========================================================= */

        .judul-laporan {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            line-height: 1.5;
            margin: 0 0 6px 0;
        }

        .periode-laporan {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            line-height: 1.5;
            margin: 0 0 6px 0;
        }

        .dicetak-pada {
            text-align: center;
            font-size: 14px;
            font-weight: normal;
            line-height: 1.5;
            margin: 0 0 20px 0;
        }


        /* =========================================================
           SECTION
           ========================================================= */

        .section-title {
            margin-top: 28px;
            margin-bottom: 12px;
            font-size: 20px;
            font-weight: bold;
            color: #111827;
        }


        /* =========================================================
           TABLE
           ========================================================= */

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table td,
        table th {
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            font-size: 12px;
        }

        table th {
            background: #f3f4f6;
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
        }

        .total {
            font-weight: bold;
            background: #f3f4f6;
        }


        /* =========================================================
           FINAL RESULT
           ========================================================= */

        .final {
            margin-top: 20px;
            padding: 12px 16px;
            border: 2px solid #0f172a;
            background: #ffffff;
            color: #0f172a;
            font-size: 16px;
            font-weight: 700;
        }


        /* =========================================================
           SIGNATURE
           ========================================================= */

        .signature {
            margin-top: 18px;
        }

        .signature-date {
            text-align: right;
            margin-bottom: 18px;
            font-size: 13px;
        }

        .signature-table {
            width: 100%;
            border: none;
        }

        .signature-table td {
            border: none;
            text-align: center;
            vertical-align: top;
            font-size: 13px;
        }

        .signature-title {
            font-weight: bold;
            font-size: 14px;
            line-height: 1.5;
        }

        .signature-space {
            height: 50px;
        }

        .signature-name {
            font-weight: bold;
            margin-top: 10px;
        }


        /* =========================================================
           PAGE BREAK
           ========================================================= */

        .page-break {
            page-break-after: always;
        }


        /* =========================================================
           WATERMARK
           ========================================================= */

        .watermark {
            position: fixed;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 120px;
            font-weight: bold;
            color: #999;
            opacity: 0.12;
            z-index: -1;
            letter-spacing: 10px;
        }


        /* =========================================================
           TABEL DETAIL
           ========================================================= */

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .detail-table th,
        .detail-table td {
            border: 1px solid #d1d5db;
            padding: 8px 9px;
            font-size: 11px;
        }

        .detail-table th {
            background: #1F4E78;
            color: white;
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
        }

        .detail-table td {
            vertical-align: middle;
        }

        .detail-total {
            font-weight: bold;
            background: #EAF2F8;
        }

        .detail-total-label {
            text-align: center !important;
            font-weight: bold;
        }

        .detail-total-value {
            text-align: right !important;
            font-weight: bold;
            white-space: nowrap;
        }


        /* =========================================================
           INFO TRANSAKSI
           ========================================================= */

        .transaction-info {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            margin-bottom: 10px;
        }

        .transaction-info td {
            border: 1px solid #d1d5db;
            padding: 8px 10px;
            background: #EAF2F8;
            font-size: 11px;
            font-weight: bold;
        }

        .transaction-info .jumlah-transaksi {
            text-align: right;
        }


    </style>

</head>


<body>


@if($status == 'draft')

    <div class="watermark">
        DRAFT
    </div>

@endif



{{-- =========================================================
     =========================================================
     HALAMAN 1
     LAPORAN LABA RUGI
     =========================================================
     ========================================================= --}}


<table class="kop-table">

    <tr>

        {{-- LOGO BUM DESA --}}

        <td class="kop-logo-left">

            <img
                src="{{ public_path('images/logo bumdes.jpeg') }}"
                class="kop-logo"
                alt="Logo BUM Desa"
            >

        </td>


        {{-- NAMA INSTANSI --}}

        <td class="kop-center">

            <div class="kop-instansi">
                BUM DESA KALITINGGAR MAKMUR KALITINGGAR
            </div>

            <div class="kop-unit">
                UNIT USAHA FOTOKOPI JAYADIRANA
            </div>

            <div class="kop-alamat">
                Desa Kalitinggar RT 01 RW 03,
                Karang Malang,
                Kec. Padamara,
                Kab. Purbalingga, 53372
            </div>

        </td>


        {{-- LOGO JAYADIRANA --}}

        <td class="kop-logo-right">

            <img
                src="{{ public_path('images/logo fc.jpeg') }}"
                class="kop-logo"
                alt="Logo Jayadirana"
            >

        </td>

    </tr>

</table>


<div class="kop-garis"></div>



{{-- =========================================================
     JUDUL LAPORAN
     ========================================================= --}}

<div class="judul-laporan">

    LAPORAN LABA RUGI

</div>


<div class="periode-laporan">

    Periode {{ $periode }}

</div>


<div class="dicetak-pada">

    Dicetak pada :
    {{ \Carbon\Carbon::now()
        ->locale('id')
        ->translatedFormat('d F Y')
    }}

    pukul
    {{ \Carbon\Carbon::now()->format('H:i') }}

    WIB

</div>



{{-- =========================================================
     PERBAIKAN PENDAPATAN JASA
     =========================================================

     Pendapatan Jasa dihitung langsung dari transaksi
     yang kategori-nya bernama "Jasa".

     Jadi tidak bergantung pada category_id tertentu.
     ========================================================= --}}

@php

    $pendapatanJasa = $pendapatan
        ->filter(function ($item) {

            $namaKategori = strtolower(
                trim(
                    $item->category->nama_kategori ?? ''
                )
            );

            return $namaKategori === 'jasa';

        })
        ->sum('total');


    /*
    |--------------------------------------------------------------------------
    | Pendapatan Barang / ATK dan Lain-Lain
    |--------------------------------------------------------------------------
    */

    $pendapatanBarang = $pendapatan
        ->filter(function ($item) {

            $namaKategori = strtolower(
                trim(
                    $item->category->nama_kategori ?? ''
                )
            );

            return $namaKategori !== 'jasa';

        })
        ->sum('total');


    /*
    |--------------------------------------------------------------------------
    | Total Pendapatan
    |--------------------------------------------------------------------------
    */

    $totalPendapatan = $pendapatan->sum('total');


    /*
    |--------------------------------------------------------------------------
    | Total Pengeluaran
    |--------------------------------------------------------------------------
    */

    $totalPengeluaran = $pengeluaran->sum('total');


    /*
    |--------------------------------------------------------------------------
    | Laba Bersih
    |--------------------------------------------------------------------------
    */

    $labaBersih = $totalPendapatan - $totalPengeluaran;

@endphp



{{-- =========================================================
     RINGKASAN PENDAPATAN
     ========================================================= --}}

<div class="section-title">

    Ringkasan Pendapatan

</div>


<table style="margin-bottom:15px;">

    <thead>

        <tr>

            <th>
                Keterangan
            </th>

            <th width="25%" class="text-end">
                Nominal
            </th>

        </tr>

    </thead>


    <tbody>


        {{-- PENDAPATAN JASA --}}

        <tr>

            <td>
                Pendapatan Jasa
            </td>

            <td class="text-end">

                Rp
                {{ number_format(
                    $pendapatanJasa,
                    0,
                    ',',
                    '.'
                ) }}

            </td>

        </tr>


        {{-- PENDAPATAN BARANG --}}

        <tr>

            <td>
                Pendapatan Barang
            </td>

            <td class="text-end">

                Rp
                {{ number_format(
                    $pendapatanBarang,
                    0,
                    ',',
                    '.'
                ) }}

            </td>

        </tr>


        {{-- TOTAL --}}

        <tr class="total">

            <td>
                TOTAL PENDAPATAN
            </td>

            <td class="text-end">

                Rp
                {{ number_format(
                    $totalPendapatan,
                    0,
                    ',',
                    '.'
                ) }}

            </td>

        </tr>


    </tbody>

</table>



{{-- =========================================================
     RINGKASAN BEBAN USAHA
     ========================================================= --}}

<div class="section-title">

    Ringkasan Beban Usaha

</div>


<table>

    <thead>

        <tr>

            <th>
                Keterangan
            </th>

            <th width="25%" class="text-end">
                Nominal
            </th>

        </tr>

    </thead>


    <tbody>


    @forelse($pengeluaranKategori as $jenis => $total)

        <tr>

            <td>

                Beban {{ $jenis }}

            </td>

            <td class="text-end">

                Rp
                {{ number_format(
                    $total,
                    0,
                    ',',
                    '.'
                ) }}

            </td>

        </tr>

    @empty

        <tr>

            <td
                colspan="2"
                class="text-center"
            >

                Tidak ada data pengeluaran

            </td>

        </tr>

    @endforelse


        <tr class="total">

            <td>
                TOTAL BEBAN USAHA
            </td>

            <td class="text-end">

                Rp
                {{ number_format(
                    $totalPengeluaran,
                    0,
                    ',',
                    '.'
                ) }}

            </td>

        </tr>


    </tbody>

</table>



{{-- =========================================================
     LABA / RUGI
     ========================================================= --}}

<div class="final">

    <table style="width:100%; border:none; margin:0;">

        <tr>

            <td
                style="
                    border:none;
                    padding:0;
                    font-size:18px;
                    font-weight:700;
                "
            >

                {{ $labaBersih >= 0
                    ? 'LABA BERSIH'
                    : 'RUGI BERSIH'
                }}

            </td>


            <td
                style="
                    border:none;
                    padding:0;
                    text-align:right;
                    font-size:20px;
                    font-weight:700;
                    color:{{ $labaBersih >= 0
                        ? '#16a34a'
                        : '#dc2626'
                    }};
                "
            >

                Rp
                {{ number_format(
                    abs($labaBersih),
                    0,
                    ',',
                    '.'
                ) }}

            </td>

        </tr>

    </table>

</div>



{{-- =========================================================
     TANDA TANGAN
     ========================================================= --}}

<div class="signature">

    <div class="signature-date">

        Kalitinggar,

        {{ \Carbon\Carbon::now()
            ->locale('id')
            ->translatedFormat('d F Y')
        }}

    </div>


    <table class="signature-table">

        <tr>

            <td width="33%">

                <div class="signature-title">
    Mengetahui,<br>
    Ketua Unit Usaha Fotokopi<br>
    Jayadirana
</div>

            </td>


            <td width="33%">

                <div class="signature-title">
    Diperiksa oleh,<br>
    Bendahara BUM Desa
</div>


            </td>


            <td width="33%">

                <div class="signature-title">
    Disetujui oleh,<br>
    Direktur BUM Desa
</div>

            </td>

        </tr>


        <tr>

            <td class="signature-space"></td>

            <td class="signature-space"></td>

            <td class="signature-space"></td>

        </tr>


        <tr>

            <td class="signature-name">
                (.......................................)
            </td>

            <td class="signature-name">
                (.......................................)
            </td>

            <td class="signature-name">
                (.......................................)
            </td>

        </tr>

    </table>

</div>



<div class="page-break"></div>



{{-- =========================================================
     =========================================================
     HALAMAN 2
     DETAIL PENDAPATAN
     =========================================================
     ========================================================= --}}


<div class="detail-kop">


    <table class="kop-table">

        <tr>

            {{-- LOGO BUM DESA --}}

            <td class="kop-logo-left">

                <img
                    src="{{ public_path('images/logo bumdes.jpeg') }}"
                    class="kop-logo"
                    alt="Logo BUM Desa"
                >

            </td>


            {{-- ISI KOP --}}

            <td class="kop-center">

                <div class="kop-instansi">
                    BUM DESA KALITINGGAR MAKMUR KALITINGGAR
                </div>

                <div class="kop-unit">
                    UNIT USAHA FOTOKOPI JAYADIRANA
                </div>

                <div class="kop-alamat">
                    Desa Kalitinggar RT 01 RW 03,
                    Karang Malang,
                    Kec. Padamara,
                    Kab. Purbalingga, 53372
                </div>

            </td>


            {{-- LOGO JAYADIRANA --}}

            <td class="kop-logo-right">

                <img
                    src="{{ public_path('images/logo fc.jpeg') }}"
                    class="kop-logo"
                    alt="Logo Jayadirana"
                >

            </td>

        </tr>

    </table>


    <div class="kop-garis"></div>

</div>



{{-- =========================================================
     JUDUL DETAIL PENDAPATAN
     ========================================================= --}}

<div class="text-center mb-20">

    <h2
        style="
            font-size:22px;
            font-weight:bold;
        "
    >
        DETAIL PENDAPATAN
    </h2>


    <p
        style="
            margin-top:5px;
            font-size:13px;
        "
    >
        Periode {{ $periode }}
    </p>

</div>



{{-- =========================================================
     INFORMASI JUMLAH TRANSAKSI
     ========================================================= --}}

<table class="transaction-info">

    <tr>

        <td>

            Jumlah Total Transaksi Pendapatan

        </td>


        <td
            width="25%"
            class="jumlah-transaksi"
        >

            {{ $pendapatan->count() }}

            Transaksi

        </td>

    </tr>

</table>



{{-- =========================================================
     DETAIL PENDAPATAN
     TAMBAH KOLOM HARGA
     ========================================================= --}}

<table class="detail-table">

    <thead>

        <tr>

            <th width="6%">
                No
            </th>

            <th width="14%">
                Tanggal
            </th>

            <th width="20%">
                Kategori
            </th>

            <th width="26%">
                Nama Barang / Jasa
            </th>

            <th width="10%">
                Jumlah
            </th>

            <th width="12%">
                Harga
            </th>

            <th width="12%">
                Total
            </th>

        </tr>

    </thead>


    <tbody>


    @forelse($pendapatan as $item)

        @php

            $jumlahItem = $item->jumlah ?? 1;

            $hargaItem = $item->harga ?? (
                $jumlahItem > 0
                    ? $item->total / $jumlahItem
                    : 0
            );

        @endphp


        <tr>

            <td class="text-center">

                {{ $loop->iteration }}

            </td>


            <td class="text-center">

                {{ \Carbon\Carbon::parse(
                    $item->tanggal
                )->translatedFormat('d F Y') }}

            </td>


            <td>

                {{ $item->category->nama_kategori ?? '-' }}

            </td>


            <td>

                {{ $item->nama_barang }}

            </td>


            <td class="text-center">

                {{ $jumlahItem }}

            </td>


            {{-- HARGA --}}

            <td class="text-end">

                Rp
                {{ number_format(
                    $hargaItem,
                    0,
                    ',',
                    '.'
                ) }}

            </td>


            {{-- TOTAL --}}

            <td class="text-end">

                Rp
                {{ number_format(
                    $item->total,
                    0,
                    ',',
                    '.'
                ) }}

            </td>

        </tr>


    @empty

        <tr>

            <td
                colspan="7"
                class="text-center"
            >

                Tidak ada data pendapatan

            </td>

        </tr>

    @endforelse


        {{-- TOTAL PENDAPATAN --}}

        <tr class="detail-total">

            <td
                colspan="6"
                class="detail-total-label"
            >

                TOTAL PENDAPATAN

            </td>


            <td class="detail-total-value">

                Rp
                {{ number_format(
                    $totalPendapatan,
                    0,
                    ',',
                    '.'
                ) }}

            </td>

        </tr>


    </tbody>

</table>



<div class="page-break"></div>



{{-- =========================================================
     =========================================================
     HALAMAN 3
     DETAIL BEBAN USAHA
     =========================================================
     ========================================================= --}}


<div class="detail-kop">


    <table class="kop-table">

        <tr>

            {{-- LOGO BUM DESA --}}

            <td class="kop-logo-left">

                <img
                    src="{{ public_path('images/logo bumdes.jpeg') }}"
                    class="kop-logo"
                    alt="Logo BUM Desa"
                >

            </td>


            {{-- ISI KOP --}}

            <td class="kop-center">

                <div class="kop-instansi">
                    BUM DESA KALITINGGAR MAKMUR KALITINGGAR
                </div>

                <div class="kop-unit">
                    UNIT USAHA FOTOKOPI JAYADIRANA
                </div>

                <div class="kop-alamat">
                    Desa Kalitinggar RT 01 RW 03,
                    Karang Malang,
                    Kec. Padamara,
                    Kab. Purbalingga, 53372
                </div>

            </td>


            {{-- LOGO JAYADIRANA --}}

            <td class="kop-logo-right">

                <img
                    src="{{ public_path('images/logo fc.jpeg') }}"
                    class="kop-logo"
                    alt="Logo Jayadirana"
                >

            </td>

        </tr>

    </table>


    <div class="kop-garis"></div>

</div>



{{-- =========================================================
     JUDUL DETAIL BEBAN USAHA
     ========================================================= --}}

<div class="text-center mb-20">

    <h2
        style="
            font-size:22px;
            font-weight:bold;
        "
    >
        DETAIL BEBAN USAHA
    </h2>


    <p
        style="
            margin-top:5px;
            font-size:13px;
        "
    >
        Periode {{ $periode }}
    </p>

</div>



{{-- =========================================================
     INFORMASI JUMLAH TRANSAKSI
     ========================================================= --}}

<table class="transaction-info">

    <tr>

        <td>

            Jumlah Total Transaksi Beban Usaha

        </td>


        <td
            width="25%"
            class="jumlah-transaksi"
        >

            {{ $pengeluaran->count() }}

            Transaksi

        </td>

    </tr>

</table>



{{-- =========================================================
     DETAIL BEBAN USAHA
     TAMBAH KOLOM HARGA
     ========================================================= --}}

<table class="detail-table">

    <thead>

        <tr>

            <th width="6%">
                No
            </th>

            <th width="14%">
                Tanggal
            </th>

            <th width="20%">
                Jenis Pengeluaran
            </th>

            <th width="26%">
                Nama Pengeluaran
            </th>

            <th width="10%">
                Jumlah
            </th>

            <th width="12%">
                Harga
            </th>

            <th width="12%">
                Total
            </th>

        </tr>

    </thead>


    <tbody>


    @forelse($pengeluaran as $item)

        @php

            $jumlahItem = $item->jumlah ?? 1;

            $hargaItem = $item->harga ?? (
                $jumlahItem > 0
                    ? $item->total / $jumlahItem
                    : 0
            );

        @endphp


        <tr>

            <td class="text-center">

                {{ $loop->iteration }}

            </td>


            <td class="text-center">

                {{ \Carbon\Carbon::parse(
                    $item->tanggal
                )->translatedFormat('d F Y') }}

            </td>


            <td class="text-center">

                {{ $item->jenis_pengeluaran ?? '-' }}

            </td>


            <td>

                {{ $item->nama_barang }}

            </td>


            <td class="text-center">

                {{ $jumlahItem }}

            </td>


            {{-- HARGA --}}

            <td class="text-end">

                Rp
                {{ number_format(
                    $hargaItem,
                    0,
                    ',',
                    '.'
                ) }}

            </td>


            {{-- TOTAL --}}

            <td class="text-end">

                Rp
                {{ number_format(
                    $item->total,
                    0,
                    ',',
                    '.'
                ) }}

            </td>

        </tr>


    @empty

        <tr>

            <td
                colspan="7"
                class="text-center"
            >

                Tidak ada data pengeluaran

            </td>

        </tr>

    @endforelse


        {{-- TOTAL BEBAN USAHA --}}

        <tr class="detail-total">

            <td
                colspan="6"
                class="detail-total-label"
            >

                TOTAL BEBAN USAHA

            </td>


            <td class="detail-total-value">

                Rp
                {{ number_format(
                    $totalPengeluaran,
                    0,
                    ',',
                    '.'
                ) }}

            </td>

        </tr>


    </tbody>

</table>


</body>

</html>