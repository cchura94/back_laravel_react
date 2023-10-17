<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // /api/producto?q=&page=1
        $q = isset($request->q)?$request->q:null;
        if($q){

            $productos = Producto::where('nombre', 'like', '%'.$q.'%')
                                    ->orWhere('precio', 'like', '%'.$q.'%')
                                    ->orderBy('id', 'desc')
                                    ->with('categoria')
                                    ->paginate(5);

        }else{
            $productos = Producto::orderBy('id', 'desc')
                                    ->with('categoria')
                                    ->paginate(5);
        }

        return response()->json($productos);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validamos
        $request->validate([
            "nombre" => "required",
            "categoria_id" => "required",
            "precio" => "required"
        ]);
        
        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $request->categoria_id;
        $producto->save();

        return response()->json(["message" => "Producto Registrado"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function actualizarImagen(string $id, Request $request){
        if($file = $request->file("imagen")){
            $direccion_imagen = time() . "-". $file->getClientOriginalName();
            $file->move("imagenes", $direccion_imagen);

            $direccion_imagen = "imagenes/" .$direccion_imagen;

            $producto = Producto::findOrFail($id);
            $producto->imagen = $direccion_imagen;
            $producto->update();

            return response()->json(["message" => "Imagen actualizada"]);
        }
        return response()->json(["message" => "Se requiere una imagen para actualizar"], 422);
    }
}
