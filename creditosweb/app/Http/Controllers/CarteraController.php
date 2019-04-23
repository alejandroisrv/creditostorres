<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;


class CarteraController extends Controller
{
    public function index()
    {
    	$consulta = DB::table('routes')
    					->select(DB::raw("id,comments"))
    					->get();

    	return view('cartera.index')->with('rutas',$consulta);
    }

    public function reporte(request $request)
    {

        $ruta = $request->get('ruta');

        $consultarutas = DB::table('routes_destination')
                            ->select('client')
                            ->where('route',$ruta)
                            ->get();
        $unoporuno = [];
        foreach ($consultarutas as $value) {

            $cliente = $value->client;

            $consultafacturas = DB::table('head')    
                                ->select('invoice')
                                ->where('client',$cliente)
                                ->get();

            foreach ($consultafacturas as $key) {
                $factura = $key->invoice;

                $consultacabecera = DB::table('head')
                                ->select(DB::raw("head.invoice, head.client, head.seller, invoice.created_at, CONCAT(clients.name,' ',clients.lastname) as nombrecompleto, clients.address, clients.telephone, clients.email, users.name as nombrevendedor, invoice.total"))
                                ->leftjoin('invoice','invoice.id','=','head.invoice')
                                ->leftjoin('clients','clients.id','=','head.client')
                                ->leftjoin('users','users.id','=','head.seller')
                                ->where('head.invoice',$factura)
                                ->where('head.client',$cliente)
                                ->get();
                $consultaitem = DB::table('items_invoice')
                                        ->select(DB::raw("items.name"))
                                        ->leftjoin('items','items.id','=','items_invoice.item')
                                        ->where('items_invoice.invoice',$factura)
                                        ->get();

                $pagos = DB::table('payments')
                                ->select(DB::raw("payments.created_at, payments.totalrecieve, payments.finalpayment"))
                                ->leftjoin('payment_agreement','payment_agreement.id','=','payments.payment_agreement')
                                ->where('payment_agreement.invoice',$factura)
                                ->where('payment_agreement.client',$cliente)
                                ->get();


                $datos = [];

                array_push($datos, $consultacabecera, $consultaitem,$pagos);

            }
            
            array_push($unoporuno, $datos);
        }  	
		
        
		return $unoporuno;    

    }

    public function reportes($ruta)
    {

        //$ruta = $request->get('ruta');

        $consultarutas = DB::table('routes_destination')
                            ->select('client')
                            ->where('route',$ruta)
                            ->get();
        $unoporuno = [];
        foreach ($consultarutas as $value) {

            $cliente = $value->client;

            $consultafacturas = DB::table('head')    
                                ->select('invoice')
                                ->where('client',$cliente)
                                ->get();

            foreach ($consultafacturas as $key) {
                $factura = $key->invoice;

                $consultacabecera = DB::table('head')
                                ->select(DB::raw("head.invoice, head.client, head.seller, invoice.created_at, CONCAT(clients.name,' ',clients.lastname) as nombrecompleto, clients.address, clients.telephone, clients.email, users.name as nombrevendedor, invoice.total"))
                                ->leftjoin('invoice','invoice.id','=','head.invoice')
                                ->leftjoin('clients','clients.id','=','head.client')
                                ->leftjoin('users','users.id','=','head.seller')
                                ->where('head.invoice',$factura)
                                ->where('head.client',$cliente)
                                ->get();
                $consultaitem = DB::table('items_invoice')
                                        ->select(DB::raw("items.name"))
                                        ->leftjoin('items','items.id','=','items_invoice.item')
                                        ->where('items_invoice.invoice',$factura)
                                        ->get();

                $pagos = DB::table('payments')
                                ->select(DB::raw("payments.created_at, payments.totalrecieve, payments.finalpayment"))
                                ->leftjoin('payment_agreement','payment_agreement.id','=','payments.payment_agreement')
                                ->where('payment_agreement.invoice',$factura)
                                ->where('payment_agreement.client',$cliente)
                                ->get();


                $datos = [];

                array_push($datos, $consultacabecera, $consultaitem,$pagos);

            }
            
            array_push($unoporuno, $datos);
        }   
        
        //return $datos;    

    }
}
