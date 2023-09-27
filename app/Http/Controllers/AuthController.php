<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function funIngresar(Request $request){

        $credenciales = $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        if(!Auth::attempt($credenciales)) {
            return response()->json(["message" => "Credenciales Incorrectas"], 401);
        }

        // $usuario = Auth::user();
        $usuario = $request->user();

        $token = $usuario->createToken("token personal")->plainTextToken;

        return response()->json([
            "access_token" => $token,
            "usuario" => $usuario
        ], 201);

    }

    public function funRegistro(Request $request){

    }

    public function funPerfil(Request $request){
        
        return response()->json($request->user(), 200);
    }

    public function funSalir(Request $request){
        $request->user()->tokens()->delete();
        return response()->json(["message" => "salio"], 200);
    }
}
