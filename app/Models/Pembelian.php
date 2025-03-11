<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 'pembelians';
    protected $primaryKey = 'id';
    protected $fillable = ['tanggal_beli'];

    public function barangs() {
        return $this->hasMany(BarangHasPembelian::class, 'pembelians_id');
    }
}
