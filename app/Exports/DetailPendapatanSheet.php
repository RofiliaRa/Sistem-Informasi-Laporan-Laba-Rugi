<?php

namespace App\Exports;

use App\Models\Pendapatan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DetailPendapatanSheet implements FromArray, WithColumnWidths, WithDrawings, WithEvents, WithStyles, WithTitle
{
    protected string $bulan;

    public function __construct(string $bulan)
    {
        $this->bulan = $bulan;
    }

    // =========================================================
    // NAMA SHEET
    // =========================================================

    public function title(): string
    {
        return 'Detail Pendapatan';
    }

    // =========================================================
    // DATA
    // =========================================================

    public function array(): array
    {
        $periode = Carbon::createFromFormat(
            'Y-m',
            $this->bulan
        );

        /*
        |--------------------------------------------------------------------------
        | STRUKTUR KOLOM
        |--------------------------------------------------------------------------
        |
        | A = margin kosong
        | B = No.
        | C = Tanggal
        | D = Kategori
        | E = Nama Barang/Jasa
        | F = Jumlah
        | G = Harga
        | H = Total
        |
        */

        $data = [

            // =================================================
            // KOP
            // =================================================

            [
                '',
                '',
                'BUM DESA KALITINGGAR MAKMUR KALITINGGAR',
                '',
                '',
                '',
                '',
                '',
            ],

            [
                '',
                '',
                'UNIT USAHA FOTOKOPI JAYADIRANA',
                '',
                '',
                '',
                '',
                '',
            ],

            [
                '',
                '',
                'Desa Kalitinggar RT 01 RW 03, Karang Malang, Kecamatan Padamara, Kabupaten Purbalingga, 53372',
                '',
                '',
                '',
                '',
                '',
            ],

            // =================================================
            // BARIS KOSONG
            // =================================================

            [
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
            ],

            // =================================================
            // JUDUL
            // =================================================

            [
                '',
                '',
                'DETAIL PENDAPATAN',
                '',
                '',
                '',
                '',
                '',
            ],

            [
                '',
                '',
                'Periode '.$periode->translatedFormat('F Y'),
                '',
                '',
                '',
                '',
                '',
            ],

            // =================================================
            // JARAK SEBELUM TABEL
            // =================================================

            [
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
            ],

            // =================================================
            // HEADER TABEL
            // =================================================

            [
                '',
                'No.',
                'Tanggal',
                'Kategori',
                'Nama Barang/Jasa',
                'Jumlah',
                'Harga',
                'Total',
            ],
        ];

        // =========================================================
        // AMBIL DATA PENDAPATAN
        // =========================================================

        $pendapatan = Pendapatan::with('category')
            ->whereYear(
                'tanggal',
                $periode->year
            )
            ->whereMonth(
                'tanggal',
                $periode->month
            )
            ->orderBy('tanggal')
            ->orderBy('id')
            ->get();

        $no = 1;

        $totalPendapatan = 0;

        // =========================================================
        // DATA TRANSAKSI
        // =========================================================

        foreach ($pendapatan as $item) {

            $jumlah = $item->jumlah ?? 1;

            $harga = $item->harga ?? 0;

            $total = $item->total ??
                ($jumlah * $harga);

            $totalPendapatan += $total;

            $data[] = [

                // A
                '',

                // B - No.
                $no++,

                // C - Tanggal
                Carbon::parse(
                    $item->tanggal
                )->format('d-m-Y'),

                // D - Kategori
                optional(
                    $item->category
                )->nama_kategori ?? '-',

                // E - Nama Barang/Jasa
                $item->nama_barang ?? '-',

                // F - Jumlah
                $jumlah,

                // G - Harga
                $harga,

                // H - Total
                $total,
            ];
        }

        // =========================================================
        // TOTAL PENDAPATAN
        // =========================================================
        //
        // B:G akan di-merge.
        // Maka tulisan harus berada di B.
        //

        $data[] = [

            // A
            '',

            // B
            'TOTAL PENDAPATAN',

            // C
            '',

            // D
            '',

            // E
            '',

            // F
            '',

            // G
            '',

            // H
            $totalPendapatan,
        ];

        return $data;
    }

    // =========================================================
    // STYLES
    // =========================================================

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

        // =========================================================
        // FONT UTAMA
        // =========================================================

        $sheet->getStyle(
            'A1:H'.$lastRow
        )
            ->getFont()
            ->setName('Times New Roman');

        // =========================================================
        // KOP
        // =========================================================
        //
        // C:G digunakan sebagai area utama tulisan kop.
        //
        // B = logo kiri
        // C:G = isi kop
        // H = logo kanan
        //

        $sheet->mergeCells('C1:G1');
        $sheet->mergeCells('C2:G2');
        $sheet->mergeCells('C3:G3');

        $sheet->getStyle('C1:G3')
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        // =========================================================
        // NAMA BUM DESA
        // =========================================================

        $sheet->getStyle('C1:G1')
            ->getFont()
            ->setBold(true)
            ->setSize(14);

        // =========================================================
        // NAMA UNIT
        // =========================================================

        $sheet->getStyle('C2:G2')
            ->getFont()
            ->setBold(true)
            ->setSize(13);

        // =========================================================
        // ALAMAT
        // =========================================================

        $sheet->getStyle('C3:G3')
            ->getFont()
            ->setSize(9);

        // =========================================================
        // GARIS BAWAH KOP
        // =========================================================

        $sheet->getStyle('B4:H4')
            ->applyFromArray([

                'borders' => [

                    'bottom' => [

                        'borderStyle' => Border::BORDER_MEDIUM,

                        'color' => [
                            'argb' => 'FF000000',
                        ],
                    ],
                ],
            ]);

        // =========================================================
        // JUDUL
        // =========================================================

        $sheet->mergeCells('C5:G5');

        $sheet->getStyle('C5:G5')
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        $sheet->getStyle('C5:G5')
            ->getFont()
            ->setBold(true)
            ->setSize(17);

        // =========================================================
        // PERIODE
        // =========================================================

        $sheet->mergeCells('C6:G6');

        $sheet->getStyle('C6:G6')
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        $sheet->getStyle('C6:G6')
            ->getFont()
            ->setItalic(true)
            ->setSize(11);

        // =========================================================
        // HEADER TABEL
        // =========================================================

        $sheet->getStyle('B8:H8')
            ->applyFromArray([

                'font' => [

                    'name' => 'Times New Roman',

                    'bold' => true,

                    'color' => [
                        'rgb' => 'FFFFFF',
                    ],

                    'size' => 11,
                ],

                'fill' => [

                    'fillType' => Fill::FILL_SOLID,

                    'startColor' => [
                        'rgb' => '1F4E78',
                    ],
                ],

                'alignment' => [

                    'horizontal' => Alignment::HORIZONTAL_CENTER,

                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

        // =========================================================
        // BORDER TABEL
        // =========================================================

        $sheet->getStyle(
            "B8:H{$lastRow}"
        )
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        // =========================================================
        // TOTAL PENDAPATAN
        // =========================================================

        $sheet->mergeCells(
            "B{$lastRow}:G{$lastRow}"
        );

        $sheet->getStyle(
            "B{$lastRow}:H{$lastRow}"
        )
            ->applyFromArray([

                'font' => [

                    'name' => 'Times New Roman',

                    'bold' => true,

                    'size' => 11,
                ],

                'fill' => [

                    'fillType' => Fill::FILL_SOLID,

                    'startColor' => [
                        'rgb' => 'EAF2F8',
                    ],
                ],
            ]);

        // =========================================================
        // LABEL TOTAL
        // =========================================================

        $sheet->getStyle(
            "B{$lastRow}:G{$lastRow}"
        )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        // =========================================================
        // NOMINAL TOTAL
        // =========================================================

        $sheet->getStyle(
            "H{$lastRow}"
        )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        // =========================================================
        // FORMAT ANGKA
        // =========================================================

        $sheet->getStyle(
            "G9:H{$lastRow}"
        )
            ->getNumberFormat()
            ->setFormatCode('#,##0');

        // =========================================================
        // ALIGNMENT NO.
        // =========================================================

        $sheet->getStyle(
            "B9:B{$lastRow}"
        )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        // =========================================================
        // ALIGNMENT TANGGAL
        // =========================================================

        $sheet->getStyle(
            "C9:C{$lastRow}"
        )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        // =========================================================
        // ALIGNMENT JUMLAH
        // =========================================================

        $sheet->getStyle(
            "F9:F{$lastRow}"
        )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        // =========================================================
        // ALIGNMENT HARGA
        // =========================================================

        $sheet->getStyle(
            "G9:G{$lastRow}"
        )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        // =========================================================
        // ALIGNMENT TOTAL
        // =========================================================

        $sheet->getStyle(
            "H9:H{$lastRow}"
        )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        return [];
    }

    // =========================================================
    // LEBAR KOLOM
    // =========================================================

    public function columnWidths(): array
    {
        return [

            // Margin kiri
            'A' => 3,

            // No.
            'B' => 9,

            // Tanggal
            'C' => 17,

            // Kategori
            'D' => 27,

            // Nama Barang/Jasa
            'E' => 31,

            // Jumlah
            'F' => 11,

            // Harga
            'G' => 14,

            // Total
            'H' => 13,
        ];
    }

    // =========================================================
    // LOGO
    // =========================================================

    public function drawings()
    {
        $drawings = [];

        // =========================================================
        // LOGO BUM DESA
        // =========================================================

        $logoBum = public_path(
            'images/logo bumdes.jpeg'
        );

        if (file_exists($logoBum)) {

            $logo = new Drawing;

            $logo->setName(
                'Logo BUM Desa'
            );

            $logo->setDescription(
                'Logo BUM Desa Kalitinggar Makmur'
            );

            $logo->setPath(
                $logoBum
            );

            // Ukuran
            $logo->setHeight(90);

            // Kolom posisi
            $logo->setCoordinates('B1');

            // Sedikit ke kanan
            $logo->setOffsetX(8);

            // Sedikit turun
            $logo->setOffsetY(13);

            $drawings[] = $logo;
        }

        // =========================================================
        // LOGO JAYADIRANA
        // =========================================================

        $logoJaya = public_path(
            'images/logo fc.jpeg'
        );

        if (file_exists($logoJaya)) {

            $logo = new Drawing;

            $logo->setName(
                'Logo Jayadirana'
            );

            $logo->setDescription(
                'Logo Unit Fotokopi Jayadirana'
            );

            $logo->setPath(
                $logoJaya
            );

            // Ukuran
            $logo->setHeight(90);

            // Kolom posisi
            $logo->setCoordinates('H1');

            // Geser ke kanan agar
            // tidak menabrak area kop
            $logo->setOffsetX(-2);

            // Turunkan agar sejajar
            // dengan logo kiri
            $logo->setOffsetY(13);

            $drawings[] = $logo;
        }

        return $drawings;
    }

    // =========================================================
    // EVENTS
    // =========================================================

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (
                AfterSheet $event
            ) {

                $sheet =
                    $event->sheet->getDelegate();

                $lastRow =
                    $sheet->getHighestRow();

                // =================================================
                // GRIDLINES
                // =================================================

                $sheet->setShowGridlines(false);

                // =================================================
                // TINGGI BARIS KOP
                // =================================================

                $sheet->getRowDimension(1)
                    ->setRowHeight(31);

                $sheet->getRowDimension(2)
                    ->setRowHeight(27);

                $sheet->getRowDimension(3)
                    ->setRowHeight(22);

                $sheet->getRowDimension(4)
                    ->setRowHeight(8);

                // =================================================
                // JUDUL
                // =================================================

                $sheet->getRowDimension(5)
                    ->setRowHeight(34);

                $sheet->getRowDimension(6)
                    ->setRowHeight(22);

                // =================================================
                // JARAK SEBELUM TABEL
                // =================================================

                $sheet->getRowDimension(7)
                    ->setRowHeight(12);

                // =================================================
                // HEADER TABEL
                // =================================================

                $sheet->getRowDimension(8)
                    ->setRowHeight(28);

                // =================================================
                // BARIS DATA
                // =================================================

                for (
                    $i = 9;
                    $i <= $lastRow;
                    $i++
                ) {

                    $sheet->getRowDimension($i)
                        ->setRowHeight(22);
                }

                // =================================================
                // PAGE SETUP
                // =================================================

                $sheet->getPageSetup()
                    ->setOrientation(
                        PageSetup::ORIENTATION_PORTRAIT
                    );

                $sheet->getPageSetup()
                    ->setPaperSize(
                        PageSetup::PAPERSIZE_A4
                    );

                // =================================================
                // FIT TO PAGE
                // =================================================

                $sheet->getPageSetup()
                    ->setFitToWidth(1);

                $sheet->getPageSetup()
                    ->setFitToHeight(1);

                // =================================================
                // MARGIN
                // =================================================

                $sheet->getPageMargins()
                    ->setTop(0.30);

                $sheet->getPageMargins()
                    ->setBottom(0.30);

                $sheet->getPageMargins()
                    ->setLeft(0.40);

                $sheet->getPageMargins()
                    ->setRight(0.40);

                // =================================================
                // PRINT AREA
                // =================================================
                //
                // Semua berhenti di H.
                //

                $sheet->getPageSetup()
                    ->setPrintArea(
                        'B1:H'.$lastRow
                    );

                // =================================================
                // POSISI CETAK
                // =================================================

                $sheet->getPageSetup()
                    ->setHorizontalCentered(true);

                $sheet->getPageSetup()
                    ->setVerticalCentered(false);
            },
        ];
    }
}
