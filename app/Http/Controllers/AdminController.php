<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function store(Request $request){
        try {
            $data = $request->all();
            $data['password'] = Hash::make($request->password);
            
            $response = Admin::create($data)->createToken($request->server('HTTP_USER_AGENT'))->plainTextToken;

            return response()->json([
                'status'=>'success',
                'message' => "Admin cadastrado com sucesso",
                'token' => $response
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>'error',
                'message' => $th->getMessage()
            ],500);
        }
    }

    public function login(Request $request){
        try {
            if (Auth::guard('admins')->attempt([
                'email' => $request->email,
                'password' => $request->password
            ])){
                $user = Auth::guard('admins')->user();
                $token = $user->createToken($request->server('HTTP_USER_AGENT',['admin']))->plainTextToken;

                return response()->json([
                    'status'=>true,
                    'message' => "Login realizado com sucesso",
                    'token' => $token
                ],200);
            }
            else{
                return response()->json([
                    'status'=>false,
                    'message' => "credenciais incorretas"
                ],200);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status'=>'error',
                'message' => $th->getMessage()
            ],500);
        }
    }

    public function verificaUsuarioLogado(Request $request){
        //return Auth::user() instanceof Admin;
        return Auth::user();
    }
}
