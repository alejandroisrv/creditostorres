<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use DataTables;

use App\Models\routes;

use App\Models\routesdestination;

use App\Models\routeshedule;

use Auth;

class RutaController extends Controller
{
    public function index()
    {
    	$item = DB::table('items')->select('id','name')->get();
    	$users = DB::table('users')->select('id','name')->get();
    	$clients = DB::table('clients')->select('id','name')->get();
    	return view('rutas.index')->with('items',$item)->with('users',$users)->with('clients',$clients);
    }

    public function busqueda()
    {
    	$rutas = DB::table('routes')
            		->select(DB::raw("routes.id, routes.collector, routes.assignedby, routes.state, routes.comments, routes.created_at, routes.updated_at, a.name as nombreempleado, b.name as nombreasignado"))
            		->leftjoin('users as a','a.id','=','routes.collector')
            		->leftjoin('users as b','b.id','=','routes.assignedby');

         return DataTables::of($rutas)->make(true);
    }

    public function busquedadireccion(request $request)
    {
        $cliente = $request->get('cliente');

        $consulta = DB::table('clients')
                            ->select('address')
                            ->where('id',$cliente)
                            ->first();
        $direccion = $consulta->address;

        return $direccion;

    }

    public function busquedadestina($id)
    {
    	$rutas_destination = DB::table('routes_destination')
			            		->select(DB::raw("routes_destination.id, routes_destination.client, routes_destination.address, routes_destination.route, routes_destination.comments, routes_destination.state, clients.name as nombrecliente"))
			            		->leftjoin('clients','clients.id','=','routes_destination.client')
			            		->where('routes_destination.route',$id);

         return DataTables::of($rutas_destination)->make(true);
    }

    public function addruta(request $request)
    {
    	$data = $request->get('data');
    	$clientes = $request->get('clientes');
    	$address = $request->get('address');
    	$coordinates = $request->get('coordinates');
    	$comments = $request->get('comments');
    	$numLaboral = $data['numLaboral'];
    	$id_usuario = Auth::User()->id;

    	try
    	{
    		$add = new routes;
    		$add->collector = $data['empleado'];
    		$add->assignedby = $id_usuario;
    		$add->state = 'Activo';
    		$add->comments = $data['comentarios'];
    		$add->created_at = $data['fecha'];
    		$add->save();

    		$Id_Datos =  routes::select('id')->orderBy('id','desc')->first()->get();
    		$dato_id = '';
            foreach ($Id_Datos as $dato) {
               $dato_id = $dato->id;
            }

        	for ($i = 0; $i < $numLaboral; $i++)
        	{
        		$addroute = new routesdestination;
        		$addroute->client = $clientes[$i];
        		$addroute->coordinate = $coordinates[$i];
        		$addroute->address = $address[$i];
        		$addroute->route = $dato_id;
        		$addroute->comments = $comments[$i];
        		$addroute->state = 'Activo';
        		$addroute->save();
        	}

        	$dia = $data['dia'];

        	if($dia == '1')
        	{
        		$addschedule = new routeshedule;
        		$addschedule->route = $dato_id;
        		$addschedule->monday = '1';
        		$addschedule->tuesday = '0';
        		$addschedule->wednesday = '0';
        		$addschedule->thursday = '0';
        		$addschedule->friday = '0';
        		$addschedule->saturday = '0';
        		$addschedule->sunday = '0';
        		$addschedule->save();

        	}elseif ($dia == '2')
        	{
        		$addschedule = new routeshedule;
        		$addschedule->route = $dato_id;
        		$addschedule->monday = '0';
        		$addschedule->tuesday = '1';
        		$addschedule->wednesday = '0';
        		$addschedule->thursday = '0';
        		$addschedule->friday = '0';
        		$addschedule->saturday = '0';
        		$addschedule->sunday = '0';
        		$addschedule->save();

        	}elseif ($dia == '3')
        	{
        		$addschedule = new routeshedule;
        		$addschedule->route = $dato_id;
        		$addschedule->monday = '0';
        		$addschedule->tuesday = '0';
        		$addschedule->wednesday = '1';
        		$addschedule->thursday = '0';
        		$addschedule->friday = '0';
        		$addschedule->saturday = '0';
        		$addschedule->sunday = '0';
        		$addschedule->save();

        	}elseif ($dia == '4')
        	{
        		$addschedule = new routeshedule;
        		$addschedule->route = $dato_id;
        		$addschedule->monday = '0';
        		$addschedule->tuesday = '0';
        		$addschedule->wednesday = '0';
        		$addschedule->thursday = '1';
        		$addschedule->friday = '0';
        		$addschedule->saturday = '0';
        		$addschedule->sunday = '0';
        		$addschedule->save();

        	}elseif ($dia == '5')
        	{
        		$addschedule = new routeshedule;
        		$addschedule->route = $dato_id;
        		$addschedule->monday = '0';
        		$addschedule->tuesday = '0';
        		$addschedule->wednesday = '0';
        		$addschedule->thursday = '0';
        		$addschedule->friday = '1';
        		$addschedule->saturday = '0';
        		$addschedule->sunday = '0';
        		$addschedule->save();

        	}elseif ($dia == '6')
        	{
        		$addschedule = new routeshedule;
        		$addschedule->route = $dato_id;
        		$addschedule->monday = '0';
        		$addschedule->tuesday = '0';
        		$addschedule->wednesday = '0';
        		$addschedule->thursday = '0';
        		$addschedule->friday = '0';
        		$addschedule->saturday = '1';
        		$addschedule->sunday = '0';
        		$addschedule->save();

        	}else
        	{
        		$addschedule = new routeshedule;
        		$addschedule->route = $dato_id;
        		$addschedule->monday = '0';
        		$addschedule->tuesday = '0';
        		$addschedule->wednesday = '0';
        		$addschedule->thursday = '0';
        		$addschedule->friday = '0';
        		$addschedule->saturday = '0';
        		$addschedule->sunday = '1';
        		$addschedule->save();
        	}

        	
        	return 'hecho';

    	}
    	catch(\Excepcion $e)
    	{
    		return $e;
    	}

    }

