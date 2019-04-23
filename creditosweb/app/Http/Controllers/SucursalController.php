<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Carbon\Carbon;

use Auth;

use DB;

use DataTables;

use App\Models\branch;

class SucursalController extends Controller
{
    public function index()
    {
    	$ciudades = DB::table('cities')->select(DB::raw('id as id_ciudad'),'name')->where('state','like','activo')->get();
    	return view('sucursales.index')->with('ciudades',$ciudades);
    }

    public function busqueda(Request $request)
    {
    	$branches = DB::table('branches')
            ->select(DB::raw("branches.id, branches.name, branches.address, branches.telephone, branches.owner_name, branches.id_ciudad, cities.name as ciudadnombre"))
            ->join('cities','cities.id','=','branches.id_ciudad');

        return DataTables::of($branches)->make(true);
    }

    public function adduser(request $request)
    {	
    	$data = $request->get('data');
        $fechaactual = date("y-m-d H:i:s");

    	try
        {
            $add = new branch;
            $add->id_ciudad = $data['ciudad'];
            $add->name = $data['nombre'];
            $add->address = $data['direccion'];
            $add->telephone = $data['telefono'];
            $add->owner_name = $data['dueno'];
            $add->state = $data['estado'];
            $add->created_at = $fechaactual;
            $add->save();

            return 'hecho';
        }
        catch(\Exception $e)
        {
            return $e;
        }

    }

    public function delsucursal(request $request)
    {
 		$id = $request->get('id');
	        try
	        {
	            $branch = branch::where('id', $id)->delete();

	            return 'hecho';
	        }catch (\Exception $e)
	        {
	            return 'error';
	        }
    }

    public function versucursal(request $request)
    {
    	 	$id = $request->get('id');

	        $branches = DB::table('branches')
	            ->select('id','id_ciudad','name','address','telephone','owner_name','state')
	            ->where('id',$id)
	            ->get();

	        return $branches;
    }

    public function updatesucursal(request $request)
    {
    	$data = $request->get('data');
        $fechaactual = date("y-m-d H:i:s");
        try
        {
            $edit = DB::table('branches')->where('id',$data['id_sucursal'])->update(['id_ciudad' => $data['ciudad_edit'],'name'=>$data['nombre_edit'], 'address'=>$data['direccion_edit'], 'telephone'=>$data['telefono_edit'],'owner_name'=>$data['dueno_edit'],'state'=>$data['estado_edit'],'update_at'=>$fechaactual]);

            return 'hecho';

        }catch (\Exception $e)
        {
            return 'error';
        }	
    }
}
