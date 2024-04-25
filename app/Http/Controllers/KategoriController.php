<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    protected $kategoriModel;
    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }
    public function index()
    {
        try
        {
            $kategori = $this->kategoriModel->get_kategori();

            if (count($kategori) === 0)
            {
                return response()->json([
                    'status' => 204,
                    'msg' => 'Data kategori masih kosong',
                    'data' => $kategori
                ], 204);
            }
            else
            {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Data kategori berhasil didapatkan',
                    'data' => $kategori,
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
            $kategori = KategoriModel::find($id);

            if ($kategori == null) {
                return response()->json([
                    'status' => 404,
                    'msg' => 'Gagal mendapatkan data kategori! Data tidak ditemukan',
                    'data' => $kategori
                ], 404);
            } else {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Berhasil mendapatkan data kategori',
                    'data' => $kategori
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
                'kategori_nama' => 'required|string|max:100',
            ], [
                'required' => 'Kolom tidak boleh kosong!',
                'string' => 'Data harus berupa teks!',
                'max' => 'Panjang data tidak boleh lebih dari :max karakter!',
            ]);

            if ($validator->fails())
            {
                return response()->json([
                    'status' => 422,
                    'msg' => 'Gagal menambahkan data kategori!',
                    'errors' => $validator->errors()
                ], 422);
            }
            else
            {
                $kategori = $this->kategoriModel->create_kategori($validator->validated());

                return response()->json([
                    'status' => 201,
                    'msg' => 'Data kategori berhasil dibuat',
                    'data' => $kategori
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
                'kategori_nama' => 'required|string|max:100',
            ], [
                'required' => 'Kolom tidak boleh kosong!',
                'string' => 'Data harus berupa teks!',
                'max' => 'Panjang data tidak boleh lebih dari :max karakter!',
            ]);

            if ($validator->fails())
            {
                return response()->json([
                    'status' => 422,
                    'msg' => 'Gagal update data kategori!',
                    'errors' => $validator->errors()
                ], 422);
            }
            else
            {
                $kategori = $this->kategoriModel->update_kategori($validator->validated(), $id);

                return response()->json([
                    'status' => 200,
                    'msg' => 'Data kategori berhasil diupdate',
                    'data' => $kategori
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
            $kategori = $this->kategoriModel->delete_kategori($id);

            if ($kategori == null) {
                return response()->json([
                    'status' => 404,
                    'msg' => 'Gagal menghapus data kategori! Data tidak ditemukan',
                    'data' => $kategori
                ], 404);
            } else {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Berhasil menghapus data kategori',
                    'data' => $kategori
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
