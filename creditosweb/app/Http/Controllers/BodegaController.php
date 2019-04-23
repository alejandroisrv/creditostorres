<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use DataTables;

use App\User;

use App\Models\branch;

use App\Models\bodega;

class BodegaController extends Controller
{
    public function index()
    {
    	$usuarios = User::all();
    	$sucursales = branch::all();
    	return view('bodega.index')->with('usuario',$usuarios)->with('sucursales',$sucursales);
    }

    public function busqueda()
    {
    	$warehouse = DB::table('warehouse')
            ->select(DB::raw("warehouse.id, warehouse.branch, warehouse.name, warehouse.address, warehouse.state, warehouse.telephone, warehouse.incharge, branches.name as nombresucursal, users.name as nombreencargado"))
            ->leftjoin('branches','branches.id','=','warehouse.branch')
            ->leftjoin('users','users.id','=','warehouse.incharge');

        return DataTables::of($warehouse)->make(true);
    }

    public function addbodega(request $request)
    {
    	$data = $request->get('data');
    	$fechaactual = date("y-m-d H:i:s");

    	try
    	{
    		$add = new bodega;
    		$add->branch = $data['sucursal'];
    		$add->name = $data['nombre'];
    		$add->address = $data['direccion'];
    		$add->state =  $data['estado'];
    		$add->telephone = $data['telefono'];
    		$add->created_at = $fechaactual;
    		$add->incharge = $data['encargado'];
    		$add->save();

    		return 'hecho';
    	}
    	catch(\Exception $e)
    	{
    		return $e;
    	}
    }

    public function delbodega(request $request)
    {
    	$id = $request->get('id');

    	try
    	{
    		$bodega = bodega::where('id', $id)->delete();

    		return 'hecho';
    	}
    	catch(\Exception $e)
    	{
    		return $e;
    	}

    }

    public function verbodega(request $request)
    {
    	$id = $request->get('id');

    	$consulta = DB::table('warehouse')
    				->select('id','branch','name','address','state','telephone','incharge')
    				->where('id',$id)
    				->get();

    	return $consulta;
    }

    public function updatebodega(request $request)
    {
    	$data = $request->get('data');
    	$fechaactual = date("y-m-d H:i:s");

    	try
    	{
    		$update = DB::table('warehouse')->where('id',$data['id_warehouse'])->update(['branch'=>$data['sucursal_edit'],'name'=>$data['nombre_edit'],'address'=>$data['direccion_edit'],'state'=>$data['estado_edit'],'telephone'=>$data['telefono_edit'],'update_at'=>$fechaactual,'incharge'=>$data['encargado_edit']]);

    		return 'hecho';
    	}
    	catch(\Exception $e)
    	{
    		return $e;
    	}
    }

    public function bodegas_por_sucursal($id){
        $consulta = DB::table('warehouse')
                    ->select('id','name')
                    ->where('branch',$id)
                    ->get();

        return $consulta;   
    }
}
