<?php

namespace App\Http\Controllers;

use App\Models\AlatModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlatController extends Controller
{
    protected $alatModel;
    public function __construct()
    {
        $this->alatModel = new AlatModel();
    }
    public function index()
    {
        try
        {
            $alat = $this->alatModel->get_alat();

            if (count($alat) === 0)
            {
                return response()->json([
                    'status' => 204,
                    'msg' => 'Data alat masih kosong',
                    'data' => $alat
                ], 204);
            }
            else
            {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Data alat berhasil didapatkan',
                    'data' => $alat,
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
            $alat = AlatModel::find($id);

            if ($alat == null) {
                return response()->json([
                    'status' => 404,
                    'msg' => 'Gagal mendapatkan data alat! Data tidak ditemukan',
                    'data' => $alat
                ], 404);
            } else {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Berhasil mendapatkan data alat',
                    'data' => $alat
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
                'alat_kategori_id' => 'required|numeric',
                'alat_nama' => 'required|string|max:150',
                'alat_deskripsi' => 'required|string|max:255',
                'alat_hargaperhari' => 'required|numeric',
                'alat_stok' => 'required|numeric',
            ], [
                'numeric' => 'Data harus berupa angka!',
                'required' => 'Kolom tidak boleh kosong!',
                'string' => 'Data harus berupa teks!',
                'max' => 'Panjang data tidak boleh lebih dari :max karakter!',
            ]);

            if ($validator->fails())
            {
                return response()->json([
                    'status' => 422,
                    'msg' => 'Gagal menambahkan data alat!',
                    'errors' => $validator->errors()
                ], 422);
            }
            else
            {
                $alat = $this->alatModel->create_alat($validator->validated());

                return response()->json([
                    'status' => 201,
                    'msg' => 'Data alat berhasil dibuat',
                    'data' => $alat
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
                'alat_kategori_id' => 'required|numeric',
                'alat_nama' => 'required|string|max:150',
                'alat_deskripsi' => 'required|string|max:255',
                'alat_hargaperhari' => 'required|numeric',
                'alat_stok' => 'required|numeric',
            ], [
                'numeric' => 'Data harus berupa angka!',
                'required' => 'Kolom tidak boleh kosong!',
                'string' => 'Data harus berupa teks!',
                'max' => 'Panjang data tidak boleh lebih dari :max karakter!',
            ]);

            if ($validator->fails())
            {
                return response()->json([
                    'status' => 422,
                    'msg' => 'Gagal update data alat!',
                    'errors' => $validator->errors()
                ], 422);
            }
            else
            {
                $alat = $this->alatModel->update_alat($validator->validated(), $id);

                return response()->json([
                    'status' => 200,
                    'msg' => 'Data alat berhasil diupdate',
                    'data' => $alat
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
            $alat = $this->alatModel->delete_alat($id);

            if ($alat == null) {
                return response()->json([
                    'status' => 404,
                    'msg' => 'Gagal menghapus data alat! Data tidak ditemukan',
                    'data' => $alat
                ], 404);
            } else {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Berhasil menghapus data alat',
                    'data' => $alat
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
