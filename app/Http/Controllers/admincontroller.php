<?php

namespace App\Http\Controllers;

use App\Models\admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class admincontroller extends Controller
{
    protected $adminModel;
    public function __construct()
    {
        $this->adminModel = new admin();
    }
    public function index()
    {
        $admin = $this->adminModel->get_product();
        if (count($admin) === 0) {
            return response()->json([], 204);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Data admin berhasil didapatkan!',
                'data' => $admin
            ], 200);
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_username' => 'required|string|max:50',
            'admin_password' => 'required|string|max:255'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'gagal menambahkan data admin!',
                'errors' => $validator->errors()
            ], 422);
        } else {
            $admin = $this->adminModel->create_product($validator->validated());
            return response()->json([
                'status' => 201,
                'message' => 'Data admin berhasil dibuat!',
                'data' => $admin
            ], 201);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'admin_username' => 'required|string|max:50',
            'admin_password' => 'required|string|max:255'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'gagal mengubah data admin!',
                'errors' => $validator->errors()
            ], 422);
        } else {
            $admin = $this->adminModel->update_product($validator->validated(), $id);
            return response()->json([
                'status' => 200,
                'message' => 'Data admin berhasil diupdate!',
                'data' => $admin
            ], 200);
        }
    }
    public function destroy($id)
    {
        $admin = $this->adminModel->delete_admin($id);
        return response()->json([
            'status' => 200,
            'message' => 'Data admin berhasil dihapus!',
            'data' => $admin
        ], 200);
    }
}
