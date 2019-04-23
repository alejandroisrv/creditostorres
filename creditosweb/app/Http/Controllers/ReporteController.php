<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use DataTables;

use Carbon\Carbon;

class ReporteController extends Controller
{
    public function index()
    {
    	$usuarios = DB::table('users')
    					->select(DB::raw("users.id, users.name"))
    					->leftjoin('roles','roles.id','=','users.id_rol')
    					->where('roles.id','=','3')
    					->orWhere('roles.id','=','4')
    					->get();

    	return view('reportes.index')->with('empleados',$usuarios);
    }

    public function reportebusqueda(request $request)
    {
    	$fechai = Carbon::parse($request->get('fechai'))->format('Y-m-d H:i:s');

    	$fechaf = Carbon::parse($request->get('fechaf'))->format('Y-m-d H:i:s');

    	$personal = $request->get('personal');

    	$consulta = DB::table('sale_commision')
    						->select('invoice','total','created_at')
    						->where('seller',$personal)
    						->where('state','=','Nopagado')
    						->whereBetween('created_at',array($fechai,$fechaf))
    						->get();
        
        $deduciones = DB::table('claims')
                        ->select(DB::raw("SUM(commisionvalue) as comision"))
                        ->where('user',$personal)
                        ->whereBetween('created_at',array($fechai,$fechaf))
                        ->groupBy('user')
                        ->get();

        $deduccion = 0;
        foreach ($deduciones as $value) {
            $deduccion = $value->comision;
        }

        $datos = [];

        array_push($datos, $consulta,$deduccion);

    	return $datos;
    }

    public function cancelarpago(request $request)
    {
    	$fechai = Carbon::parse($request->get('fechai'))->format('Y-m-d H:i:s');

    	$fechaf = Carbon::parse($request->get('fechaf'))->format('Y-m-d H:i:s');

    	$personal = $request->get('personal');

    	$consulta = DB::table('sale_commision')
    						->where('seller',$personal)
    						->where('state','=','Nopagado')
    						->whereBetween('created_at',array($fechai,$fechaf))
    						->update(['state'=>'Pagado']);

		return 'hecho';
    }

    public function reportediario()
    {
        $usuarios = DB::table('users')
                        ->select(DB::raw("users.id, users.name"))
                        ->leftjoin('roles','roles.id','=','users.id_rol')
                        ->where('roles.id','=','3')
                        ->orWhere('roles.id','=','4')
                        ->get();

        return view('reportes.reportediario')->with('empleados',$usuarios);
    }

    public function reportebusquedadiario(request $request)
    {
        $fechai = Carbon::parse($request->get('fechai'))->format('Y-m-d');

        $personal = $request->get('personal');

        $consulta = DB::table('sale_commision')
                            ->select(DB::raw("SUM(Total) as totalcomision, created_at"))
                            ->where('seller',$personal)
                            ->where('state','=','Nopagado')
                            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') = '".$fechai."'")
                            ->get();

        return $consulta;
    }
}
