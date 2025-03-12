<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barangs';
    protected $primaryKey = 'id';
    protected $fillable = ['kode', 'nama', 'satuan', 'stock', 'harga_beli', 'harga_jual', 'kategoris_id'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategoris_id');
    }

    public function pembelian()
    {
        return $this->hasMany(BarangHasPembelian::class, 'barangs_id');
    }

    public function penjualan()
    {
        return $this->hasMany(BarangHasPenjualan::class, 'barangs_id');
    }
}
