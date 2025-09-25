<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 'pembelians';
    protected $primaryKey = 'id';
    protected $fillable = ['tanggal', 'total', 'users_id', 'suppliers_id'];

    public function user()
    {
        return $this->belongsTo(User::class,'users_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'suppliers_id');
    }

    public function barangs()
    {
        return $this->belongsToMany(Barang::class, 'barangs_has_pembelians', 'pembelians_id', 'barangs_id')->withPivot('jumlah','harga_satuan')
        ->withTimestamps();
    }
}
