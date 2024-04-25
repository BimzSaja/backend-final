<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = [
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password']
        ];

        $user = User::create($data);

        return response()->json([
            'status' => 201,
            'message' => 'Pendaftaran akun berhasil dilakukan!',
            'data' => $user
        ], 201);
    }
}
