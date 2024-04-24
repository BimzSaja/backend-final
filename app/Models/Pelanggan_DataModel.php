<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan_DataModel extends Model
{
    use HasFactory;

    protected $table = 'pelanggan_data';
    protected $primaryKey = 'pelanggan_data_id';
    protected $fillable = [
        'pelanggan_data_pelanggan_id',
        'pelanggan_data_jenis',
        'pelanggan_data_file',
    ];
    
    public function pelanggan()
    {
        return $this->belongsTo(PelangganModel::class, 'pelanggan_data_pelanggan_id', 'pelanggan_id');
    }
    
    public function get_pelanggan_data()
    {
        return self::all();
    }
}
