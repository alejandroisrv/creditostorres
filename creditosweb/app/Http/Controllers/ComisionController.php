<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use DataTables;

class ComisionController extends Controller
{
    public function index()
    {
    	return view('nominas.index');
    }

    public function busqueda(request $request)
    {
    	$comisiones = DB::table('sale_commision')
			            ->select(DB::raw("sale_commision.id, sale_commision.seller, sale_commision.invoice, sale_commision.total, sale_commision.created_at, sale_commision.state, users.name as nombreempleado, roles.name as nombrerol"))
			            ->leftjoin('users','users.id','=','sale_commision.seller')
			            ->leftjoin('roles','roles.id','=','users.id_rol')
			            ->where('sale_commision.state','=','Nopagado')
			            ->orderBy('sale_commision.id','ASC');


        return DataTables::of($comisiones)->make(true);
    }
    public function indexcomisionespagadas()
    {
    	return view('nominas.pagados');
    }

    public function actualizar(request $request)
    {
        $id = $request->get('id');

        try
        {
            $actua = DB::table('sale_commision')->where('id',$id)->update(['state'=>'Pagado']); 

            return 'hecho';
        }
        catch(\Exception $e)
        {
            return $e;
        }
    }

    public function busquedacomisionespagadas(request $request)
    {
    	$comisiones = DB::table('sale_commision')
			            ->select(DB::raw("sale_commision.id, sale_commision.seller, sale_commision.invoice, sale_commision.total, sale_commision.created_at, sale_commision.state, users.name as nombreempleado, roles.name as nombrerol"))
			            ->leftjoin('users','users.id','=','sale_commision.seller')
			            ->leftjoin('roles','roles.id','=','users.id_rol')
			            ->where('sale_commision.state','=','Pagado')
			            ->orderBy('sale_commision.id','ASC');


        return DataTables::of($comisiones)->make(true);
    }
}
