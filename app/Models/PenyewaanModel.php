<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PelangganModel;

class PenyewaanModel extends Model
{
    use HasFactory;

    protected $table = 'penyewaan';
    protected $primaryKey = 'penyewaan_id';
    protected $fillable = [
        'penyewaan_pelanggan_id',
        'penyewaan_tglsewa',
        'penyewaan_tglkembali',
        'penyewaan_sttspembayaran',
        'penyewaan_sttskembali',
        'penyewaan_totalahrga',
    ];

    // Relasi ke model Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(PelangganModel::class, 'penyewaan_pelanggan_id', 'pelanggan_id');
    }
}
