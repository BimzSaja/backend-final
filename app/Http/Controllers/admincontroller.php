<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    protected $adminModel;
    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }
    public function index()
    {
        try
        {
            $admin = $this->adminModel->get_admin();

            if (count($admin) === 0)
            {
                return response()->json([
                    'status' => 204,
                    'msg' => 'Data admin masih kosong',
                    'data' => $admin
                ], 204);
            }
            else
            {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Data admin berhasil didapatkan',
                    'data' => $admin,
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
            $admin = AdminModel::find($id);

            if ($admin == null) {
                return response()->json([
                    'status' => 404,
                    'msg' => 'Gagal mendapatkan data admin! Data tidak ditemukan',
                    'data' => $admin
                ], 404);
            } else {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Berhasil mendapatkan data admin',
                    'data' => $admin
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
            'admin_username' => 'required|string|max:50',
            'admin_password' => 'required|string|max:255'
            ], [
                'required' => 'Kolom tidak boleh kosong!',
                'string' => 'Data harus berupa teks!',
                'max' => 'Panjang data tidak boleh lebih dari :max karakter!',
            ]);

            if ($validator->fails())
            {
                return response()->json([
                    'status' => 422,
                    'msg' => 'Gagal menambahkan data admin!',
                    'errors' => $validator->errors()
                ], 422);
            }
            else
            {
                $admin = $this->adminModel->create_admin($validator->validated());

                return response()->json([
                    'status' => 201,
                    'msg' => 'Data admin berhasil dibuat',
                    'data' => $admin
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
            'admin_username' => 'required|string|max:50',
            'admin_password' => 'required|string|max:255'
            ], [
                'required' => 'Kolom tidak boleh kosong!',
                'string' => 'Data harus berupa teks!',
                'max' => 'Panjang data pada tidak boleh lebih dari :max karakter!',
            ]);

            if ($validator->fails())
            {
                return response()->json([
                    'status' => 422,
                    'msg' => 'Gagal update data admin!',
                    'errors' => $validator->errors()
                ], 422);
            }
            else
            {
                $admin = $this->adminModel->update_admin($validator->validated(), $id);

                return response()->json([
                    'status' => 200,
                    'msg' => 'Data admin berhasil diupdate',
                    'data' => $admin
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
            $admin = $this->adminModel->delete_admin($id);

            if ($admin == null) {
                return response()->json([
                    'status' => 404,
                    'msg' => 'Gagal menghapus data admin! Data tidak ditemukan',
                    'data' => $admin
                ], 404);
            } else {
                return response()->json([
                    'status' => 200,
                    'msg' => 'Berhasil menghapus data admin',
                    'data' => $admin
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
