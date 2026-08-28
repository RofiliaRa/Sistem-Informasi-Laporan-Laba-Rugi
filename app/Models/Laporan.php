<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $fillable = [
        'bulan',
        'tahun',
        'total_pendapatan',
        'total_pengeluaran',
        'laba_bersih',
        'modal_tahunan',
        'persediaan_awal',
        'persediaan_akhir',
        'hpp',
        'laba_kotor',
        'laba_usaha',
        'pendapatan_non_usaha',
        'pph',
        'saldo_kas_awal',
        'total_kas_akhir',
        'status',
        'file_pdf',
        'file_excel',
        'created_by',
    ];
}
