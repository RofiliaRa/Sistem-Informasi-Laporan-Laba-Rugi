<?php

namespace App\Exports;

use App\Models\Pendapatan;
use App\Models\Pengeluaran;
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

class LaporanRingkasanSheet implements FromArray, WithColumnWidths, WithDrawings, WithEvents, WithStyles, WithTitle
{
    protected string $bulan;

    protected string $status;

    protected Carbon $dicetakPada;

    protected int $rowBebanHeader;

    protected int $rowBebanTotal;

    protected int $rowLaba;
    protected int $rowTtd;
    protected int $rowTanggal;


    protected float $labaBersih = 0;

    public function __construct(
        string $bulan,
        string $status = 'draft',
        ?Carbon $dicetakPada = null
    ) {
        $this->bulan = $bulan;

        $this->status = $status;

        $this->dicetakPada = $dicetakPada
            ?? Carbon::now('Asia/Jakarta');
    }

    public function title(): string
    {
        return 'Laporan Laba Rugi';
    }

    public function array(): array
    {
        Carbon::setLocale('id');

        $periode = Carbon::createFromFormat(
            'Y-m',
            $this->bulan
        );

        // =========================================================
        // PENDAPATAN
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

        $totalPendapatan = $pendapatan->sum('total');

        $pendapatanJasa = $pendapatan
            ->filter(function ($item) {
                return optional($item->category)
                    ->nama_kategori === 'Jasa';
            })
            ->sum('total');

        $pendapatanAtk = $pendapatan
            ->filter(function ($item) {
                return optional($item->category)
                    ->nama_kategori === 'ATK dan Lain-Lain';
            })
            ->sum('total');

        // =========================================================
        // PENGELUARAN
        // =========================================================

        $pengeluaran = Pengeluaran::whereYear(
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

        $totalPengeluaran = $pengeluaran->sum('total');

        $labaBersih =
            $totalPendapatan -
            $totalPengeluaran;

        $this->labaBersih = (float) $labaBersih;

        /*
        |--------------------------------------------------------------------------
        | STRUKTUR LAPORAN
        |--------------------------------------------------------------------------
        |
        | A = margin kosong
        | B:H = keterangan
        | I:J = nominal
        |
        |--------------------------------------------------------------------------
        */

        $data = [];

        // =========================================================
        // KOP
        // =========================================================

        $data[] = [
            '', '', 'BUM DESA KALITINGGAR MAKMUR KALITINGGAR',
            '', '', '', '', '', '', ''
        ];

        $data[] = [
            '', '', 'UNIT USAHA FOTOKOPI JAYADIRANA',
            '', '', '', '', '', '', ''
        ];

        $data[] = [
            '', '', 'Desa Kalitinggar RT 01 RW 03, Karang Malang, Kecamatan Padamara, Kabupaten Purbalingga, 53372',
            '', '', '', '', '', '', ''
        ];

        $data[] = [
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ];

        // =========================================================
        // JUDUL
        // =========================================================

        $data[] = [
            '', '', 'LAPORAN LABA RUGI',
            '', '', '', '', '', '', ''
        ];

        $data[] = [
            '', '', 'Periode ' . $periode->translatedFormat('F Y'),
            '', '', '', '', '', '', ''
        ];

        // =========================================================
// DICETAK PADA
// =========================================================

$data[] = [
    '',
    '',
    'Dicetak pada : ' .
        $this->dicetakPada->translatedFormat('d F Y') .
        ' pukul ' .
        $this->dicetakPada->format('H:i') .
        ' WIB',
    '',
    '',
    '',
    '',
    '',
    '',
    ''
];

// Spasi setelah "Dicetak pada"
$data[] = [
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    ''
];

// =========================================================
// PENDAPATAN USAHA
// =========================================================

        $data[] = [
            '', 'PENDAPATAN USAHA',
            '', '', '', '', '', '', '', ''
        ];

        $data[] = [
            '', 'Pendapatan Jasa',
            '', '', '', '', '', '', $pendapatanJasa, ''
        ];

        $data[] = [
            '', 'Pendapatan Penjualan ATK dan Lain-Lain',
            '', '', '', '', '', '', $pendapatanAtk, ''
        ];

        $data[] = [
            '', 'TOTAL PENDAPATAN',
            '', '', '', '', '', '', $totalPendapatan, ''
        ];

        $data[] = [
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ];

        // =========================================================
        // BEBAN USAHA
        // =========================================================

        $this->rowBebanHeader =
            count($data) + 1;

        $data[] = [
            '', 'BEBAN USAHA',
            '', '', '', '', '', '', '', ''
        ];

        // Ringkasan beban berdasarkan jenis pengeluaran.

        $bebanPembelianPersediaan =
            $pengeluaran
                ->where(
                    'jenis_pengeluaran',
                    'Pembelian Persediaan'
                )
                ->sum('total');

        $bebanOperasionalLainnya =
            $pengeluaran
                ->where(
                    'jenis_pengeluaran',
                    'Operasional Lainnya'
                )
                ->sum('total');

        if ($bebanPembelianPersediaan > 0) {

            $data[] = [
                '', 'Beban Pembelian Persediaan',
                '', '', '', '', '', '', $bebanPembelianPersediaan, ''
            ];
        }

        if ($bebanOperasionalLainnya > 0) {

            $data[] = [
                '', 'Beban Operasional Lainnya',
                '', '', '', '', '', '', $bebanOperasionalLainnya, ''
            ];
        }

        $this->rowBebanTotal =
            count($data) + 1;

        $data[] = [
            '', 'TOTAL BEBAN',
            '', '', '', '', '', '', $totalPengeluaran, ''
        ];

        $data[] = [
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ];

        // =========================================================
        // LABA / RUGI
        // =========================================================

        $this->rowLaba =
            count($data) + 1;

        $data[] = [
            '',
            $labaBersih >= 0
                ? 'LABA BERSIH'
                : 'RUGI BERSIH',
            '',
            '',
            '',
            '',
            '',
            '',
            abs($labaBersih),
            '',
        ];
        

// Spasi setelah tabel laba/rugi
$data[] = [
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    ''
];


        // =========================================================
        // TANGGAL LAPORAN
        // =========================================================

        $this->rowTanggal =
            count($data) + 1;

        $data[] = [
            '',
            'Kalitinggar, ' .
                $this->dicetakPada
                    ->translatedFormat('d F Y'),
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ];

        // Satu baris kosong sebelum tanda tangan.

        $data[] = [
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ];

        // =========================================================
        // TANDA TANGAN
        // =========================================================

        $this->rowTtd =
            count($data) + 1;

        // Baris keterangan

        $data[] = [
            '',
            'Mengetahui,', '', '',
            'Diperiksa oleh,', '', '',
            'Disetujui oleh,', '', ''
        ];

        // Baris jabatan

        $data[] = [
            '',
            'Ketua Unit Usaha Fotokokopi Jayadirana', '', '',
            'Bendahara BUM Desa', '', '',
            'Direktur BUM Desa', '', ''
        ];

        // Ruang tanda tangan

        $data[] = [
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ];

        $data[] = [
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ];

        $data[] = [
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ];

        // Nama / tanda tangan

        $data[] = [
            '',
            '(__________________________)', '', '',
            '(__________________________)', '', '',
            '(__________________________)', '', ''
        ];

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        // =========================================================
        // FONT SELURUH LAPORAN
        // =========================================================

$sheet->getStyle('A1:J' . $sheet->getHighestRow())
    ->getFont()
    ->setName('Times New Roman');

    // =========================================================
// LEBAR KOLOM K - HANYA SEBAGAI PERPANJANGAN KOP
// =========================================================
$sheet->getColumnDimension('A')->setWidth(4);
$sheet->getColumnDimension('B')->setWidth(11);
$sheet->getColumnDimension('K')->setWidth(2);

        // =========================================================
        // KOP
        // =========================================================

$sheet->mergeCells('C1:I1');
$sheet->mergeCells('C2:I2');
$sheet->mergeCells('C3:I3');

$sheet->getStyle('C1:I3')
    ->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
    ->setVertical(Alignment::VERTICAL_CENTER);

$sheet->getStyle('C1:I1')
    ->getFont()
    ->setBold(true)
    ->setSize(14);

$sheet->getStyle('C2:I2')
    ->getFont()
    ->setBold(true)
    ->setSize(13);

$sheet->getStyle('C3:I3')
    ->getFont()
    ->setSize(9);
    
        // =========================================================
        // GARIS KOP
        // =========================================================
        
        $sheet->getStyle('B4:K4')->applyFromArray([
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

        $sheet->mergeCells('C5:I5');

        $sheet->mergeCells('C6:I6');

        $sheet->mergeCells('C7:I7');

        $sheet
            ->getStyle('C5:I5')
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        $sheet
            ->getStyle('C5:I5')
            ->getFont()
            ->setBold(true)
            ->setSize(17);

        $sheet
            ->getStyle('C6:I6')
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        $sheet
            ->getStyle('C6:I6')
            ->getFont()
            ->setItalic(true)
            ->setSize(11);

        // =========================================================
        // DICETAK PADA
        // =========================================================

        $sheet
            ->getStyle('C7:I7')
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        $sheet
            ->getStyle('C7:I7')
            ->getFont()
            ->setSize(12);

        // =========================================================
        // HEADER PENDAPATAN
        // =========================================================

        $sheet->mergeCells('B9:J9');

        $sheet
            ->getStyle('B9:J9')
            ->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => [
                        'rgb' => 'FFFFFF'
                    ],
                    'size' => 11,
                ],

                'fill' => [
                    'fillType' =>
                        Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => '1F4E78'
                    ],
                ],

                'alignment' => [
                    'horizontal' =>
                        Alignment::HORIZONTAL_LEFT,

                    'vertical' =>
                        Alignment::VERTICAL_CENTER,
                ],
            ]);

