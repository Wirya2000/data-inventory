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

    public function barangs() {
        return $this->hasMany(BarangHasPenjualan::class, 'penjualans_id');
    }
}
