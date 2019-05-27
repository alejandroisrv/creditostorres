<?php

namespace App\Http\Controllers;

use App\Sucursal;
use Illuminate\Http\Request;

class SucursalesController extends Controller
{

    public function index()
    {
        $sucursales=Sucursal::with('encargado','bodegas')->get();
        return $sucursales;
    }

    
    public function create(Request $request)
    {
        $sucursal = new Surcursal($request->all());
        $sucursal->encargado_id=1;
        $sucursal->save();
        return $sucursal;
    }

  
    public function update(Request $request, $id)
    {
        $sucursal=Sucursal::find($id);
        $sucursal->update($request->all());
        return $sucursal;
    }

    public function destroy(Request $request,$id)
    {
        return Sucursal::destroy($id);
    }
}
