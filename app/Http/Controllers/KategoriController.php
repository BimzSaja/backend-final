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
        $this->kategoriModel = new KategoriModel;
    }

    public function index()
    {
        try {
            $kategori = $this->kategoriModel->get();

            if ($kategori->isEmpty()) {
                return response()->json([
                    'message' => 'Data Kategori masih kosong',
                    'data' => $kategori
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Data Kategori berhasil didapatkan',
                    'data' => $kategori
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi Kesalahan pada Server',
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'kategori_nama' => 'required|string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            } else {
                $kategori = $this->kategoriModel->create($validator->validated());

                return response()->json([
                    'message' => 'Data Kategori berhasil dibuat',
                    'data' => $kategori
                ], 201);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi Kesalahan pada Server',
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $kategori = $this->kategoriModel->find($id);

            if (!$kategori) {
                return response()->json([
                    'message' => 'Data Kategori tidak ditemukan',
                ], 404);
            } else {
                return response()->json([
                    'message' => 'Data Kategori berhasil ditemukan',
                    'data' => $kategori
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi Kesalahan pada Server',
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'kategori_nama' => 'required|string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            } else {
                $kategori = $this->kategoriModel->find($id);

                if (!$kategori) {
                    return response()->json([
                        'message' => 'Data Kategori tidak ditemukan'
                    ], 404);
                } else {
                    $kategori->update($validator->validated());

                    return response()->json([
                        'message' => 'Data Kategori berhasil diperbarui',
                        'data' => $kategori
                    ], 200);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi Kesalahan pada Server',
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $kategori = $this->kategoriModel->find($id);

            if (!$kategori) {
                return response()->json([
                    'message' => 'Data Kategori tidak ditemukan'
                ], 404);
            } else {
                $kategori->delete();

                return response()->json([
                    'message' => 'Data Kategori berhasil dihapus',
                ], 200);
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi Kesalahan pada Server',
            ], 500);
        }
    }
}
