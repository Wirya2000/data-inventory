<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategoris';
    protected $primaryKey = 'id';
    protected $fillable = ['kode', 'nama'];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'kategoris_id');
    }
}
