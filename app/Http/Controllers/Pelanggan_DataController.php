<?php

namespace App\Http\Controllers;

use App\Models\PelangganDataModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelangganDataController extends Controller
{
    protected $pelangganDataModel;
    public function __construct()
    {
        $this->pelangganDataModel = new PelangganDataModel();
    }
    public function index()
    {
        try
        {
            $pelangganData = $this->pelangganDataModel->get_pelangganData();

            if (count($pelangganData) === 0)
            {
                return response()->json([
                    'status' => 204,
                    'msg' => 'Data pelanggan data masih kosong',
                    'data' => $pelangganData
                ], 204);
            }
            else
            {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Data pelanggan data berhasil didapatkan',
                    'data' => $pelangganData,
                ], 200);
            }

        }
        catch (\Exception)
        {
            return response()->json([
                'status' => 500,
                'msg' => 'Terjadi kesalahan pada server!'
            ], 500);
        }
    }
    public function show ($id) {
        try
        {
            $pelangganData = PelangganDataModel::find($id);

            if ($pelangganData == null) {
                return response()->json([
                    'status' => 404,
                    'msg' => 'Gagal mendapatkan data pelanggan data! Data tidak ditemukan',
                    'data' => $pelangganData
                ], 404);
            } else {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Berhasil mendapatkan data pelanggan data',
                    'data' => $pelangganData
                ], 200);
            }
        }
        catch (\Exception)
        {
            return response()->json([
                'status' => 500,
                'msg' => 'Terjadi kesalahan pada server!'
            ], 500);
        }
    }
    public function store(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'pelanggan_data_pelanggan_id' => 'required|numeric',
                'pelanggan_data_jenis' => 'required|in:KTP,SIM',
                'pelanggan_data_file' => 'required|mimes:jpg,jpeg,png|max:255',
            ], [
                'in' => 'Data harus berisi nilai KTP atau SIM!',
                'mimes' => 'File harus memiliki format .jpg, .png, atau .jepg',
                'numeric' => 'Data harus berupa angka!',
                'required' => 'Kolom tidak boleh kosong!',
                'max' => 'Panjang data tidak boleh lebih dari :max karakter!',
            ]);

            if ($validator->fails())
            {
                return response()->json([
                    'status' => 422,
                    'msg' => 'Gagal menambahkan data pelanggan data!',
                    'errors' => $validator->errors()
                ], 422);
            }
            else
            {
                $pelangganData = $this->pelangganDataModel->create_pelangganData($validator->validated());

                return response()->json([
                    'status' => 201,
                    'msg' => 'Data pelangan data berhasil dibuat',
                    'data' => $pelangganData
                ], 201);
            }
        }
        catch (\Exception)
        {
            return response()->json([
                'status' => 500,
                'msg' => 'Terjadi kesalahan pada server!'
            ], 500);
        }
    }

    public function update (Request $request, $id)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'pelanggan_data_pelanggan_id' => 'required|numeric',
                'pelanggan_data_jenis' => 'required|in:KTP,SIM',
                'pelanggan_data_file' => 'required|mimes:jpg,jpeg,png|max:255',
            ], [
                'in' => 'Data harus berisi nilai KTP atau SIM!',
                'mimes' => 'File harus memiliki format .jpg, .png, atau .jepg',
                'numeric' => 'Data harus berupa angka!',
                'required' => 'Kolom tidak boleh kosong!',
                'max' => 'Panjang data tidak boleh lebih dari :max karakter!',
            ]);

            if ($validator->fails())
            {
                return response()->json([
                    'status' => 422,
                    'msg' => 'Gagal update data pelanggan data!',
                    'errors' => $validator->errors()
                ], 422);
            }
            else
            {
                $pelangganData = $this->pelangganDataModel->update_pelangganData($validator->validated(), $id);

                return response()->json([
                    'status' => 200,
                    'msg' => 'Data pelanggan data berhasil diupdate',
                    'data' => $pelangganData
                ], 200);
            }
        }
        catch (\Exception)
        {
            return response()->json([
                'status' => 500,
                'msg' => 'Terjadi kesalahan pada server!'
            ], 500);
        }
    }

    public function destroy ($id)
    {
        try
        {
            $pelangganData = $this->pelangganDataModel->delete_pelangganData($id);

            if ($pelangganData == null) {
                return response()->json([
                    'status' => 404,
                    'msg' => 'Gagal menghapus data pelanggan data! Data tidak ditemukan',
                    'data' => $pelangganData
                ], 404);
            } else {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Berhasil menghapus data pelanggan data',
                    'data' => $pelangganData
                ], 200);
            }
        }
        catch (\Exception)
        {
            return response()->json([
                'status' => 500,
                'msg' => 'Terjadi kesalahan pada server!'
            ], 500);
        }
    }
}
