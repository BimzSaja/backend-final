<?php

namespace App\Http\Controllers;

use App\Models\PenyewaanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenyewaanController extends Controller
{
    protected $penyewaanModel;
    public function __construct()
    {
        $this->penyewaanModel = new PenyewaanModel();
    }
    public function index()
    {
        try
        {
            $penyewaan = $this->penyewaanModel->get_penyewaan();

            if (count($penyewaan) === 0)
            {
                return response()->json([
                    'status' => 204,
                    'msg' => 'Data penyewaan masih kosong',
                    'data' => $penyewaan
                ], 204);
            }
            else
            {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Data penyewaan berhasil didapatkan',
                    'data' => $penyewaan,
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
            $penyewaan = PenyewaanModel::find($id);

            if ($penyewaan == null) {
                return response()->json([
                    'status' => 404,
                    'msg' => 'Gagal mendapatkan data penyewaan! Data tidak ditemukan',
                    'data' => $penyewaan
                ], 404);
            } else {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Berhasil mendapatkan data penyewaan',
                    'data' => $penyewaan
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
                'penyewaan_pelanggan_id' => 'required|numeric',
                'penyewaan_tglsewa' => 'required|date',
                'penyewaan_tglkembali' => 'required|date',
                'penyewaan_sttspembayaran' => 'required|in:Lunas,Belum Dibayar,DP',
                'penyewaan_sttskembali' => 'required|in:Sudah Kembali,Belum Kembali',
                'penyewaan_totalharga' => 'required|numeric',
            ], [
                'penyewaan_sttspembayaran.in' => 'Data harus berisi nilai Lunas, Belum Dibayar, atau DP',
                'penyewaan_sttskembali.in' => 'Data harus berisi nilai Sudah Kembali atau Belum Kembali',
                'date' => 'Data harus berupa tanggal! Seperti, 2024-06-24',
                'numeric' => 'Data harus berupa angka!',
                'required' => 'Kolom tidak boleh kosong!',
                'string' => 'Data harus berupa teks!',
                'max' => 'Panjang data tidak boleh lebih dari :max karakter!',
            ]);

            if ($validator->fails())
            {
                return response()->json([
                    'status' => 422,
                    'msg' => 'Gagal menambahkan data penyewaan!',
                    'errors' => $validator->errors()
                ], 422);
            }
            else
            {
                $penyewaan = $this->penyewaanModel->create_penyewaan($validator->validated());

                return response()->json([
                    'status' => 201,
                    'msg' => 'Data penyewaan berhasil dibuat',
                    'data' => $penyewaan
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
                'penyewaan_pelanggan_id' => 'required|numeric',
                'penyewaan_tglsewa' => 'required|date',
                'penyewaan_tglkembali' => 'required|date',
                'penyewaan_sttspembayaran' => 'required|in:Lunas,Belum Dibayar,DP',
                'penyewaan_sttskembali' => 'required|in:Sudah Kembali,Belum Kembali',
                'penyewaan_totalharga' => 'required|numeric',
            ], [
                'date' => 'Data harus berupa tanggal! Seperti, 2024-06-24',
                'numeric' => 'Data harus berupa angka!',
                'required' => 'Kolom tidak boleh kosong!',
                'string' => 'Data harus berupa teks!',
                'max' => 'Panjang data tidak boleh lebih dari :max karakter!',
            ]);

            if ($validator->fails())
            {
                return response()->json([
                    'status' => 422,
                    'msg' => 'Gagal update data penyewaan!',
                    'errors' => $validator->errors()
                ], 422);
            }
            else
            {
                $penyewaan = $this->penyewaanModel->update_penyewaan($validator->validated(), $id);

                return response()->json([
                    'status' => 200,
                    'msg' => 'Data penyewaan berhasil diupdate',
                    'data' => $penyewaan
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
            $penyewaan = $this->penyewaanModel->delete_penyewaan($id);

            if ($penyewaan == null) {
                return response()->json([
                    'status' => 404,
                    'msg' => 'Gagal menghapus data penyewaan! Data tidak ditemukan',
                    'data' => $penyewaan
                ], 404);
            } else {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Berhasil menghapus data penyewaan',
                    'data' => $penyewaan
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
