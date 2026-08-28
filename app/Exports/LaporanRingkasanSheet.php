<?php

namespace App\Exports;

use App\Models\Laporan;
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

    protected int $rowLaba = 0;

    protected int $rowKas = 0;

    protected int $rowTtd = 0;

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
        return 'Laporan Laba Rugi & Kas';
    }

    public function array(): array
    {
        $periode = Carbon::createFromFormat('Y-m', $this->bulan);

        $pendapatan = Pendapatan::with('category')
            ->whereYear('tanggal', $periode->year)
            ->whereMonth('tanggal', $periode->month)
            ->get();

        $pengeluaran = Pengeluaran::whereYear('tanggal', $periode->year)
            ->whereMonth('tanggal', $periode->month)
            ->get();

        $laporan = Laporan::where('bulan', $periode->month)
            ->where('tahun', $periode->year)
            ->first();

        $prevDate = $periode->copy()->subMonth();
        $laporanSebelumnya = Laporan::where('bulan', $prevDate->month)
            ->where('tahun', $prevDate->year)
            ->first();

        $saldoKasLalu = $laporanSebelumnya ? (float) $laporanSebelumnya->total_kas_akhir : 0;

        $pendapatanJasa = (float) $pendapatan->filter(function ($item) {
            return strtolower(trim(optional($item->category)->nama_kategori ?? '')) === 'jasa';
        })->sum('total');

        $pendapatanAtk = (float) $pendapatan->filter(function ($item) {
            return strtolower(trim(optional($item->category)->nama_kategori ?? '')) !== 'jasa';
        })->sum('total');

        $totalPendapatan = (float) $pendapatan->sum('total');

        $pembelianPersediaan = (float) $pengeluaran->where('jenis_pengeluaran', 'Pembelian Persediaan')->sum('total');
        $bebanOperasional = (float) $pengeluaran->where('jenis_pengeluaran', 'Operasional Lainnya')->sum('total');
        $totalPengeluaran = (float) $pengeluaran->sum('total');

        $persediaanAwal = $laporan ? (float) $laporan->persediaan_awal : 0;
        $persediaanAkhir = $laporan ? (float) $laporan->persediaan_akhir : 0;
        $modalTahunan = $laporan ? (float) $laporan->modal_tahunan : 0;
        $pendapatanNonUsaha = $laporan ? (float) $laporan->pendapatan_non_usaha : 0;
        $pph = $laporan ? (float) $laporan->pph : 0;

        $hpp = $persediaanAwal + $pembelianPersediaan - $persediaanAkhir;
        $labaKotor = $totalPendapatan - $hpp;
        $totalBebanUsaha = $bebanOperasional;
        $labaUsaha = $labaKotor - $totalBebanUsaha;
        $labaSebelumPajak = $labaUsaha + $pendapatanNonUsaha;
        $labaBersih = $labaSebelumPajak - $pph;
        $this->labaBersih = $labaBersih;

        $saldoKasAwal = $modalTahunan + $saldoKasLalu;
        $totalKasAkhir = $saldoKasAwal + $labaBersih;

        $data = [];

        // KOP
        $data[] = ['', '', 'BUM DESA KALITINGGAR MAKMUR KALITINGGAR', '', '', '', '', '', '', ''];
        $data[] = ['', '', 'UNIT USAHA FOTOKOPI JAYADIRANA', '', '', '', '', '', '', ''];
        $data[] = ['', '', 'Desa Kalitinggar RT 01 RW 03, Karang Malang, Kecamatan Padamara, Kabupaten Purbalingga, 53372', '', '', '', '', '', '', ''];
        $data[] = ['', '', '', '', '', '', '', '', '', ''];

        // JUDUL
        $data[] = ['', '', 'LAPORAN LABA RUGI & MUTASI KAS', '', '', '', '', '', '', ''];
        $data[] = ['', '', 'Periode '.$periode->translatedFormat('F Y'), '', '', '', '', '', '', ''];
        $data[] = ['', '', '', '', '', '', '', '', '', ''];

        // PENDAPATAN USAHA
        $data[] = ['', 'PENDAPATAN USAHA', '', '', '', '', '', '', '', ''];
        $data[] = ['', '  Pendapatan Jasa', '', '', '', '', '', '', $pendapatanJasa, ''];
        $data[] = ['', '  Pendapatan ATK dan Lain-Lain', '', '', '', '', '', '', $pendapatanAtk, ''];
        $data[] = ['', 'TOTAL PENDAPATAN', '', '', '', '', '', '', $totalPendapatan, ''];
        $data[] = ['', '', '', '', '', '', '', '', '', ''];

        // HARGA POKOK PENJUALAN (HPP)
        $data[] = ['', 'HARGA POKOK PENJUALAN (HPP)', '', '', '', '', '', '', '', ''];
        $data[] = ['', '  Persediaan Awal', '', '', '', '', '', '', $persediaanAwal, ''];
        $data[] = ['', '  Pembelian Persediaan / Bahan', '', '', '', '', '', '', $pembelianPersediaan, ''];
        $data[] = ['', '  Persediaan Akhir', '', '', '', '', '', '', -$persediaanAkhir, ''];
        $data[] = ['', 'TOTAL HARGA POKOK PENJUALAN', '', '', '', '', '', '', $hpp, ''];
        $data[] = ['', 'LABA KOTOR', '', '', '', '', '', '', $labaKotor, ''];
        $data[] = ['', '', '', '', '', '', '', '', '', ''];

        // BEBAN USAHA
        $data[] = ['', 'BEBAN USAHA', '', '', '', '', '', '', '', ''];
        $data[] = ['', '  Beban Operasional & Lainnya', '', '', '', '', '', '', $bebanOperasional, ''];
        $data[] = ['', 'TOTAL BEBAN USAHA', '', '', '', '', '', '', $totalBebanUsaha, ''];
        $data[] = ['', 'LABA USAHA', '', '', '', '', '', '', $labaUsaha, ''];
        $data[] = ['', '', '', '', '', '', '', '', '', ''];

        // NON OPERASIONAL & PAJAK
        $data[] = ['', 'PENDAPATAN DI LUAR USAHA & PAJAK', '', '', '', '', '', '', '', ''];
        $data[] = ['', '  Pendapatan Bunga / Non-Usaha', '', '', '', '', '', '', $pendapatanNonUsaha, ''];
        $data[] = ['', 'LABA BERSIH SEBELUM PAJAK', '', '', '', '', '', '', $labaSebelumPajak, ''];
        $data[] = ['', '  Pajak Penghasilan (PPh)', '', '', '', '', '', '', $pph, ''];

        $this->rowLaba = count($data) + 1;
        $data[] = ['', $labaBersih >= 0 ? 'LABA BERSIH SETELAH PAJAK' : 'RUGI BERSIH SETELAH PAJAK', '', '', '', '', '', '', abs($labaBersih), ''];
        $data[] = ['', '', '', '', '', '', '', '', '', ''];

        // REKAPITULASI KAS
        $data[] = ['', 'REKAPITULASI MUTASI & TOTAL KAS TERSEDIA', '', '', '', '', '', '', '', ''];
        $data[] = ['', '  Modal Disetor / Modal Awal Tahun BUM Desa', '', '', '', '', '', '', $modalTahunan, ''];
        $data[] = ['', '  Akumulasi Saldo Kas Periode Sebelumnya', '', '', '', '', '', '', $saldoKasLalu, ''];
        $data[] = ['', '  Total Saldo Kas Awal Periode', '', '', '', '', '', '', $saldoKasAwal, ''];
        $data[] = ['', '  Laba / (Rugi) Bersih Periode Ini', '', '', '', '', '', '', $labaBersih, ''];

        $this->rowKas = count($data) + 1;
        $data[] = ['', 'TOTAL KAS TERSEDIA (SALDO KAS AKHIR PERIODE)', '', '', '', '', '', '', $totalKasAkhir, ''];
        $data[] = ['', '', '', '', '', '', '', '', '', ''];

        // TANDA TANGAN
        $this->rowTtd = count($data) + 1;
        $data[] = ['', 'Mengetahui,', '', '', 'Diperiksa oleh,', '', '', 'Disetujui oleh,', '', ''];
        $data[] = ['', 'Ketua Unit Usaha Fotokopi Jayadirana', '', '', 'Bendahara BUM Desa', '', '', 'Direktur BUM Desa', '', ''];
        $data[] = ['', '', '', '', '', '', '', '', '', ''];
        $data[] = ['', '', '', '', '', '', '', '', '', ''];
        $data[] = ['', '', '', '', '', '', '', '', '', ''];
        $data[] = ['', '(__________________________)', '', '', '(__________________________)', '', '', '(__________________________)', '', ''];

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:J'.$sheet->getHighestRow())
            ->getFont()
            ->setName('Times New Roman');

        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setWidth(11);
        $sheet->getColumnDimension('K')->setWidth(2);

        $sheet->mergeCells('C1:I1');
        $sheet->mergeCells('C2:I2');
        $sheet->mergeCells('C3:I3');

        $sheet->getStyle('C1:I3')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getStyle('C1:I1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('C2:I2')->getFont()->setBold(true)->setSize(13);
        $sheet->getStyle('C3:I3')->getFont()->setSize(9);

        $sheet->getStyle('B4:K4')->applyFromArray([
            'borders' => ['bottom' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['argb' => 'FF000000']]],
        ]);

        $sheet->mergeCells('C5:I5');

        $sheet->mergeCells('C6:I6');

        $sheet->getStyle('C5:I6')
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        $sheet->getStyle('C5:I5')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('C6:I6')->getFont()->setItalic(true)->setSize(11);

        for ($row = 8; $row <= $this->rowKas; $row++) {
            $sheet->mergeCells("B{$row}:H{$row}");
            $sheet->mergeCells("I{$row}:J{$row}");
        }

        $sheet->getStyle('I8:J'.$this->rowKas)
            ->getNumberFormat()
            ->setFormatCode('#,##0');

        $sheet->getStyle('I8:J'.$this->rowKas)
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle("B{$this->rowLaba}:J{$this->rowLaba}")->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $this->labaBersih >= 0 ? 'E2F0D9' : 'FCE4D6']],
        ]);

        $sheet->getStyle("B{$this->rowKas}:J{$this->rowKas}")->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F4E78']],
        ]);

        $r = $this->rowTtd;
        $sheet->mergeCells("B{$r}:D{$r}");
        $sheet->mergeCells("E{$r}:G{$r}");
        $sheet->mergeCells("H{$r}:J{$r}");

        $sheet->mergeCells('B'.($r + 1).':D'.($r + 1));
        $sheet->mergeCells('E'.($r + 1).':G'.($r + 1));
        $sheet->mergeCells('H'.($r + 1).':J'.($r + 1));

        $sheet->mergeCells('B'.($r + 5).':D'.($r + 5));
        $sheet->mergeCells('E'.($r + 5).':G'.($r + 5));
        $sheet->mergeCells('H'.($r + 5).':J'.($r + 5));

        $sheet->getStyle("B{$r}:J".($r + 5))
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 3,
            'B' => 13,
            'C' => 13,
            'D' => 13,
            'E' => 13,
            'F' => 13,
            'G' => 13,
            'H' => 13,
            'I' => 9,
            'J' => 9,
        ];
    }

    public function drawings()
    {
        $drawings = [];
        $logoBum = public_path('images/logo bumdes.jpeg');
        if (file_exists($logoBum)) {
            $logo = new Drawing;
            $logo->setName('Logo BUM Desa');
            $logo->setPath($logoBum);
            $logo->setHeight(85);
            $logo->setCoordinates('B1');
            $logo->setOffsetX(10);
            $logo->setOffsetY(10);
            $drawings[] = $logo;
        }

        $logoJaya = public_path('images/logo fc.jpeg');
        if (file_exists($logoJaya)) {
            $logo = new Drawing;
            $logo->setName('Logo Jayadirana');
            $logo->setPath($logoJaya);
            $logo->setHeight(85);
            $logo->setCoordinates('J1');
            $logo->setOffsetX(-15);
            $logo->setOffsetY(10);
            $drawings[] = $logo;
        }

        return $drawings;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->setShowGridlines(false);
                $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_PORTRAIT);
                $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setFitToWidth(1);
                $sheet->getPageSetup()->setFitToHeight(0);
            },
        ];
    }
}