        // =========================================================
        // BARIS PENDAPATAN
        // =========================================================

        for ($row = 10; $row <= 12; $row++) {

            $sheet->mergeCells(
                "B{$row}:H{$row}"
            );

            $sheet->mergeCells(
                "I{$row}:J{$row}"
            );
        }

        $sheet
            ->getStyle('B9:J12')
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $sheet
            ->getStyle('B12:J12')
            ->applyFromArray([
                'font' => [
                    'bold' => true,
                ],

                'fill' => [
                    'fillType' =>
                        Fill::FILL_SOLID,

                    'startColor' => [
                        'rgb' => 'EAF2F8'
                    ],
                ],
            ]);

        // =========================================================
        // HEADER BEBAN
        // =========================================================

        $sheet->mergeCells(
            "B{$this->rowBebanHeader}:J{$this->rowBebanHeader}"
        );

        $sheet
            ->getStyle(
                "B{$this->rowBebanHeader}:J{$this->rowBebanHeader}"
            )
            ->applyFromArray([

                'font' => [
                    'bold' => true,
                    'color' => [
                        'rgb' => 'FFFFFF'
                    ],
                    'size' => 11,
                ],

                'fill' => [
                    'fillType' =>
                        Fill::FILL_SOLID,

                    'startColor' => [
                        'rgb' => '1F4E78'
                    ],
                ],

                'alignment' => [
                    'horizontal' =>
                        Alignment::HORIZONTAL_LEFT,

                    'vertical' =>
                        Alignment::VERTICAL_CENTER,
                ],
            ]);

