<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;
use Auth;
class PrincipalController extends Controller
{
    public function index()
    {
        $productos=0;
        if(Auth::User()->id_warehouse<1){
        $products = DB::table('items')
        ->select(DB::raw("sum(quantity) as quantity"))
        ->join('movements', 'movements.id_item', '=', 'items.id')->get();
            foreach($products as $product){
                $productos+=$product->quantity;
            }
        
        }else{
            
        $products = DB::table('items')
        ->select(DB::raw("sum(quantity) as quantity"))
        ->join('movements', 'movements.id_item', '=', 'items.id')
        ->where('movements.id_warehouse', Auth::User()->id_warehouse)
        ->get();
            foreach($products as $product){
                $productos+=$product->quantity;
            }
        
            
        }

        $clientes = DB::table('clients')->count();
        $empleados=DB::table('users')->count();
        $cartera=DB::table('users')->count();
        $bodegas=DB::table('warehouse')->count();
        $rutas=DB::table('routes')->count();
        
        
    	$anual = date("Y");
    	$acumulador = [];
    	$con = 0;
    	for ($i=1; $i < 13 ; $i++) { 
    			$consultacharone =  DB::table('head')
    						->select(DB::raw("COUNT(id) as totalmes"))
    						->whereMonth('created_at','=',$i)
    						->whereYear('created_at','=',$anual)
    						->first();
    			if(empty($consultacharone->totalmes)){
    				$con = 0;
    			}else
    			{
    				$con = intval($consultacharone->totalmes);
    			}
    			array_push($acumulador, $con);
    	} 


    	$chartjs = app()->chartjs
        ->name('lineChartTest')
        ->type('line')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['Ene', 'Feb', 'Mar', 'Abril', 'May', 'Jun', 'Jul','Agos','Sept','Oct','Nov', 'Dic'])
        ->datasets([
            [
                "label" => "Ventas por Mes",
                'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $acumulador,
            ]
        ])
        ->options([]);
        $cantidadentran = 0;
        $cantidadE = [];
        $cantidadsal = 0;
        $cantidadS = [];
        for ($i=1; $i < 13 ; $i++) { 
        			$consultamovimientosE = DB::table('movements')
        							->select(DB::raw("SUM(quantity) as cantidadentrante"))
        							->whereMonth('created_at','=',$i)
									->whereYear('created_at','=',$anual)
                                    ->where('quantity', '>', 0)
									->first();

					$consultamovimientosS = DB::table('movements')
        							->select(DB::raw("SUM(quantity) as cantidadsaliente"))
        							->whereMonth('created_at','=',$i)
									->whereYear('created_at','=',$anual)
                                    ->where('quantity', '<', 0)
									->first();

					if(empty($consultamovimientosE->cantidadentrante)){$cantidadentran = 0;}else{$cantidadentran = intval($consultamovimientosE->cantidadentrante);}
	    			array_push($cantidadE, $cantidadentran);
	    			if(empty($consultamovimientosS->cantidadsaliente)){$cantidadsal = 0;}else{$cantidadsal = intval($consultamovimientosS->cantidadsaliente);}
	    			array_push($cantidadS, $cantidadsal);
		}
        
        $chartround = app()->chartjs
         ->name('barChartTest')
         ->type('bar')
         ->size(['width' => 400, 'height' => 200])
         ->labels(['Ene', 'Feb', 'Mar', 'Abril', 'May', 'Jun', 'Jul','Agos','Sept','Oct','Nov', 'Dic'])
         ->datasets([
             [
                 "label" => "Movimientos Entrantes",
                 'backgroundColor' => ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                 'data' => $cantidadE
             ],
             [
                 "label" => "Movimientos Salientes",
                 'backgroundColor' => ['rgba(255, 99, 132, 0.3)', 'rgba(54, 162, 235, 0.3)'],
                 'data' => $cantidadS
             ]
         ])
         ->options([]);

         $ventasfactu = DB::table('head')
         					->select(DB::raw("COUNT(id) as cantidadfacturas"))
         					->first();
         $devolufactu = DB::table('claims')
         					->select(DB::raw("COUNT(id) as cantidadevo"))
         					->first();
         $grafica = [];
         array_push($grafica, intval($ventasfactu->cantidadfacturas), intval($devolufactu->cantidadevo));

         $chartpie = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['Ventas', 'Devoluciones'])
        ->datasets([
            [
                'backgroundColor' => ['#FF6384', '#36A2EB'],
                'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                'data' => $grafica
            ]
        ])
        ->options([]);

        $dineromes = [];
    	$sinal = 0;
    	for ($i=1; $i < 13 ; $i++) { 
    			$consultadinero =  DB::table('invoice')
    						->select(DB::raw("SUM(total) as totalmes"))
    						->whereMonth('created_at','=',$i)
    						->whereYear('created_at','=',$anual)
    						->first();
    			if(empty($consultadinero->totalmes)){
    				$sinal = 0;
    			}else
    			{
    				$sinal = intval($consultadinero->totalmes);
    			}
    			array_push($dineromes, $sinal);
    	} 

	     $chartlist = app()->chartjs
		         ->name('ChartTest')
		         ->type('bar')
		         ->size(['width' => 400, 'height' => 200])
		         ->labels(['Ene', 'Feb', 'Mar', 'Abril', 'May', 'Jun', 'Jul','Agos','Sept','Oct','Nov', 'Dic'])
		         ->datasets([
		             [
		                 "label" => "Facturado",
		                 'backgroundColor' => ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
		                 'data' => $dineromes
		             ]
		         ])
		         ->options([]);


		return view('principal', compact('chartjs','chartround','chartpie','chartlist','empleados','clientes','productos','cartera','bodegas','rutas'));

    	//return view('principal');
    }
}
