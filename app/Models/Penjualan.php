<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualans';
    protected $primaryKey = 'id';
    protected $fillable = ['tanggal', 'nama_customer', 'total', 'users_id', 'customers_id', 'discount', 'grand_total'];
    protected $dates = ['tanggal'];

    public function user()
    {
        return $this->belongsTo(User::class,'users_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customers_id');
    }

    public function details()
    {
        return $this->hasMany(DetailPenjualan::class, 'penjualans_id');
    }
}
