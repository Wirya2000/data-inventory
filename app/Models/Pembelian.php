<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 'pembelians';
    protected $primaryKey = 'id';
    protected $fillable = ['tanggal_beli', 'total', 'users_id', 'suppliers_id'];

    public function user()
    {
        return $this->belongsTo(User::class,'users_id');
    }

    public function barangs()
    {
        return $this->belongsToMany(Barang::class, 'barangs_has_pembelians', 'pembelians_idpembelians', 'barangs_idbarangs')->withPivot('jumlah','harga_satuan');
    }
}
