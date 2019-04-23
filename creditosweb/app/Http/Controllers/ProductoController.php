<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\movements;
use App\Models\typeitem;
use App\Http\Requests;
use App\Models\item;
use App\Models\items_seller;
use App\User;
use DataTables;
use Auth;
use DB;

class ProductoController extends Controller
{
    // Listo
    public function index()
    {
        $sucursal_o_bodega = array();
    
        if (Auth::user()->id_warehouse == 0) {
            $sucursal_o_bodega['tipo'] = "sucursal";
            $sucursal_o_bodega['valor'] = DB::table('branches')->select('name')->where('id',Auth::user()->id_branch)->first()->name;
            $bodegas = DB::table('warehouse')
            ->select('id','name')
            ->where('branch',Auth::user()->id_branch)
            ->get();
        } else {
            $bodegas=null;
            $sucursal_o_bodega['tipo'] = "bodega";
            $sucursal_o_bodega['valor'] = DB::table('warehouse')->select('name')->where('id',Auth::user()->id_warehouse)->first()->name;
        }
        
    	$usuarios = User::all();
        $typeitem = typeitem::all();
        
        $productos;

        if (Auth::user()->id_warehouse < 1) {
            $productos = DB::table('items')
                ->select('items.id', 'name', 'descripcion', DB::raw("sum(quantity) as quantity"))
                ->join('movements', 'movements.id_item', '=', 'items.id')
                ->where('movements.id_branch', '=', Auth::user()->id_branch)
                ->groupBy('items.id', 'name', 'descripcion')
                ->get();
        } else {
            $idBodega=Auth::user()->id_warehouse;
            $productos = DB::table('items')
                ->select('items.id', 'name', 'descripcion', DB::raw("sum(quantity) as quantity"))
                ->join('movements', 'movements.id_item', '=', 'items.id')
                ->where('movements.id_branch', '=', Auth::user()->id_branch)
                ->whereIn('movements.id_warehouse', array($idBodega,0))
                ->groupBy('items.id', 'name', 'descripcion')
                ->get();
        }

        return view('producto.index')->with('usuario',$usuarios)->with('tipos',$typeitem)->with('productos',$productos)->with('sucursal_o_bodega',$sucursal_o_bodega)->with('bodegas',$bodegas);
    }

    // Listo
    public function busquedamejorada(request $request)
    {
        $items;
        if (Auth::user()->id_warehouse < 1) {
            $idbodega=$request->get('idbodega');
            if($idbodega>0){
                $items = DB::table('items')
            ->select(DB::raw("distinct(items.id), items.adjunto, item_type.name as tipo, items.name, items.descripcion, (select sum(movements.quantity) from movements where items.id = movements.id_item AND movements.id_warehouse = $idbodega ) as quantity, items.price, items.reseller_price"))
            ->join('users','users.id','=','items.created_by')
            ->join('item_type','item_type.id','=','items.type')
            ->join('movements', 'movements.id_item', '=', 'items.id')
            ->where('movements.id_branch', '=', Auth::user()->id_branch)
            ->where('movements.id_warehouse', '=', $idbodega);
            
            }else{
                $items = DB::table('items')
            ->select(DB::raw("distinct(items.id), items.adjunto, item_type.name as tipo, items.name, items.descripcion, (select sum(movements.quantity) from movements where items.id = movements.id_item ) as quantity, items.price, items.reseller_price"))
            ->join('users','users.id','=','items.created_by')
            ->join('item_type','item_type.id','=','items.type')
            ->join('movements', 'movements.id_item', '=', 'items.id')
            ->where('movements.id_branch', '=', Auth::user()->id_branch);
            
            }
            
            
        } else {
            $idBodega=Auth::user()->id_warehouse;
            $items = DB::table('items')
            ->select(DB::raw("distinct(items.id), items.adjunto, item_type.name as tipo, items.name, items.descripcion, (select sum(movements.quantity) from movements where items.id = movements.id_item AND movements.id_warehouse = $idBodega ) as quantity, items.price, items.reseller_price"))
            ->join('users','users.id','=','items.created_by')
            ->join('item_type','item_type.id','=','items.type')
            ->join('movements', 'movements.id_item', '=', 'items.id')
            ->where('movements.id_branch', '=', Auth::user()->id_branch)
            ->where('movements.id_warehouse', '=',Auth::user()->id_warehouse);
            
        }
        return DataTables::of($items)->make(true);
    }

