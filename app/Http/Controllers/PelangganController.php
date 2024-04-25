<?php

namespace App\Http\Controllers;

use App\Models\PelangganModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{
    protected $pelangganModel;
    public function __construct()
    {
        $this->pelangganModel = new PelangganModel();
    }
    public function index()
    {
        try
        {
            $pelanggan = $this->pelangganModel->get_pelanggan();

            if (count($pelanggan) === 0)
            {
                return response()->json([
                    'status' => 204,
                    'msg' => 'Data pelanggan masih kosong',
                    'data' => $pelanggan
                ], 204);
            }
            else
            {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Data pelanggan berhasil didapatkan',
                    'data' => $pelanggan,
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
            $pelanggan = PelangganModel::find($id);

            if ($pelanggan == null) {
                return response()->json([
                    'status' => 404,
                    'msg' => 'Gagal mendapatkan data pelanggan! Data tidak ditemukan',
                    'data' => $pelanggan
                ], 404);
            } else {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Berhasil mendapatkan data pelanggan',
                    'data' => $pelanggan
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
                'pelanggan_nama' => 'required|string|max:150',
                'pelanggan_alamat' => 'required|string|max:200',
                'pelanggan_notelp' => 'required|string|max:13',
                'pelanggan_email' => 'required|string|max:100',
            ], [
                'required' => 'Kolom tidak boleh kosong!',
                'string' => 'Data pada harus berupa teks!',
                'max' => 'Panjang data pada tidak boleh lebih dari :max karakter!',
            ]);

            if ($validator->fails())
            {
                return response()->json([
                    'status' => 422,
                    'msg' => 'Gagal menambahkan data pelanggan!',
                    'errors' => $validator->errors()
                ], 422);
            }
            else
            {
                $pelanggan = $this->pelangganModel->create_pelanggan($validator->validated());

                return response()->json([
                    'status' => 201,
                    'msg' => 'Data pelanggan berhasil dibuat',
                    'data' => $pelanggan
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
                'pelanggan_nama' => 'required|string|max:150',
                'pelanggan_alamat' => 'required|string|max:200',
                'pelanggan_notelp' => 'required|string|max:13',
                'pelanggan_email' => 'required|string|max:100',
            ], [
                'required' => 'Kolom tidak boleh kosong!',
                'string' => 'Data harus berupa teks!',
                'max' => 'Panjang data tidak boleh lebih dari :max karakter!',
            ]);

            if ($validator->fails())
            {
                return response()->json([
                    'status' => 422,
                    'msg' => 'Gagal update data pelanggan!',
                    'errors' => $validator->errors()
                ], 422);
            }
            else
            {
                $pelanggan = $this->pelangganModel->update_pelanggan($validator->validated(), $id);

                return response()->json([
                    'status' => 200,
                    'msg' => 'Data pelanggan berhasil diupdate',
                    'data' => $pelanggan
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
            $pelanggan = $this->pelangganModel->delete_pelanggan($id);

            if ($pelanggan == null) {
                return response()->json([
                    'status' => 404,
                    'msg' => 'Gagal menghapus data pelanggan! Data tidak ditemukan',
                    'data' => $pelanggan
                ], 404);
            } else {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Berhasil menghapus data pelanggan',
                    'data' => $pelanggan
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
