<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// auth
Route::prefix("v1/auth")->group(function(){

    Route::post("/login", [AuthController::class, "funIngresar"]);
    Route::post("/register", [AuthController::class, "funRegistro"]);

    Route::middleware('auth:sanctum')->group(function(){

        Route::get("/profile", [AuthController::class, "funPerfil"]);
        Route::post("/logout", [AuthController::class, "funSalir"]);
    });

});


Route::apiResource("usuario", UsuarioController::class);