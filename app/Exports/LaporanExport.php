<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanExport implements WithMultipleSheets
{
    protected string $bulan;

    public function __construct(string $bulan)
    {
        $this->bulan = $bulan;
    }

    public function sheets(): array
    {
        return [
            new LaporanRingkasanSheet($this->bulan),
            new DetailPendapatanSheet($this->bulan),
            new DetailBebanSheet($this->bulan),
        ];
    }
}
