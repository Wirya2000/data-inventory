<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    protected $fillable = [
        'pembelians_id',
        'barangs_id',
        'jumlah',
        'harga_satuan',
        'sisa_qty'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barangs_id');
    }

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelians_id');
    }
}
