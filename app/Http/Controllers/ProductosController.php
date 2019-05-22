<?php

namespace App\Http\Controllers;

use App\Productos;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $sucursal=0;
        return $producto=Productos::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getProducto(Reqeuest $request,$id)
    {
        return $producto=Productos::find($id);
    }
    public function create(Request $request)
    {

        $producto=Productos::create($request->all());
        return $producto;
    }

    public function update(Request $request,$id)
    {
        $producto = Productos::find($id);
        $producto->update($request->all());
        return $producto;
    }


    public function destroy($id)
    {
        return Productos::destroy($id);
        
    }
}
