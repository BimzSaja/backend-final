<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyewaanDetailModel extends Model
{
    protected $table = 'penyewaan_detail';
    protected $primaryKey = 'penyewaan_detail_id';
    protected $fillable = [
        'penyewaan_detail_penyewaan_id',
        'penyewaan_detail_alat_id',
        'penyewaan_detail_jumlah',
        'penyewaan_detail_subharga',
    ];
    public function get_penyewaanDetail ()
    {
        return self::all();
    }
    public function create_penyewaanDetail ($data)
    {
        return self::create($data);
    }

    public function update_penyewaanDetail($data, $id)
    {
        $penyewaanDetail = self::find($id);
        $penyewaanDetail->fill($data);
        $penyewaanDetail->update();
        return $penyewaanDetail;
    }

    public function delete_penyewaanDetail($id)
    {
        $penyewaanDetail = self::find($id);
        self::destroy($id);
        return $penyewaanDetail;
    }
}
