<?php

namespace App\Http\Controllers;

use App\Models\PelangganModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $pelangganModel;
    public function __construct()
    {
        $this->pelangganModel = new PelangganModel;
    }
    public function index()
    {
        try {
            $pelanggan = $this->pelangganModel->get();

            if ($pelanggan->isEmpty()) {
                return response()->json([
                    'message' => 'Data Pelanggan masih kosong',
                    'data' => $pelanggan
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Data Pelanggan berhasil didapatkan',
                    'data' => $pelanggan
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi Kesalahan pada Server',

            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
            $validator = Validator::make($request->all(), [
                'pelanggan_nama' => 'required|string|max:150',
                'pelanggan_alamat' => 'required|string|max:200',
                'pelanggan_notelp' => 'required|string|max:13',
                'pelanggan_email' => 'required|string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ]);
            } else {
                $pelanggan = $this->pelangganModel->create($validator->validated());

                return response()->json([
                    'message' => 'Data Pelanggan berhasil dibuat',
                    'data' => $pelanggan
                ]);
            }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $pelanggan = $this->pelangganModel->find($id);

            if (!$pelanggan) {
                return response()->json([
                    'message' => 'Data Pelanggan tidak ditemukan',
                ], 404);
            } else {
                return response()->json([
                    'message' => 'Data Pelanggan berhasil ditemukan',
                    'data' => $pelanggan
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'pelanggan_nama' => 'required|string|max:150',
                'pelanggan_alamat' => 'required|string|max:200',
                'pelanggan_notelp' => 'required|char|max:13',
                'pelanggan_email' => 'required|string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            } else {
                $pelanggan = $this->pelangganModel->find($id);

                if (!$pelanggan) {
                    return response()->json([
                        'message' => 'Data Pelanggan tidak ditemukan'
                    ], 404);
                } else {
                    return response()->json([
                        'message' => 'Data Pelanggan berhasil ditemukan',
                        'data' => $pelanggan
                    ], 200);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $pelanggan = $this->pelangganModel->get($id);

            if (!$pelanggan) {
                return response()->json([
                    'message' => 'Data pelanggan tidak ditemukan'
                ], 404);
            } else {
                return response()->json([
                    'message' => 'Data Pelanggan berhasil ditemukan',
                    'data' => $pelanggan
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }
}
