<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;

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

Route::middleware('auth:sanctum')->group(function(){
    // Hola Mundo
    Route::get("categoria/{id}/lista-productos", [CategoriaController::class, "categoriaListaProducto"]);
    
    Route::post("producto/{id}/actualizar-imagen", [ProductoController::class, "actualizarImagen"]);

    Route::apiResource("usuario", UsuarioController::class);
    Route::apiResource("categoria", CategoriaController::class);
    Route::apiResource("producto", ProductoController::class);
    Route::apiResource("cliente", ClienteController::class);
    Route::apiResource("pedido", PedidoController::class);
});  
