<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelangganModel extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    protected $primaryKey = 'pelanggan_id';
    protected $fillable = [
        'pelanggan_nama',
        'pelanggan_alamat',
        'pelanggan_notelp',
        'pelanggan_email',
    ];
}
