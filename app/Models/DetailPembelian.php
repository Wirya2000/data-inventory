<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    protected $fillable = [
        'pembelian_id',
        'barang_id',
        'jumlah',
        'harga_satuan',
        'sisa_qty'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }
}
