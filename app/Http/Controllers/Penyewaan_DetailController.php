<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyewaan_DetailModel;
use Illuminate\Support\Facades\Validator;

class Penyewaan_DetailController extends Controller
{
    protected $penyewaanDetailModel;

    public function __construct(Penyewaan_DetailModel $penyewaanDetailModel)
    {
        $this->penyewaanDetailModel = $penyewaanDetailModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $penyewaanDetails = $this->penyewaanDetailModel->all();

            if ($penyewaanDetails->isEmpty()) { {
                    return response()->json([
                        'message' => 'Data Penyewaan Detail masih kosong',
                        'data' => $penyewaanDetails
                    ], 200);
                }
            }
            return response()->json([
                'message' => 'Data Penyewaan Detail berhasil didapatkan',
                'data' => $penyewaanDetails
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penyewaan_detail_penyewaan_id' => 'required|exists:penyewaan,penyewaan_id',
            'penyewaan_detail_alat_id' => 'required|exists:alat,alat_id',
            'penyewaan_detail_jumlah' => 'required|integer',
            'penyewaan_detail_subharga' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'message' => 'Validasi pada data Penyewaan Detail gagal!', 'errors' => $validator->errors()], 422);
        }

        $penyewaanDetail = Penyewaan_DetailModel::create($validator->validated());
        return response()->json(['status' => 201, 'message' => 'Data Penyewaan Detail berhasil di buat!', 'data' => $penyewaanDetail], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $penyewaanDetail = $this->penyewaanDetailModel->findOrFail($id);

            if (!$penyewaanDetail) {
                return response()->json([
                    'message' => 'Data Penyewaan Detail tidak ada'
                ], 404);
            }
            return response()->json([
                'message' => 'Data penyewaan_detail berhasil ditemukan',
                'data' => $penyewaanDetail
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Data penyewaan_detail tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'penyewaan_detail_penyewaan_id' => 'requires|exists:penyewaan,penyewaan_id',
            'penyewaan_detail_alat_id' => 'required|exists:alat,alat_id',
            'penyewaan_detail_jumlah' => 'required|integer',
            'penyewaan_detail_subharga' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422, 
                'message' => 'Validasi pada Penyewaan Detail gagal!', 
                'errors' => $validator->errors()
            ], 422);
        }

        $penyewaanDetail = $this->penyewaanDetailModel->updatePenyewaanDetail($validator->validated(), $id);

        return response()->json([
            'status' => 200, 
            'message' => $penyewaanDetail
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $penyewaanDetail = $this->penyewaanDetailModel->deletePenyewaanDetail($id);

        return response()->json([
            'status' => 200, 
            'message' => 'Data Penyewaan Detail berhasil dihapus!', 
            'data' => $penyewaanDetail
        ], 200);
    }
}