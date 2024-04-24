<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AlatModel;

class KategoriModel extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'kategori_id';
    protected $fillable = [
        'kategori_nama',
    ];

    
    public function alat()
    {
        return $this->hasMany(AlatModel::class, 'alat_kategori_id', 'kategori_id');
    }
}
