<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanExport implements WithMultipleSheets
{
    protected string $bulan;

    protected string $status;

    protected Carbon $dicetakPada;

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

    public function sheets(): array
    {
        return [

            new LaporanRingkasanSheet(
                $this->bulan,
                $this->status,
                $this->dicetakPada
            ),

            new DetailPendapatanSheet(
                $this->bulan
            ),

            new DetailBebanSheet(
                $this->bulan
            ),

        ];
    }
}
