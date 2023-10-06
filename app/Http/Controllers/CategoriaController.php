<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::get();

        return response()->json($categorias, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validar
        $request->validate([
            "nombre" => "required|unique:categorias"
        ]);
        // guardar
        $cat = new Categoria();
        $cat->nombre = $request->nombre;
        $cat->detalle = $request->detalle;
        $cat->save();
        // responder
        return response()->json(["message" => "Categoria registrado"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categoria = Categoria::findOrFail($id);

        return response()->json($categoria, 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validar
        $request->validate([
            "nombre" => "required|unique:categorias,nombre,$id"
        ]);
        // guardar
        $cat = Categoria::findOrFail($id);
        $cat->nombre = $request->nombre;
        $cat->detalle = $request->detalle;
        $cat->update();
        // responder
        return response()->json(["message" => "Categoria registrado"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cat = Categoria::findOrFail($id);
        $cat->delete();
        return response()->json(["message" => "Categoria eliminada"]);
    }

    public function categoriaListaProducto($id){
        $cat = Categoria::with('productos')->findOrFail($id);
        return response()->json($cat);
    }
}
