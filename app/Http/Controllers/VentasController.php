<?php

namespace App\Http\Controllers;

use App\Venta;
use App\TipoVenta;
use App\AcuerdoPago;
use App\ProductosVenta;
use App\ComisionVenta;
use App\Productos;
use Illuminate\Http\Request;

class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ventas= Venta::with('tipos_ventas','vendedor','acuerdo_pago','persona','productos_venta')->whereHas('vendedor', function($q){
            $q->where('sucursal_id',1);
        })->get();
        return $ventas;
    }

    public function create(Request $request)
    {

        $data=$request->all();
        $vendedor=1;
        $total=0;
        $venta= new Venta(['cliente_id'=> $data['cliente'], 'vendedor_id'=>$vendedor,'tipo_venta'=>$data['tipo'],'total'=> $total]);
        $acuerdoPago=new AcuerdoPago(['cuotas'=> $data['cuotas'], 'periodo_pago'=>$data['periodo']]);
        $venta->save();
        $acuerdoPago->venta_id=$venta->id;
        $acuerdoPago->save();
        for($i=0; $i<count($data['productosVendidos']);$i++){
            $data['productosVendidos'][$i]['venta_id']=$venta->id;
            $producto=Productos::findOrFail($data['productosVendidos'][$i]['id']);
            $comision=$producto->comision*$data['productosVendidos'][$i]['cantidad'];
            ComisionVenta::create(['venta_id'=> $venta->id, 'vendedor_id'=> $vendedor, 'monto'=>$comision, 'estado'=> 0 ]);
            ProductosVenta::create($data['productosVendidos'][$i]);
        }

        return $acuerdoPago;
       
    }

    public function getTipos(Request $request){


        $tipos_ventas=TipoVenta::all();
        return $tipos_ventas;
    }
}
