<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = Pedido::orderBy('id', 'desc')->paginate(10);
        return response()->json($pedidos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validar
        $request->validate([
            "cliente_id" => "required",
            "productos" => "required"
        ]);
        /*
        {
            cliente_id: 5,
            productos: [
                {producto_id: 6, cantidad: 2},
                {producto_id: 3, cantidad: 1},
                {producto_id: 2, cantidad: 1},
                {producto_id: 8, cantidad: 5},
                {producto_id: 4, cantidad: 2},
            ]
        }
        */

        // guardar
        DB::beginTransaction();

        try {
            // aqui la consulta SQL o eloquent ORM
            $cliente_id = $request->cliente_id;
            $productos = $request->productos;

            $pedido = new Pedido();
            $pedido->fecha = date("Y-m-d H:i:s");
            $pedido->cliente_id = $cliente_id;
            $pedido->estado = 1;
            $pedido->save();

            // asignar productos
            foreach ($productos as $prod) {
                $producto_id = $prod["producto_id"];
                $cantidad = $prod["cantidad"];

                // muchos a muchos
                $pedido->productos()->attach($producto_id, ["cantidad" => $cantidad]);
            }

            $pedido->estado = 2;
            $pedido->update();

            DB::commit();
            // all good
            return response()->json(["message" => "Pedido Registrado"], 201);
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return response()->json([
                "message" => "Problemas al registrar el pedido",
                "errors" => $e->getMessage()
            ], 422);
        }
    }

    public function buscarCliente(Request $request){
        if(isset($request->q)){
            $cliente = Cliente::where('nombre_completo', 'like', "%". $request->q . "%")
                        ->orWhere('ci_nit', 'like', "%". $request->q . "%")
                        ->first();

            return response()->json(["cliente" => $cliente], 200);
        }
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
}
