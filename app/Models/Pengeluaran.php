<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $fillable = [
        'tanggal',
        'nama_barang',
        'jenis_pengeluaran',
        'jumlah',
        'harga',
        'total',
        'keterangan',
    ];
}
