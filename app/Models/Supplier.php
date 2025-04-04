<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'suppliers';
    protected $primaryKey = 'id';
    protected $fillable = ['nama', 'alamat', 'no_telp', 'note'];

    public function pembelian() {
        return $this->hasMany(Pembelian::class, 'suppliers_id');
    }
}