    // Listo!
    public function addproducto(request $request)
    {
        $data = $request->get('data');
        $id_usuario = Auth::User()->id;
        $fechaactual = date("y-m-d H:i:s");

        $Adjuntar_foto = $request->file('adjuntar_foto');
        if($Adjuntar_foto==''){
            $url = 'NULL';
            $nombre = 'NULL';
        }
        else
        {
            $files = glob('Documentos/*'); // obtiene todos los archivos
            foreach($files as $file){
                if(is_file($file)) // si se trata de un archivo
                    unlink($file); // lo elimina
            }

            $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
            $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';

            $nombre_original=$Adjuntar_foto->getClientOriginalName();

            $name = utf8_decode($nombre_original);
            $name2 = strtr($name, utf8_decode($originales), $modificadas);
            $nombre = utf8_encode($name2);

            $Adjuntar_foto->move('Documentos', $nombre);
            $url =  base64_encode(file_get_contents('Documentos/'.$nombre));
        }

        try
        {
            $add = new item;
            $add->created_by = $id_usuario;
            $add->type = $request->get('tipo');
            $add->name = $request->get('nombre');
            $add->descripcion = $request->get('descripcion');
            $add->price = $request->get('precio');
            $add->commision = $request->get('commision');
            $add->reseller_price = $request->get('revendedor');
            $add->comments = $request->get('comentarios');
            $add->created_at = $fechaactual;
            $add->nombreimage = $nombre;
            $add->adjunto = $url;
            $add->save();

            $id_item = $add->id;

            $id_branch = Auth::User()->id_branch;
            $id_warehouse = Auth::User()->id_warehouse;
            $idbodega=$request->get('idbodega');
            
            if (Auth::user()->id_warehouse < 1) {
                if($idbodega==0){
                    $bodegas = DB::table('warehouse')
                          ->select('id')
                          ->where('branch',$id_branch)
                          ->get();
                    foreach ($bodegas as $bodega) {
                        $addmovin = new movements;
                        $addmovin->id_item = $id_item;
                        $addmovin->id_invoice = 0;
                        $addmovin->id_user = $id_usuario;
                        $addmovin->id_branch = $id_branch;
                        $addmovin->id_warehouse = $bodega->id;
                        $addmovin->quantity = $request->get('cantidad');
                        $addmovin->created_at = $fechaactual;
                        $addmovin->save();
                    }
                    
                }else{
                    
                    $addmovin = new movements;
                    $addmovin->id_item = $id_item;
                    $addmovin->id_invoice = 0;
                    $addmovin->id_user = $id_usuario;
                    $addmovin->id_branch = $id_branch;
                    $addmovin->id_warehouse = $idbodega;
                    $addmovin->quantity = $request->get('cantidad');
                    $addmovin->created_at = $fechaactual;
                    $addmovin->save();
                    
                }

            }else {
                    $addmovin = new movements;
                    $addmovin->id_item = $id_item;
                    $addmovin->id_invoice = 0;
                    $addmovin->id_user = $id_usuario;
                    $addmovin->id_branch = $id_branch;
                    $addmovin->id_warehouse = $id_warehouse;
                    $addmovin->quantity = $request->get('cantidad');
                    $addmovin->created_at = $fechaactual;
                    $addmovin->save();
              
            }
            return redirect()->action(
                    'ProductoController@index', ['message' => 1]
            );
        }
        catch(\Excepcion $e)
        {
            return redirect()->action(
                    'ProductoController@index', ['message' => 2]
            );
        }
    }

    // Listo
    public function delproducto(request $request)
    {
        $id = $request->get('id');
        $idbodega =$request->get('idbodega');

        try
        {
            if(Auth::user()->id_warehouse<1){
                if($idbodega==0){
                    $eliminarItem = DB::table('movements')
                    ->where(['id_item' => $id,'id_warehouse' => $idbodega])
                    ->delete();
                    $eliminarMov = DB::table('items')->where('id',$id)->delete();
                }else{
                     $eliminarItem = DB::table('movements')
                    ->where(['id_item' => $id,'id_warehouse' => $idbodega])
                    ->delete();
                }
            
            }else{
                     $eliminarItem = DB::table('movements')
                    ->where(['id_item' => $id,'id_warehouse' => $idbodega])
                    ->delete();
            }

            return 'hecho';
        }
        catch(\Excepcion $e)
        {
            return $e;
        }
    }

    // Listo
    public function verproducto(request $request)
    {
        $id = $request->get('id');
        $idbodega=$request->get('idbodega');
        $idbranch=Auth::user()->id_branch;
        if(Auth::user()->id_warehouse<1){
            if($idbodega>0){
                $ultimo_movimiento_agregado = DB::table('movements')->select('id')->where('id_item',$id)->where('id_warehouse', $idbodega)->orderBy('id','desc')->first()->id;
                $items = DB::table('items')
                ->select('id', 'created_by', 'type', 'name', 'descripcion', DB::raw("(select quantity from movements where id = $ultimo_movimiento_agregado) as quantity"), 'price', 'commision', 'reseller_price', 'comments')
                ->where('id',$id)
                ->get();
            }else{
            $items = DB::table('items')
            ->select('id', 'created_by', 'type', 'name', 'descripcion', DB::raw("(select sum(quantity) from movements where id_item = $id AND id_branch = $idbranch ) as quantity"), 'price', 'commision', 'reseller_price', 'comments')
            ->where('id',$id)
            ->get();     
            }
        
        }else{
            $ultimo_movimiento_agregado = DB::table('movements')->select('id')->where('id_item',$id)->where('id_warehouse', Auth::user()->id_warehouse)->orderBy('id','desc')->first()->id;
            $items = DB::table('items')
            ->select('id', 'created_by', 'type', 'name', 'descripcion', DB::raw("(select quantity from movements where id = $ultimo_movimiento_agregado) as quantity"), 'price', 'commision', 'reseller_price', 'comments')
            ->where('id',$id)
            ->get();
        }
       


        return $items;
    }

