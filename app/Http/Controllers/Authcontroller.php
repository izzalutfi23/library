<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class Authcontroller extends Controller
{
    public function register(Request $request){
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if($user){
            return response()->json([
                'status' => 'Register sukses'
            ], 200);
        }
        else{
            return response()->json([
                'status' => 'Register gagal'
            ], 201);
        }
    }

    public function login(Request $request){
        $cek = User::where('email', $request->email)->first();
        if($cek){
            if(Hash::check($request->password, $cek->password)){
                return response()->json([
                    'status' => 'Berhasil Login',
                    'token' => $cek->createToken('users')->accessToken,
                    'data' => $cek
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 'password salah'
                ], 400);
            }
        }
        else{
            return response()->json([
                'status' => 'tidak ada'
            ], 404);
        }
        return response()->json(['error'=>$cek], 401);
    }

    public function logoutApi()
    { 
        if (Auth::check()) {
            Auth::user()->AauthAcessToken()->delete();
            return response()->json([
                'status' => 'berhasil',
                'message' => 'Logout berhasil'
            ]);
        }
    }
}
