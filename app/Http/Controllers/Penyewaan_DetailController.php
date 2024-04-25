<?php

namespace App\Http\Controllers;

use App\Models\PenyewaanDetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenyewaanDetailController extends Controller
{
    protected $penyewaanDetailModel;
    public function __construct()
    {
        $this->penyewaanDetailModel = new PenyewaanDetailModel();
    }
    public function index()
    {
        try
        {
            $penyewaanDetail = $this->penyewaanDetailModel->get_penyewaanDetail();

            if (count($penyewaanDetail) === 0)
            {
                return response()->json([
                    'status' => 204,
                    'msg' => 'Data penyewaan detail masih kosong',
                    'data' => $penyewaanDetail
                ], 204);
            }
            else
            {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Data penyewaan detail berhasil didapatkan',
                    'data' => $penyewaanDetail,
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
            $penyewaanDetail = PenyewaanDetailModel::find($id);

            if ($penyewaanDetail == null) {
                return response()->json([
                    'status' => 404,
                    'msg' => 'Gagal mendapatkan data penyewaan detail! Data tidak ditemukan',
                    'data' => $penyewaanDetail
                ], 404);
            } else {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Berhasil mendapatkan data penyewaan detail',
                    'data' => $penyewaanDetail
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
                'penyewaan_detail_penyewaan_id' => 'required|numeric',
                'penyewaan_detail_alat_id' => 'required|numeric',
                'penyewaan_detail_jumlah' => 'required|numeric',
                'penyewaan_detail_subharga' => 'required|numeric',
            ], [
                'numeric' => 'Data harus berupa angka!',
                'required' => 'Kolom tidak boleh kosong!',
            ]);

            if ($validator->fails())
            {
                return response()->json([
                    'status' => 422,
                    'msg' => 'Gagal menambahkan data penyewaan detail!',
                    'errors' => $validator->errors()
                ], 422);
            }
            else
            {
                $penyewaanDetail = $this->penyewaanDetailModel->create_penyewaanDetail($validator->validated());

                return response()->json([
                    'status' => 201,
                    'msg' => 'Data penyewaan detail berhasil dibuat',
                    'data' => $penyewaanDetail
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
                'penyewaan_detail_penyewaan_id' => 'required|numeric',
                'penyewaan_detail_alat_id' => 'required|numeric',
                'penyewaan_detail_jumlah' => 'required|numeric',
                'penyewaan_detail_subharga' => 'required|numeric',
            ], [
                'numeric' => 'Data harus berupa angka!',
                'required' => 'Kolom tidak boleh kosong!',
            ]);

            if ($validator->fails())
            {
                return response()->json([
                    'status' => 422,
                    'msg' => 'Gagal update data penyewaan detail!',
                    'errors' => $validator->errors()
                ], 422);
            }
            else
            {
                $penyewaanDetail = $this->penyewaanDetailModel->update_penyewaanDetail($validator->validated(), $id);

                return response()->json([
                    'status' => 200,
                    'msg' => 'Data penyewaan detail berhasil diupdate',
                    'data' => $penyewaanDetail
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
            $penyewaanDetail = $this->penyewaanDetailModel->delete_penyewaanDetail($id);

            if ($penyewaanDetail == null) {
                return response()->json([
                    'status' => 404,
                    'msg' => 'Gagal menghapus data penyewaan detail! Data tidak ditemukan',
                    'data' => $penyewaanDetail
                ], 404);
            } else {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Berhasil menghapus data penyewaan detail',
                    'data' => $penyewaanDetail
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
