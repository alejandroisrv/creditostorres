<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use App\Models\typeitem;

use DB;

use DataTables;

class TipoProductoController extends Controller
{
    public function index()
    {
    	$usuarios = User::all();
    	return view('tipoproducto.index')->with('usuario',$usuarios);
    }

    public function busqueda()
    {
    	$tipos = DB::table('item_type')
    				->select('id','name','comments','state');

    	return DataTables::of($tipos)->make(true);
    }

    public function addtipo(request $request)
    {
    	$data = $request->get('data');
    	$fechaactual = date("y-m-d H:i:s");

    	try
    	{
    		$add = new typeitem;
    		$add->name = $data['nombre'];
    		$add->comments = $data['comentarios'];
    		$add->state = $data['estado'];
    		$add->created_at = $fechaactual;
    		$add->save();

    		return 'hecho';

    	}
    	catch(\Excepecion $e)
    	{
    		return $e;
    	}
    }

    public function deltipo(request $request)
    {
    	$id = $request->get('id');

    	try
    	{
    		$eliminar = DB::table('item_type')->where('id',$id)->delete();

    		return 'hecho';
    	}
    	catch(\Excepecion $e)
    	{
    		return $e;
    	}

    }

    public function vertipo(request $request)
    {	
    	$id = $request->get('id');

    	$consulta = DB::table('item_type')->select('id','name','comments','state')->where('id',$id)->get();

    	return $consulta;
    }

    public function updatetipo(request $request)
    {
    	$data = $request->get('data');

    	try
    	{
    		$update = DB::table('item_type')->where('id',$data['id_type_item'])->update(['name'=>$data['nombre_edit'],'comments'=>$data['comentarios_edit'],'state'=>$data['estado_edit']]);

    		return 'hecho';
    	}
    	catch(\Excepecion $e)
    	{
    		return $e;
    	}
    }
}
