<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use DataTables;

use Auth;

use App\Models\claims;

use App\Models\itemsclaims;

use App\Models\item;

use App\Models\movements;

class ClaimsController extends Controller
{
   	public function index()
   	{
         $item = DB::table('items')->select('id','name')->get();
   		return view('devoluciones.index')->with('items',$item);
   	}

   	public function busqueda()
   	{
   		$claims = DB::table('claims')
            		->select(DB::raw("claims.id,claims.invoice,claims.user,claims.comments,claims.created_at, claims.authorizedby, claims.commisionvalue, a.name as nombreusuario, b.name as nombreautorizador"))
            		->leftjoin('users as a','a.id','=','claims.user')
            		->leftjoin('users as b','b.id','=','claims.authorizedby');

         return DataTables::of($claims)->make(true);
   	}

   	public function itemsid($id)
   	{
		    $claims_item = DB::table('items_claims')
            		->select(DB::raw("items_claims.id, items_claims.claims, items_claims.item, items_claims.comments, items_claims.created_at, items.name as nombreitem"))
            		->leftjoin('items','items.id','=','items_claims.item')
            		->where('items_claims.claims',$id);

            return DataTables::of($claims_item)->make(true);
   	}

   	public function addclaims(request $request)
   	{
   		$fechaactual = date("y-m-d H:i:s");
   		try
   		{
   			$consulta = DB::table('invoice')->select('user')->where('id',$request->get('invoice'))->first();

            $autorizado =  Auth::User()->id;

   			$add = new claims;
   			$add->invoice = $request->get('invoice');
   			$add->user = $consulta->user;
   			$add->comments = $request->get('comments');
   			$add->created_at = $fechaactual;
   			$add->state = 'Activo';
   			$add->authorizedby = $autorizado;
   			$add->save();

			$Id_Datos =  claims::select('id')->orderBy('id','desc')->first()->get();
    		$dato_id = '';
            foreach ($Id_Datos as $dato) {
               $dato_id = $dato->id;
            }

            $items = $request->get('items');
            $commentarios = $request->get('commentsitem');

            $calculo = 0;
            $acumulado  = 0;

            for ($i=0; $i < count($items) ; $i++) { 

            	$additems = new itemsclaims;
            	$additems->claims = $dato_id;
            	$additems->item = $items[$i];
            	$additems->comments = $commentarios[$i];
            	$additems->created_at = $fechaactual;
            	$additems->save();

            	$consultacomision = DB::table('items_invoice')->select('total')->where('invoice',$request->get('invoice'))->where('item',$items[$i])->first();

            	$consultaproducto = DB::table('items')->select('commision')->where('id',$items[$i])->first();

            	$calculo = $consultacomision->total * $consultaproducto->commision;

            	$acumulado = $acumulado + $calculo;

               $id_branch = Auth::User()->branch;

               $addmovin = new movements;
               $addmovin->id_item = $items[$i];
               $addmovin->id_invoice = $request->get('invoice');
               $addmovin->id_user = $autorizado;
               $addmovin->id_branch = Auth::User()->id_branch;
               $addmovin->id_warehouse = Auth::User()->id_warehouse;
               $addmovin->quantity = -1;
               $addmovin->created_at = $fechaactual;
               $addmovin->save();

            }

            $actualizar = DB::table('claims')->where('id',$dato_id)->update(['commisionvalue'=>$acumulado]);

            return 'hecho';
            

   		}
   		catch(\Excepcion $e)
   		{
   			return $e;
   		}
   	}

      public function consulta(request $request)
      {
         $producto = $request->get('producto');
         $invoice = $request->get('invoice');

         try
         {
            $consulta = DB::table('items_invoice')
                              ->select('id')
                              ->where('invoice',$invoice)
                              ->where('item',$producto)
                              ->get();

            if(!empty($consulta))
            {
               $consultadevoluciones = DB::table('items_claims')->select('id')->where('item',$producto)->get();
               if(!empty($consultadevoluciones))
               {
                  return 'yaesta';
               }else
               {
                  return 'esta';   
               }
               
            }else
            {
               return 'noesta';
            }
         }
         catch(\Excepcion $e)
         {
            return $e;
         }
      }

      public function consultafactura(request $request)
      {
         $invoice = $request->get('invoice');

         $consulta = DB::table('invoice')
                           ->select(DB::raw("users.name as nombrevendedor"))
                           ->leftjoin('users','users.id','=','invoice.user')
                           ->where('invoice.id',$invoice)
                           ->get();
         $nombre_vendedor = '';

         foreach ($consulta as $value) {
            $nombre_vendedor = $value->nombrevendedor;   
         }

         if(!empty($nombre_vendedor))
         {
            return $nombre_vendedor;  
         }else
         {
            return 'noesta';
         }
      }

      public function delete(request $request)
      {
         $id = $request->get('id');
         try
         {

            $consulta = DB::table('items_claims')->select('item')->where('claims',$id)->get();

            $consulta_claims = DB::table('claims')->select('invoice')->where('id',$id)->first();

            foreach ($consulta as $value) {
               $eliminarmov = DB::table('movements')->where('invoice',$consulta_claims->invoice)->where('item',$value->item)->delete();
            }


            $eliminar = DB::table('items_claims')->where('claims',$id)->delete();
            $eliminarclaims = DB::table('claims')->where('id',$id)->delete();

            return 'hecho';
         }
         catch(\Excepcion $e)
         {
            return $e;
         }
      }

}
