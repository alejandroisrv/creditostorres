<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use DataTables;

use App\Models\ciudad;

class CiudadController extends Controller
{
   public function index()
   {
   		return view('ciudad.index');
   }

   public function busqueda()
   {
   		$cities = DB::table('cities');

        return DataTables::of($cities)->make(true);
   }

   public function addciudad(request $request)
   {
   		$data = $request->get('data');

    	try
        {
            $add = new ciudad;
            $add->name = $data['ciudad'];
            $add->state = $data['estado'];
            $add->save();

            return 'hecho';
        }
        catch(\Exception $e)
        {
            return 'error';
        }
   }

   public function delciudad(request $request)
   {
		$id = $request->get('id');
	        try
	        {
	            $ciudades = ciudad::where('id', $id)->delete();

	            return 'hecho';
	        }catch (\Exception $e)
	        {
	            return 'error';
	        }
   }

   public function verciudad(request $request)
   {
   		$id = $request->get('id');

        $cities = DB::table('cities')
            ->where('id',$id)
            ->get();

        return $cities;
   } 

   public function updateciudad(request $request)
   {
   		$data = $request->get('data');

   		try
   		{

   			$citiesupdate = DB::table('cities')->where('id',$data['id_cities'])->update(['name'=>$data['ciudad_edit'],'state'=>$data['estado_edit']]);

   			return 'hecho';


   		}catch(\Exception $e)
   		{
   			return $e;
   		}

   }
}
