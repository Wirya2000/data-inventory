<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barangs';
    protected $primaryKey = 'id';
    protected $fillable = ['kode', 'nama', 'satuan', 'stock', 'harga_beli', 'harga_jual', 'kategoris_id', 'satuans_id'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategoris_id');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuans_id');
    }

    public function pembelians()
    {
        return $this->belongsToMany(Barang::class, 'barangs_has_pembelians', 'barangs_id', 'pembelians_idpembelians')->withPivot('jumlah','harga_satuan');
    }

    public function penjualans()
    {
        return $this->belongsToMany(Barang::class, 'barangs_has_penjualans', 'barangs_idW', 'penjualans_idpenjualans')->withPivot('jumlah','harga_satuan');
    }
}
