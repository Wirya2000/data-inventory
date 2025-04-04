<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualans';
    protected $primaryKey = 'id';
    protected $fillable = ['tanggal', 'nama_pembeli', 'total'];

    public function barangs()
    {
        return $this->belongsToMany(Barang::class, 'barangs_has_penjualans', 'penjualans_idpenjualans', 'barangs_idbarangs')->withPivot('jumlah','harga_satuan');
    }
}
