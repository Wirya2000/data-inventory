<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $fillable = [
        'penjualans_id',
        'barangs_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
        'total_modal'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barangs_id');
    }

    public function batches()
    {
        return $this->hasMany(DetailPenjualanBatch::class, 'detail_penjualans_id');
    }
}
