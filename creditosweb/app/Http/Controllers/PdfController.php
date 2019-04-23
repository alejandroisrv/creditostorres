<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

class PdfController extends Controller
{
   	public function crearPDF($datos,$datados,$cadena,$vistaurl,$tipo)
    {
        $data = $datos;
        $date = date('Y-m-d');
        $datad = $datados;
        $datat = $cadena;
        $view = \View::make($vistaurl, compact('data','date','datad','datat'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('oficio');
        $pdf->loadHTML($view);


        if($tipo==1){return $pdf->stream('reporte');}

    }

    public function crear_reporte_remision($tipo)
    {
        $vistaurl = "pdf.pdfmora";

        $consulta = DB::table('delinquent_client')
    				->select(DB::raw("delinquent_client.id, delinquent_client.client, delinquent_client.payment_agreement, delinquent_client.state, delinquent_client.comments, delinquent_client.created_at, clients.name as nombrecliente"))
    				->leftjoin('clients','clients.id','=','delinquent_client.client')
    				->where('delinquent_client.state','Activo')
    				->orderBy('delinquent_client.id','DESC')
    				->get();


        $data = $consulta;
        $datados = '';
        $cadena = '';

        return $this->crearPDF($data,$datados,$cadena,$vistaurl,$tipo);
    }
}
