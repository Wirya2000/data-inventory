<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualanBatch extends Model
{
    protected $fillable = [
        'detail_penjualan_id',
        'detail_pembelian_id',
        'qty_diambil',
        'harga_beli',
        'subtotal_modal'
    ];

    public function detailPembelian()
    {
        return $this->belongsTo(DetailPembelian::class);
    }
}