        $startBeban =
            $this->rowBebanHeader + 1;

        for (
            $row = $startBeban;
            $row < $this->rowBebanTotal;
            $row++
        ) {

            $sheet->mergeCells(
                "B{$row}:H{$row}"
            );

            $sheet->mergeCells(
                "I{$row}:J{$row}"
            );

            $sheet
                ->getStyle("B{$row}:J{$row}")
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );
        }

        $sheet->mergeCells(
            "B{$this->rowBebanTotal}:H{$this->rowBebanTotal}"
        );

        $sheet->mergeCells(
            "I{$this->rowBebanTotal}:J{$this->rowBebanTotal}"
        );

        $sheet
            ->getStyle(
                "B{$this->rowBebanTotal}:J{$this->rowBebanTotal}"
            )
            ->applyFromArray([

                'font' => [
                    'bold' => true,
                ],

                'fill' => [
                    'fillType' =>
                        Fill::FILL_SOLID,

                    'startColor' => [
                        'rgb' => 'EAF2F8'
                    ],
                ],

                'borders' => [

                    'top' => [
                        'borderStyle' =>
                            Border::BORDER_THIN,
                    ],

                    'bottom' => [
                        'borderStyle' =>
                            Border::BORDER_THIN,
                    ],

                    'left' => [
                        'borderStyle' =>
                            Border::BORDER_THIN,
                    ],

                    'right' => [
                        'borderStyle' =>
                            Border::BORDER_THIN,
                    ],
                ],
            ]);

        // =========================================================
// LABA BERSIH
// =========================================================

$sheet->mergeCells(
    "B{$this->rowLaba}:H{$this->rowLaba}"
);

$sheet->mergeCells(
    "I{$this->rowLaba}:J{$this->rowLaba}"
);