    // Listo
    public function updateproducto(request $request)
    {
        $data = $request->get('data');
        $fechaactual = date("y-m-d H:i:s");
        

        $Adjuntar_foto = $request->file('adjuntar_foto_editar');
        if($Adjuntar_foto==''){
            $url = 'NULL';
            $nombre = 'NULL';
        }
        else
        {
            $files = glob('Documentos/*'); // obtiene todos los archivos
            foreach($files as $file){
                if(is_file($file)) // si se trata de un archivo
                    unlink($file); // lo elimina
            }

            $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
            $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';

            $nombre_original=$Adjuntar_foto->getClientOriginalName();

            $name = utf8_decode($nombre_original);
            $name2 = strtr($name, utf8_decode($originales), $modificadas);
            $nombre = utf8_encode($name2);

            $Adjuntar_foto->move('Documentos', $nombre);
            $url =  base64_encode(file_get_contents('Documentos/'.$nombre));
        }

        try
        {
 
            $id_usuario = Auth::User()->id;
            $id_branch = Auth::User()->id_branch;
            $id_warehouse = Auth::User()->id_warehouse;
            $id_item=$request->get('id_item_edit');
            $cantidad=$request->get('cantidad_edit');
            $edit = item::find($id_item);
            $edit->created_by = $id_usuario;
            $edit->type = $request->get('tipo_edit');
            $edit->name = $request->get('nombre_edit');
            $edit->descripcion = $request->get('descripcion_edit');
            $edit->price = $request->get('precio_edit');
            $edit->commision = $request->get('commision_edit');
            $edit->reseller_price = $request->get('revendedor_edit');
            $edit->comments = $request->get('comentarios_edit');
            $edit->nombreimage = $nombre;
            $edit->adjunto = $url;
            $edit->save();
            if (Auth::user()->id_warehouse < 1) {
                $idbodega=$request->get('idbodega');
                
                if($idbodega==0){
                $editmovement=DB::table('movements')
                ->where('id_item', $id_item)
                ->update(['quantity' => $cantidad,'created_at'=>$fechaactual]);
                        
                }else{
                    $ultimo_movimiento_agregado = DB::table('movements')->select('id')->where('id_item',$request->get('id_item_edit'))->where('id_warehouse', $idbodega)->orderBy('id','desc')->first()->id;
                    $editmovement = movements::find($ultimo_movimiento_agregado);
                    $editmovement->quantity = $request->get('cantidad_edit');
                    $editmovement->created_at = $fechaactual;
                    $editmovement->save();
                }

            }else {
                $ultimo_movimiento_agregado = DB::table('movements')->select('id')->where('id_item',$request->get('id_item_edit'))->where('id_warehouse', $id_warehouse)->orderBy('id','desc')->first()->id;
                $editmovement = movements::find($ultimo_movimiento_agregado);
                $editmovement->quantity = $request->get('cantidad_edit');
                $editmovement->created_at = $fechaactual;
                $editmovement->save();
            }
            return redirect()->action(
                    'ProductoController@index', ['message' => 1]
            );
        }
        catch(\Excepcion $e)
        {
            return redirect()->action(
                'ProductoController@index', ['message' => 2]
            );
        }
    }

    // Listo
    public function vendedores(){
      return DB::table('users')->join('roles', 'users.id_rol', '=', 'roles.id')->select('users.id', 'users.name')->where('roles.name', 'like', 'vendedor')->get();
    }

    public function apartar(request $request)
    {
        try{

            $datos = $request->all();

            $id_usuario = Auth::User()->id;
            $id_branch = Auth::User()->id_branch;
            $id_warehouse = Auth::User()->id_warehouse;

            $fechaactual = date("y-m-d H:i:s");

            $cuenta = count($datos['productos']);

            for($i = 0; $i < $cuenta; $i++) {

                $addmovin = new movements;
                $addmovin->id_item = $datos['productos'][$i];
                $addmovin->id_invoice = 0;
                $addmovin->id_user = $id_usuario;
                $addmovin->id_branch = $id_branch;
                $addmovin->id_warehouse = $id_warehouse;
                $addmovin->id_status = DB::table('status')->select('id')->where('estado', 'like', 'apartado')->first()->id;
                $addmovin->quantity = ($datos['cantidades'][$i]*-1);
                $addmovin->created_at = $fechaactual;
                $addmovin->save();
                for($m = 0 ; $m < count($datos['v_vendedor']); $m++){
                    $additem_seller = new items_seller;
                    $additem_seller->id_movement = $addmovin->id;
                    $additem_seller->id_user = $datos['v_vendedor'][$m];
                    $additem_seller->id_status = DB::table('status')->select('id')->where('estado', 'like', 'apartado')->first()->id;
                    $additem_seller->comment = $datos['v_comentario']; 
                    $additem_seller->created_at = $fechaactual;
                    $additem_seller->save();
                }
         
            }

            return 1;
        }
        catch(\Excepcion $e)
        {
            return 0;
        }
    }
}