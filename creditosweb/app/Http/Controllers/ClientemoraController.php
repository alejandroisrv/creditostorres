<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use DataTables;

class ClientemoraController extends Controller
{
    public function index()
    {
    	return view('mora.index');
    }

    public function busqueda(request $request)
    {
    	$consulta = DB::table('delinquent_client')
    				->select(DB::raw("delinquent_client.id, delinquent_client.client, delinquent_client.payment_agreement, delinquent_client.state, delinquent_client.comments, delinquent_client.created_at, clients.name as nombrecliente"))
    				->leftjoin('clients','clients.id','=','delinquent_client.client')
    				->where('delinquent_client.state','Activo')
    				->orderBy('delinquent_client.id','DESC');

		return DataTables::of($consulta)->make(true);
    }

    public function cambiarestado(request $request)
    {
    	$id = $request->get('id');
    	try 
    	{
    		$actualiza = DB::table('delinquent_client')
    						->where('id','=',$id)
    						->update(['state'=>'Inactivo']);

    		return 'hecho';
    	} 
    	catch (Exception $e) {
    		return $e;
    	}
    }
}
