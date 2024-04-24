<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('admin_username', 'admin_password');



        if (Auth::guard('admin-api')->attempt($credentials)) { // untuk memastikan tabel yang digunakan dan authnya (provider / guard)
            $token = Auth::guard('admin-api')->attempt($credentials);
            return response()->json([
                'status' => 200,
                'message' => 'Login Berhasil Dilakukan',
                'data' => auth()->guard('admin-api')->user(), //mendapatkan data pada user yang berhubungan
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }
    }
}
