<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            Log::info('User ' . $request['email'] . ' mencoba login, tetapi gagal!');

            return response()->json([
                'status' => 401,
                'message' => 'Email atau Password anda salah!'
            ], 401);
        } else {
            Log::info('User dengan email ' . $request['email'] . ' berhasil login!');

            return response()->json([
                'status' => 200,
                'message' => 'Login berhasil dilakukan!',
                'data' => auth()->guard('api')->user(),
                'token' => $token
            ]);
        }
    }
}
