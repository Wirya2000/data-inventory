<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualanBatch extends Model
{
    protected $fillable = [
        'detail_penjualans_id',
        'detail_pembelians_id',
        'qty_diambil',
        'harga_beli',
        'subtotal_modal'
    ];

    public function detailPembelian()
    {
        return $this->belongsTo(DetailPembelian::class);
    }
}
