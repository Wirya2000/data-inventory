<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;
    protected $table = 'satuans';
    protected $primaryKey = 'id';
    protected $fillable = ['nama'];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'satuans_id');
    }
}
