<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $fillable = ['nama', 'alamat', 'no_telp'];

    public function penjualans() {
        return $this->hasMany(BarangHasPenjualan::class, 'customers_id');
    }
}