$sheet
    ->getStyle(
        "B{$this->rowLaba}:J{$this->rowLaba}"
    )
    ->applyFromArray([

        'font' => [
            'bold' => true,
            'size' => 13,
        ],

        'fill' => [
            'fillType' => Fill::FILL_SOLID,

            'startColor' => [
                'rgb' => $this->labaBersih >= 0
                    ? 'E2F0D9'
                    : 'FCE4D6',
            ],
        ],

        'borders' => [

            'top' => [
                'borderStyle' =>
                    Border::BORDER_THIN,
            ],

            'bottom' => [
                'borderStyle' =>
                    Border::BORDER_THIN,
            ],

            'left' => [
                'borderStyle' =>
                    Border::BORDER_THIN,
            ],

            'right' => [
                'borderStyle' =>
                    Border::BORDER_THIN,
            ],
        ],
    ]);
        // Warna nominal laba/rugi
        // laba = hijau
        // rugi = merah

        $sheet
            ->getStyle(
                "I{$this->rowLaba}:J{$this->rowLaba}"
            )
            ->getFont()
            ->getColor()
            ->setRGB(
                $this->labaBersih >= 0
                    ? '008000'
                    : 'C00000'
            );

        // =========================================================
        // NOMINAL
        // =========================================================

        $sheet
            ->getStyle(
                "I9:J{$this->rowLaba}"
            )
            ->getNumberFormat()
            ->setFormatCode('#,##0');

        $sheet
            ->getStyle(
                "I9:J{$this->rowLaba}"
            )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_RIGHT
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        // =========================================================
        // TANGGAL DI ATAS TANDA TANGAN
        // =========================================================

        $sheet->mergeCells(
            "B{$this->rowTanggal}:J{$this->rowTanggal}"
        );

        $sheet
            ->getStyle(
                "B{$this->rowTanggal}:J{$this->rowTanggal}"
            )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_RIGHT
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        $sheet
            ->getStyle(
                "B{$this->rowTanggal}:J{$this->rowTanggal}"
            )
            ->getFont()
            ->setSize(12);

        // =========================================================
        // TANDA TANGAN
        // =========================================================

        $r = $this->rowTtd;

        $sheet->mergeCells(
            "B{$r}:D{$r}"
        );

        $sheet->mergeCells(
            "E{$r}:G{$r}"
        );

        $sheet->mergeCells(
            "H{$r}:J{$r}"
        );

        $sheet->mergeCells("B" . ($r + 1) . ":D" . ($r + 1));
        $sheet->mergeCells("E" . ($r + 1) . ":G" . ($r + 1));
        $sheet->mergeCells("H" . ($r + 1) . ":J" . ($r + 1));

        $sheet->mergeCells("B" . ($r + 5) . ":D" . ($r + 5));
        $sheet->mergeCells("E" . ($r + 5) . ":G" . ($r + 5));
        $sheet->mergeCells("H" . ($r + 5) . ":J" . ($r + 5));

        $sheet->getStyle("B{$r}:J" . ($r + 5))
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        $sheet->getStyle("B" . ($r + 1) . ":J" . ($r + 1))
            ->getFont()
            ->setBold(true);

        return [];
    }

    public function columnWidths(): array
    {
        return [

            // Margin kiri
            'A' => 3,

            // Area utama
            'B' => 13,
            'C' => 13,
            'D' => 13,
            'E' => 13,
            'F' => 13,
            'G' => 13,
            'H' => 13,

            // Nominal
            'I' => 9,
            'J' => 9,
        ];
    }

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
            $logo = new Drawing();
            $logo->setName('Logo BUM Desa');
            $logo->setDescription('Logo BUM Desa Kalitinggar Makmur');
            $logo->setPath($logoBum);

           $logo->setHeight(90);
$logo->setCoordinates('B1');
$logo->setOffsetX(13);
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
            $logo = new Drawing();
            $logo->setName('Logo Jayadirana');
            $logo->setDescription('Logo Unit Fotokopi Jayadirana');
            $logo->setPath($logoJaya);

          $logo->setHeight(90);
