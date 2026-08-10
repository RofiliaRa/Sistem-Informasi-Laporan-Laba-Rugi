<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendapatan extends Model
{
    protected $fillable = [
        'tanggal',
        'category_id',
        'nama_barang',
        'jumlah',
        'harga',
        'total',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
