<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $admin = Admin::create([
            'admin_username' => $request->admin_username,
            'admin_password' => Hash::make($request->admin_password),
        ]);

        $token = auth()->guard('admin-api')->user();

        return response()->json([
            'status' => 201,
            'message' => 'Berhasil Menambahkan Admin!',
            'data' => $admin,
        ], 201);
    }
}

