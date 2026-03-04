<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barangs';
    protected $primaryKey = 'id';
    protected $fillable = ['kode', 'nama', 'satuan', 'stock', 'minimum_stock', 'harga_jual', 'kategoris_id', 'satuans_id'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategoris_id');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuans_id');
    }

    // public function pembelians()
    // {
    //     return $this->belongsToMany(Pembelian::class, 'barangs_has_pembelians', 'barangs_id', 'pembelians_idpembelians')->withPivot('jumlah','harga_satuan', 'sisa_qty')->withTimestamps();
    // }

    // public function penjualans()
    // {
    //     return $this->belongsToMany(Penjualan::class, 'barangs_has_penjualans', 'barangs_id', 'penjualans_idpenjualans')->withPivot('jumlah','harga_satuan', 'total_modal')->withTimestamps();
    // }
    public function detailPembelians()
    {
        return $this->hasMany(DetailPembelian::class);
    }

    public function detailPenjualans()
    {
        return $this->hasMany(DetailPenjualan::class);
    }
}
