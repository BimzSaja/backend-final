<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\KategoriModel;

class AlatModel extends Model
{
    use HasFactory;

    protected $table = 'alat';
    protected $primaryKey = 'alat_id';
    protected $fillable = [
        'alat_kategori_id',
        'alat_nama',
        'alat_deskripsi',
        'alat_hargaperhari',
        'alat_stok',
    ];
    public function get_alat()
    {
        return self::all();
    }
    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'alat_kategori_id', 'kategori_id');
    }
    public function create_alat($data)
    {
        return self::create($data);
    }
    public function update_alat($data, $id)
    {
        $alat = self::find($id);
        $alat->update($data);
        return $alat;
    }
    public function delete_alat($id)
    {
        $alat = self::find($id);
        $alat->delete();
        return $alat;
    }
}
