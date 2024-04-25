<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelangganDataModel extends Model
{
    protected $table = 'pelanggan_data';
    protected $primaryKey = 'pelanggan_data_id';
    protected $fillable = [
        'pelanggan_data_pelanggan_id',
        'pelanggan_data_jenis',
        'pelanggan_data_file',
    ];
    public function get_pelangganData()
    {
        return self::all();
    }
    public function create_pelangganData($data)
    {
        return self::create($data);
    }

    public function update_pelangganData($data, $id)
    {
        $pelangganData = self::find($id);
        $pelangganData->fill($data);
        $pelangganData->update();
        return $pelangganData;
    }

    public function delete_pelangganData($id)
    {
        $pelangganData = self::find($id);
        self::destroy($id);
        return $pelangganData;
    }
}