    public function delruta(request $request)
    {
    	$id = $request->get('id');

    	try
    	{
    		DB::table('routes_shedule')->where('route',$id)->delete();
    		DB::table('routes_destination')->where('route',$id)->delete();
    		DB::table('routes')->where('id',$id)->delete();

    		return 'hecho';
    	}
    	catch(\Excepcion $e)
    	{
    		return $e;
    	}
    }

    public function indexreporte()
    {
    	$users = DB::table('users')->select('id','name')->get();
    	return view('rutas.reporte')->with('empleados',$users);
    }

    public function reportedia(request $request)
    {
    	$personal = $request->get('personal');
    	$dia = $request->get('dia');

    	try
    	{
    		if($dia == '1')
        	{
        		$consulta = DB::table('routes')
        					->select(DB::raw("routes.id as ruta, routes.created_at as fecha, clients.name as cliente, routes_destination.checkin as chekeado, routes_destination.checkin_time as chekeado_fecha"))
        					->leftjoin('routes_destination', 'routes_destination.route', '=','routes.id')
        					->leftjoin('clients', 'clients.id', '=', 'routes_destination.client')
        					->leftjoin('routes_shedule', 'routes_shedule.route','=', 'routes.id')
        					->where('routes.collector',$personal)
        					->where('routes_shedule.monday','=','1')
        					->get();

        	}elseif ($dia == '2')
        	{
        		$consulta = DB::table('routes')
        					->select(DB::raw("routes.id as ruta, routes.created_at as fecha, clients.name as cliente, routes_destination.checkin as chekeado, routes_destination.checkin_time as chekeado_fecha"))
        					->leftjoin('routes_destination', 'routes_destination.route', '=','routes.id')
        					->leftjoin('clients', 'clients.id', '=', 'routes_destination.client')
        					->leftjoin('routes_shedule', 'routes_shedule.route','=', 'routes.id')
        					->where('routes.collector',$personal)
        					->where('routes_shedule.tuesday','=','1')
        					->get();

        	}elseif ($dia == '3')
        	{
        			$consulta = DB::table('routes')
        					->select(DB::raw("routes.id as ruta, routes.created_at as fecha, clients.name as cliente, routes_destination.checkin as chekeado, routes_destination.checkin_time as chekeado_fecha"))
        					->leftjoin('routes_destination', 'routes_destination.route', '=','routes.id')
        					->leftjoin('clients', 'clients.id', '=', 'routes_destination.client')
        					->leftjoin('routes_shedule', 'routes_shedule.route','=', 'routes.id')
        					->where('routes.collector',$personal)
        					->where('routes_shedule.wednesday','=','1')
        					->get();

        	}elseif ($dia == '4')
        	{
        			$consulta = DB::table('routes')
        					->select(DB::raw("routes.id as ruta, routes.created_at as fecha, clients.name as cliente, routes_destination.checkin as chekeado, routes_destination.checkin_time as chekeado_fecha"))
        					->leftjoin('routes_destination', 'routes_destination.route', '=','routes.id')
        					->leftjoin('clients', 'clients.id', '=', 'routes_destination.client')
        					->leftjoin('routes_shedule', 'routes_shedule.route','=', 'routes.id')
        					->where('routes.collector',$personal)
        					->where('routes_shedule.thursday','=','1')
        					->get();

        	}elseif ($dia == '5')
        	{
        		$consulta = DB::table('routes')
        					->select(DB::raw("routes.id as ruta, routes.created_at as fecha, clients.name as cliente, routes_destination.checkin as chekeado, routes_destination.checkin_time as chekeado_fecha"))
        					->leftjoin('routes_destination', 'routes_destination.route', '=','routes.id')
        					->leftjoin('clients', 'clients.id', '=', 'routes_destination.client')
        					->leftjoin('routes_shedule', 'routes_shedule.route','=', 'routes.id')
        					->where('routes.collector',$personal)
        					->where('routes_shedule.friday','=','1')
        					->get();

        	}elseif ($dia == '6')
        	{
        		$consulta = DB::table('routes')
        					->select(DB::raw("routes.id as ruta, routes.created_at as fecha, clients.name as cliente, routes_destination.checkin as chekeado, routes_destination.checkin_time as chekeado_fecha"))
        					->leftjoin('routes_destination', 'routes_destination.route', '=','routes.id')
        					->leftjoin('clients', 'clients.id', '=', 'routes_destination.client')
        					->leftjoin('routes_shedule', 'routes_shedule.route','=', 'routes.id')
        					->where('routes.collector',$personal)
        					->where('routes_shedule.saturday','=','1')
        					->get();

        	}else
        	{
        		$consulta = DB::table('routes')
        					->select(DB::raw("routes.id as ruta, routes.created_at as fecha, clients.name as cliente, routes_destination.checkin as chekeado, routes_destination.checkin_time as chekeado_fecha"))
        					->leftjoin('routes_destination', 'routes_destination.route', '=','routes.id')
        					->leftjoin('clients', 'clients.id', '=', 'routes_destination.client')
        					->leftjoin('routes_shedule', 'routes_shedule.route','=', 'routes.id')
        					->where('routes.collector',$personal)
        					->where('routes_shedule.sunday','=','1')
        					->get();
        	}   		

    		return $consulta;
    	}
    	catch(\Excepcion $e)
    	{
    		return $e;
    	}
    }
}