$logo->setCoordinates('J1');
$logo->setOffsetX(-20);
$logo->setOffsetY(13);

            $drawings[] = $logo;
        }

        return $drawings;
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class =>
                function (AfterSheet $event) {

                    $sheet =
                        $event->sheet->getDelegate();

                    // =================================================
                    // TAMPILAN
                    // =================================================

                    $sheet->setShowGridlines(false);

                    // =================================================
                    // WATERMARK DRAFT
                    // =================================================
                    //
                    // DRAFT hanya muncul ketika status masih draft.
                    // Menggunakan header cetak sehingga tidak menutupi
                    // tabel laporan.
                    //
                    // =================================================

                    if ($this->status === 'draft') {

                        $sheet
                            ->getHeaderFooter()
                            ->setOddHeader(
                                '&C&KCCCCCC&"Times New Roman,Bold"&36DRAFT'
                            );

                    } else {

                        $sheet
                            ->getHeaderFooter()
                            ->setOddHeader('');
                    }

                    // =================================================
                    // TINGGI BARIS KOP
                    // =================================================

                    $sheet
                        ->getRowDimension(1)
                        ->setRowHeight(31);

                    $sheet
                        ->getRowDimension(2)
                        ->setRowHeight(27);

                    $sheet
                        ->getRowDimension(3)
                        ->setRowHeight(22);

                    $sheet
                        ->getRowDimension(4)
                        ->setRowHeight(8);

                    // =================================================
                    // JUDUL
                    // =================================================

                    $sheet
                        ->getRowDimension(5)
                        ->setRowHeight(34);

                    $sheet
                        ->getRowDimension(6)
                        ->setRowHeight(22);

                    // Dicetak pada

                    $sheet
                        ->getRowDimension(7)
                        ->setRowHeight(20);
                        
                        // Spasi setelah "Dicetak pada"
$sheet
    ->getRowDimension(8)
    ->setRowHeight(10);

                    // =================================================
                    // TABEL
                    // =================================================

                    $sheet
                        ->getRowDimension(9)
                        ->setRowHeight(26);

                    for (
                        $i = 10;
                        $i <= $sheet->getHighestRow();
                        $i++
                    ) {

                        if (
                            $i !== $this->rowTtd &&
                            $i !== $this->rowTtd + 1 &&
                            $i !== $this->rowTtd + 5 &&
                            $i !== $this->rowTanggal
                        ) {

                            $sheet
                                ->getRowDimension($i)
                                ->setRowHeight(21);
                        }
                    }

                    // =================================================
                    // TANGGAL
                    // =================================================

                    $sheet
                        ->getRowDimension(
                            $this->rowTanggal
                        )
                        ->setRowHeight(22);
                        

                    // =================================================
                    // JARAK SEBELUM TANDA TANGAN
                    // =================================================

                    $sheet
                        ->getRowDimension(
                            $this->rowTanggal + 1
                        )
                        ->setRowHeight(11);

                    // =================================================
                    // TANDA TANGAN
                    // =================================================

                    $sheet
                        ->getRowDimension($this->rowTtd)
                        ->setRowHeight(24);

                    $sheet
                        ->getRowDimension(
                            $this->rowTtd + 1
                        )
                        ->setRowHeight(25);

                    // Ruang tanda tangan

                    $sheet
                        ->getRowDimension(
                            $this->rowTtd + 2
                        )
                        ->setRowHeight(26);

                    $sheet
                        ->getRowDimension(
                            $this->rowTtd + 3
                        )
                        ->setRowHeight(26);

                    $sheet
                        ->getRowDimension(
                            $this->rowTtd + 4
                        )
                        ->setRowHeight(26);

                    $sheet
                        ->getRowDimension(
                            $this->rowTtd + 5
                        )
                        ->setRowHeight(25);

                    // =================================================
                    // PAGE SETUP
                    // =================================================

                    $sheet
                        ->getPageSetup()
                        ->setOrientation(
                            PageSetup::ORIENTATION_PORTRAIT
                        );

                    $sheet
                        ->getPageSetup()
                        ->setPaperSize(
                            PageSetup::PAPERSIZE_A4
                        );

                    $sheet
                        ->getPageSetup()
                        ->setFitToWidth(1);

                    $sheet
                        ->getPageSetup()
                        ->setFitToHeight(1);

                    // =================================================
                    // MARGIN CETAK
                    // =================================================

                    $sheet
                        ->getPageMargins()
                        ->setTop(0.30);

                    $sheet
                        ->getPageMargins()
                        ->setBottom(0.30);

                    $sheet
                        ->getPageMargins()
                        ->setLeft(0.40);

                    $sheet
                        ->getPageMargins()
                        ->setRight(0.40);

                    // =================================================
                    // PRINT AREA
                    // =================================================

                $sheet->getPageSetup()
    ->setPrintArea(
        'B1:K' . $sheet->getHighestRow()
    );

                    // =================================================
                    // POSISI CETAK
                    // =================================================

                    $sheet
                        ->getPageSetup()
                        ->setHorizontalCentered(true);

                    $sheet
                        ->getPageSetup()
                        ->setVerticalCentered(false);
                },
        ];
    }
}
