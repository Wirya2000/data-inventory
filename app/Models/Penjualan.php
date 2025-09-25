<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualans';
    protected $primaryKey = 'id';
    protected $fillable = ['tanggal', 'nama_customer', 'total'];

    public function user()
    {
        return $this->belongsTo(User::class,'users_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customers_id');
    }

    public function barangs()
    {
        return $this->belongsToMany(Barang::class, 'barangs_has_penjualans', 'penjualans_id', 'barangs_id')->withPivot('jumlah','harga_satuan')
        ->withTimestamps();
    }
}
