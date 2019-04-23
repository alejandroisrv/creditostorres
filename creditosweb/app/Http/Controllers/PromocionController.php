<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\item;

use App\Models\promocion;

use DB;

use DataTables;

use Auth;

class PromocionController extends Controller
{
    public function index()
    {	
    	$items = item::all();
    	return view('promociones.index')->with('items',$items);
    }

    public function busqueda()
    {
    	$consulta = DB::table('promotion')
    					->select(DB::raw("promotion.id, promotion.id_item, promotion.id_user, FLOOR(promotion.porcentage * 100) as porcentage, promotion.state, promotion.promotionvalue, promotion.created_at, promotion.update_at, items.name as itemname, users.name as username, promotion.dateexpiration"))
    					->leftjoin('items','items.id','=','promotion.id_item')
    					->leftjoin('users','users.id','=','promotion.id_user')
    					->orderBy('id','ASC');

    	return DataTables::of($consulta)->make(true);

    }

    public function addpromo(request $request)
    {
    	$data = $request->get('data');
    	$id_user = Auth::User()->id;
    	$porcentajem = $data['porcentaje'] / 100;
		$fechaactual = date("y-m-d H:i:s");

		$consulta = DB::table('items')
					->select('price')
					->where('id',$data['producto'])
					->get();
		$price = 0;					
		foreach ($consulta as $value) {
			$price = $value->price;
		}
		$total = $price * $porcentajem;

    	try
    	{
    		$add = new promocion;
    		$add->id_item = $data['producto'];
    		$add->id_user = $id_user;
    		$add->porcentage  = floatval($porcentajem);
    		$add->promotionvalue = $total;
    		$add->state = $data['estado'];
            $add->dateexpiration = $data['fechaexp'];
    		$add->created_at = $fechaactual;
    		$add->save();

    		return 'hecho';
    	}
    	catch(\Excepcion $e)
    	{
    		return $e;
    	}
    }

    public function delpromo(request $request)
    {
    	$id = $request->get('id');

    	try
    	{
    		$eliminar = DB::table('promotion')->where('id',$id)->delete();

    		return 'hecho';
    	}
    	catch(\Excepcion $e)
    	{
    		return $e;
    	}
    }

    public function verpromo(request $request)
    {
    	$id = $request->get('id');

    	$consulta = DB::table('promotion')
    				->select(DB::raw("id,id_item,FLOOR(promotion.porcentage * 100) as porcentage,state,dateexpiration"))
    				->where('id',$id)
    				->get();

    	return $consulta;
    }

    public function updatepromo(request $request)
    {
    	$data = $request->get('data');
    	$fechaactual = date("y-m-d H:i:s");

    	$porcentajem = $data['porcentaje_edit'] / 100;

		$consulta = DB::table('items')
					->select('price')
					->where('id',$data['producto_edit'])
					->get();
		$price = 0;					
		foreach ($consulta as $value) {
			$price = $value->price;
		}
		$total = $price * $porcentajem;


    	try
    	{
    		$update = DB::table('promotion')->where('id',$data['id_promo'])->update(['id_item'=>$data['producto_edit'],'porcentage'=>$porcentajem,'state'=>$data['estado_edit'],'promotionvalue'=>$total,'dateexpiration'=>$data['fechaexp_edit']]);

    		return 'hecho';
    	}
    	catch(\Excepcion $e)
    	{
    		return $e;
    	}
    }

}
