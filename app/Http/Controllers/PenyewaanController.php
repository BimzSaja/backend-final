<?php

namespace App\Http\Controllers;

use App\Models\AlatModel;
use App\Models\PenyewaanModel;
use App\Models\Penyewaan_DetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PenyewaanController extends Controller
{
    protected $penyewaanModel;

    public function __construct()
    {
        $this->penyewaanModel = new PenyewaanModel;
    }
    public function index()
    {
        try {
            $penyewaan = PenyewaanModel::with('penyewaanDetail')->get();
            
            if ($penyewaan->isEmpty()) {
                return response()->json([
                    'message' => 'Data Penyewaan masih kosong',
                    'data' => $penyewaan
                ], 404);
            }
            return response()->json([
                'message' => 'Data Penyewaan berhasil didapatkan',
                'data' => $penyewaan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi Kesalahan pada Server',
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penyewaan_pelanggan_id' => 'required|exists:pelanggan,pelanggan_id',
            'penyewaan_tglsewa' => 'required|date',
            'penyewaan_tglkembali' => 'required|date',
            'penyewaan_sttspembayaran' => 'in:Lunas,Belum Dibayar,DP',
            'penyewaan_sttskembali' => 'in:Sudah Kembali,Belum Kembali',
            'penyewaan_totalharga' => 'required|integer',
            'detail.*.penyewaan_detail_alat_id' => 'required|exists:alat,alat_id',
            'detail.*.penyewaan_detail_jumlah' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        
            DB::beginTransaction();

            $penyewaan = PenyewaanModel::create($validator->validated());

            foreach ($request->detail as $detail) {
                Penyewaan_DetailModel::create([
                    'penyewaan_detail_penyewaan_id' => $penyewaan->penyewaan_id,
                    'penyewaan_detail_alat_id' => $detail['penyewaan_detail_alat_id'],
                    'penyewaan_detail_jumlah' => $detail['penyewaan_detail_jumlah'],
                    'penyewaan_detail_subharga' => $detail['penyewaan_detail_jumlah'] * AlatModel::find($detail['penyewaan_detail_alat_id'])->alat_hargaperhari,
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Data Penyewaan berhasil dibuat',
                'data' => $penyewaan
            ], 201);
        
    }

    // Metode lainnya seperti show, update, dan destroy tetap sama..


    public function show($id)
    {
        try {
            $penyewaan = $this->penyewaanModel->find($id);

            if (!$penyewaan) {
                return response()->json([
                    'message' => 'Data Penyewaan tidak ditemukan',
                ], 404);
            } else {
                return response()->json([
                    'message' => 'Data Penyewaan berhasil ditemukan',
                    'data' => $penyewaan
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
                'penyewaan_pelanggan_id' => 'required|exists:pelanggan,pelanggan_id',
                'penyewaan_tglsewa' => 'required|date',
                'penyewaan_tglkembali' => 'required|date',
                'penyewaan_sttspembayaran' => 'required|in:Lunas,Belum Dibayar,DP',
                'penyewaan_sttskembali' => 'required|in:Sudah Kembali,Belum Kembali',
                'penyewaan_totalharga' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            } else {
                $penyewaan = $this->penyewaanModel->find($id);

                if (!$penyewaan) {
                    return response()->json([
                        'message' => 'Data Penyewaan tidak ditemukan'
                    ], 404);
                } else {
                    $penyewaan->update($validator->validated());

                    return response()->json([
                        'message' => 'Data Penyewaan berhasil diperbarui',
                        'data' => $penyewaan
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
            $penyewaan = $this->penyewaanModel->find($id);

            if (!$penyewaan) {
                return response()->json([
                    'message' => 'Data Penyewaan tidak ditemukan'
                ], 404);
            } else {
                $penyewaan->delete();

                return response()->json([
                    'message' => 'Data Penyewaan berhasil dihapus',
                ], 200);
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi Kesalahan pada Server',
            ], 500);
        }
    }
}
