<!DOCTYPE html>
<html>

    <style>

        .watermark{

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

        body{
            font-family: sans-serif;
            font-size: 11px;
            color:#111827;
            margin:30px;
        }

        h1,h2,h3,h4,h5,p{
            margin:0;
        }

        .text-center{
            text-align:center;
        }

        .text-end{
            text-align:right;
        }

        .mb-20{
            margin-bottom:20px;
        }

        /*
        |--------------------------------------------------------------------------
        | HEADER
        |--------------------------------------------------------------------------
        */

        .header-bumdes{
            font-size:16px;
            font-weight:bold;
        }

        .title{
            font-size:20px;
            font-weight:bold;
            margin-top:8px;
            letter-spacing:0.5px;
        }

        .subtitle{
            font-size:20px;
            margin-top:10px;
            font-weight:bold;
        }

        .periode{
            margin-top:8px;
            font-size:14px;
            font-weight:bold;
        }

        /*
        |--------------------------------------------------------------------------
        | SECTION
        |--------------------------------------------------------------------------
        */

        .section-title{
            margin-top:28px;
            margin-bottom:12px;
            font-size:20px;
            font-weight:bold;
            color:#111827;
        }

        /*
        |--------------------------------------------------------------------------
        | TABLE
        |--------------------------------------------------------------------------
        */

        table{
            width:100%;
            border-collapse: collapse;
            margin-top:10px;
        }

        table td,
        table th{
            padding:10px 12px;
            border:1px solid #d1d5db;
            font-size:12px;
        }

       table th{
    background:#f3f4f6;
    text-align:center;
    vertical-align:middle;
    font-weight:bold;
}

        .total{
            font-weight:bold;
            background:#f3f4f6;
        }

        /*
        |--------------------------------------------------------------------------
        | FINAL RESULT
        |--------------------------------------------------------------------------
        */

        .final{

    margin-top:20px;

    padding:12px 16px;

    border:2px solid #0f172a;

    background:#ffffff;

    color:#0f172a;

    font-size:16px;

    font-weight:700;

}

        /*
        |--------------------------------------------------------------------------
        | SIGNATURE
        |--------------------------------------------------------------------------
        */

        .signature{
            margin-top:18px;
        }

        .signature-date{
            text-align:right;
            margin-bottom:18px;
            font-size:13px;
        }

        .signature-table{
            width:100%;
            border:none;
        }

        .signature-table td{
            border:none;
            text-align:center;
            vertical-align:top;
            font-size:13px;
        }

        .signature-title{
            font-weight:bold;
            font-size:14px;
        }

        .signature-space{
            height:50px;
        }

        .signature-name{
            font-weight:bold;
            margin-top:10px;
        }

        /*
        |--------------------------------------------------------------------------
        | PAGE BREAK
        |--------------------------------------------------------------------------
        */

        .page-break{
            page-break-after: always;
        }

    </style>
<head>
    <meta charset="utf-8">
    <title>Laporan Laba Rugi</title>
</head>

<body>

    @if($status == 'draft')

<div class="watermark">

    DRAFT

</div>

@endif

    {{-- HALAMAN 1 --}}

   <div class="text-center mb-20">

    <div class="header-bumdes">
        BUM DESA KALITINGGAR MAKMUR KALITINGGAR
    </div>

    <div class="title">
        UNIT USAHA FOTOKOPI JAYADIRANA
    </div>

    <div class="subtitle">
        LAPORAN LABA RUGI
    </div>

    <div class="periode">
        Periode {{ $periode }}
    </div>

    <div style="
        margin-top:8px;
        font-size:12px;
        color:#555;
    ">
        Dicetak pada :
        {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
        pukul
        {{ \Carbon\Carbon::now()->format('H:i') }} WIB
    </div>

</div>

    {{-- RINGKASAN PENDAPATAN --}}

    <div class="section-title">
        Ringkasan Pendapatan Usaha
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

            <tr>

                <td>
                    Pendapatan Jasa
                </td>

                <td class="text-end">
                    Rp {{ number_format($pendapatanJasa,0,',','.') }}
                </td>

            </tr>

            <tr>

                <td>
                    Pendapatan Barang
                </td>

                <td class="text-end">
                    Rp {{ number_format($pendapatanBarang,0,',','.') }}
                </td>

            </tr>

            <tr class="total">

                <td>
                    Total Pendapatan
                </td>

                <td class="text-end">
                    Rp {{ number_format($totalPendapatan,0,',','.') }}
                </td>

            </tr>

        </tbody>

    </table>

    {{-- RINGKASAN PENGELUARAN --}}

    <div class="section-title">
        Ringkasan Pengeluaran
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
            Rp {{ number_format($total,0,',','.') }}
        </td>

    </tr>

@empty

    <tr>

        <td colspan="2" class="text-center">
            Tidak ada data pengeluaran
        </td>

    </tr>

@endforelse

<tr class="total">

    <td>
        Total Pengeluaran
    </td>

    <td class="text-end">
        Rp {{ number_format($totalPengeluaran,0,',','.') }}
    </td>

</tr>

</tbody>

    </table>

    {{-- LABA / RUGI --}}

    <div class="final">

    <table style="width:100%; border:none; margin:0;">

        <tr>

            <td style="border:none; padding:0; font-size:18px; font-weight:700;">

                {{ $labaBersih >= 0 ? 'LABA BERSIH' : 'RUGI BERSIH' }}

            </td>

            <td style="
            border:none;
            padding:0;
            text-align:right;
            font-size:20px;
            font-weight:700;
            color:{{ $labaBersih >= 0 ? '#16a34a' : '#dc2626' }};
            ">

                Rp {{ number_format(abs($labaBersih),0,',','.') }}

            </td>

        </tr>

    </table>

</div>
    {{-- TANDA TANGAN --}}

    <div class="signature">

        <div class="signature-date">

            Kalitinggar,
            {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}

        </div>

        <table class="signature-table">

            <tr>

                <td width="33%">

                    <div class="signature-title">
                        Ketua Unit Usaha
                    </div>

                </td>

                <td width="33%">

                    <div class="signature-title">
                        Bendahara BUM Desa
                    </div>

                </td>

                <td width="33%">

                    <div class="signature-title">
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

    {{-- HALAMAN 2 --}}

    <div class="text-center mb-20">

        <h2 style="font-size:24px; font-weight:bold;">
            DETAIL PENDAPATAN
        </h2>

        <p style="margin-top:5px; font-size:13px;">
            Periode {{ $periode }}
        </p>

    </div>
    
    <table style="margin-top:12px;">
    <tr class="total">
        <td>
            Jumlah Total Transaksi Pendapatan
        </td>

        <td width="25%" class="text-end">
            {{ $pendapatan->count() }} Transaksi
        </td>
    </tr>
</table>

    <table>

        <thead>

            <tr>

<th width="8%">No</th>

<th width="17%">Tanggal</th>

<th width="25%" class="text-center">
    Kategori
</th>

<th class="text-center">
    Nama Barang / Jasa
</th>

<th width="20%" class="text-center">
    Total
</th>
            </tr>

        </thead>

        <tbody>

        @foreach($pendapatan as $item)

        <tr>

                <td class="text-center">
                    {{ $loop->iteration }}
                </td>

                <td>
                {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                </td>

                <td>
                    {{ $item->category->nama_kategori ?? '-' }}
                </td>

                <td>
                    {{ $item->nama_barang }}
                </td>

                <td class="text-end">
                    Rp {{ number_format($item->total,0,',','.') }}
                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

    <div class="page-break"></div>

    {{-- HALAMAN 3 --}}

    <div class="text-center mb-20">

        <h2 style="font-size:24px; font-weight:bold;">
            DETAIL PENGELUARAN
        </h2>

        <p style="margin-top:5px; font-size:13px;">
            Periode {{ $periode }}
        </p>

    </div>

<table style="margin-top:12px;">
    <tr class="total">

        <td>
            Jumlah Total Transaksi Pengeluaran
        </td>

        <td width="25%" class="text-end">
            {{ $pengeluaran->count() }} Transaksi
        </td>

    </tr>
</table>

    <table>

        <thead>

<tr>

    <th width="8%">No</th>
   
    <th width="16%">Tanggal</th>

    <th width="25%" class="text-center">
        Jenis Pengeluaran
    </th>

    <th class="text-center">
        Nama Pengeluaran
    </th>

    <th width="18%" class="text-center">
        Total
    </th>

</tr>

</thead>

        <tbody>

        @foreach($pengeluaran as $item)

    <tr>

    <td class="text-center">
        {{ $loop->iteration }}
    </td>

    <td class="text-center">
        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
    </td>
    
    <td class="text-center">
        {{ $item->jenis_pengeluaran }}
    </td>

    <td>
        {{ $item->nama_barang }}
    </td>

    <td class="text-end">
        Rp {{ number_format($item->total,0,',','.') }}
    </td>

</tr>

@endforeach

        </tbody>

       </table>
</body>
</html>