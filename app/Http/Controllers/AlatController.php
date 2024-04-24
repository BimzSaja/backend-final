<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlatModel;
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
        $alat = $this->alatModel->get();

        if ($alat->isEmpty()) {
            return response()->json([
                'message' => 'Data alat masih kosong!',
                'data' => $alat
            ], 200);
        } else {
            return response()->json([
                'message' => 'Data alat berhasil didapatkan',
                'data' => $alat
            ], 200);
        }
    }


    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'alat_nama' => 'required|string|max:255',
                'alat_kategori_id' => 'required|exists:kategori,kategori_id',
                'alat_deskripsi' => 'nullable|string',
                'alat_hargaperhari' => 'required|numeric|min:0',
                'alat_stok' => 'required|integer|min:0',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validasi Gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $alat = $this->alatModel->create($validator->validated());

            return response()->json([
                'message' => 'Data Alat berhasil dibuat',
                'data' => $alat
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'alat_nama' => 'required|string|max:255',
            'alat_kategori_id' => 'required|exists:kategori,kategori_id',
            'alat_deskripsi' => 'nullable|string',
            'alat_hargaperhari' => 'required|numeric|min:0',
            'alat_stok' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $alat = $this->alatModel->find($id);

        if (!$alat) {
            return response()->json([
                'message' => 'Data alat tidak ditemukan'
            ], 404);
        }

        $alat->update($validator->validated());

        return response()->json([
            'message' => 'Data alat berhasil diperbarui',
            'data' => $alat
        ], 200);
    }

    public function destroy($id)
    {
        $alat = $this->alatModel->find($id);

        if (!$alat) {
            return response()->json([
                'message' => 'Data alat tidak ditemukan'
            ], 404);
        }

        $alat->delete();

        return response()->json([
            'message' => 'Data alat berhasil dihapus'
        ], 200);
    }

    public function show($id)
    {
        $alat = $this->alatModel->find($id);

        if (!$alat) {
            return response()->json([
                'message' => 'Data alat tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Data alat berhasil didapatkan',
            'data' => $alat
        ], 200);
    }
}
