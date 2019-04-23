<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\cliente;
use DB;
use DataTables;

class ClienteController extends Controller
{
    public function index()
    {
        $municipios = DB::table('cities')->get();

    	return view('clientes.index')->with('municipios',$municipios);
    }

    public function busqueda()
    {
    	$clients = DB::table('clients')->join('cities', 'clients.id_municipio', 'cities.id')
            ->select('clients.id',DB::raw('cities.name as municipio'),'clients.name','lastname','telephone','address','clients.state','email','created_at','update_at','comments','discount','good_customer');

        return DataTables::of($clients)->make(true);
    }

    public function buscar($id){
        if( $id <= 0 ){
$clients = DB::table('clients')->join('cities', 'clients.id_municipio', 'cities.id')
            ->select('clients.id',DB::raw('cities.name as municipio'),'clients.name','lastname','telephone','address','clients.state','email','created_at','update_at','comments','discount','good_customer');            
        } else {
$clients = DB::table('clients')->join('cities', 'clients.id_municipio', 'cities.id')
            ->select('clients.id',DB::raw('cities.name as municipio'),'clients.name','lastname','telephone','address','clients.state','email','created_at','update_at','comments','discount','good_customer')->where('cities.id', $id);
        }
                return DataTables::of($clients)->make(true);
    }

    public function addcliente(request $request)
    {

    	$data = $request->get('data');
        $fechaactual = date("y-m-d H:i:s");

    	try
        {

            $add = new cliente;

            $municipio = $data['municipio'];
            
            if(substr($municipio, -1)==" "){
                $municipio = substr($municipio, 0, -1);
            }

            if(DB::table('cities')->where('name', 'like', $municipio)->exists()){
                $add->id_municipio = DB::table('cities')->select('id')->where('name', 'like', $municipio)->first()->id;
            } else {
                $add->id_municipio = DB::table('cities')->insertGetId(
                    ['name' => $municipio, 'state' => 'Activo']
                );
            }

            $add->name = $data['nombre'];
            $add->lastname = $data['apellido'];
            $add->telephone = $data['telefono'];
            $add->address = $data['direccion'];
            $add->email = $data['email'];
            $add->discount = $data['descuento'];
            $add->comments = $data['comentarios'];
            $add->good_customer = $data['good_customer'];
            $add->state = $data['estado'];
            $add->created_at = $fechaactual;
            $add->cedula = $data['nit_cedula'];
            $add->save();

            return 'hecho';
        }
        catch(\Exception $e)
        {
            return $e;
        }
    }

    public function delcliente(request $request)
    {
    		$id = $request->get('id');
	        try
	        {
	            $branch = cliente::where('id', $id)->delete();

	            return 'hecho';
	        }catch (\Exception $e)
	        {
	            return 'error';
	        }
    }

    public function vercliente(request $request)
    {
    	$id = $request->get('id');

	        $clients = DB::table('clients')->join('cities', 'clients.id_municipio', 'cities.id')
	            ->select('clients.id',DB::raw('cities.name as municipio'),'clients.name','lastname','telephone','address','clients.state','email','comments','discount','good_customer','cedula')
	            ->where('clients.id',$id)
	            ->get();

	        return $clients;
    }

    public function updatecliente(request $request)
    {
    	$data = $request->get('data');
    	$fechaactual = date("y-m-d H:i:s");
    	try {
            
            $municipio = $data['municipio_edit'];
            
            if(substr($municipio, -1)==" "){
                $municipio = substr($municipio, 0, -1);
            }

            if(DB::table('cities')->where('name', 'like', $municipio)->exists()){
                $id_municipio = DB::table('cities')->select('id')->where('name', 'like', $municipio)->first()->id;
            } else {
                $id_municipio = DB::table('cities')->insertGetId(
                    ['name' => $municipio, 'state' => 'Activo']
                );
            }

    		$edit_clients = DB::table('clients')->where('id',$data['id_clients'])->update([
                'id_municipio'=>$id_municipio,
                'name'=>$data['nombre_edit'],
                'lastname'=>$data['apellido_edit'],
                'telephone'=>$data['telefono_edit'],
                'address'=>$data['direccion_edit'],
                'state'=>$data['estado_edit'],
                'email'=>$data['email_edit'],
                'comments'=>$data['comentarios_edit'],
                'discount'=> $data['descuento_edit'],
                'update_at'=>$fechaactual,
                'good_customer'=>$data['good_customer_edit'],
                'cedula'=>$data['nit_cedula_editar']]);
    	}
    	catch(\Exception $e)
    	{
    		return $e;
    	}

    }

}
