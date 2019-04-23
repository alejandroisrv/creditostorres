<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use DB;

use DataTables;

use App\Models\invoice;

use App\Models\itemsinvoice;

use App\Models\head;

use App\Models\sales;

use App\Models\salescommision;

use App\Models\paymentagreement;

use App\Models\payments;

use App\Models\delinquentclient;

use App\Models\movements;

class FacturaController extends Controller
{

    public function index()
    {
        $productos;

        if (Auth::user()->id_warehouse < 1) {
            $productos = DB::table('items')
                ->select('items.id', 'name', 'descripcion','items.price', DB::raw("sum(quantity) as quantity"))
                ->join('movements', 'movements.id_item', '=', 'items.id')
                ->where('movements.id_branch', '=', Auth::user()->id_branch)
                ->groupBy('items.id', 'name', 'descripcion','price')
                ->get();
        } else {
            $productos = DB::table('items')
                ->select('items.id', 'name', 'descripcion', DB::raw("sum(quantity) as quantity"),'price')
                ->join('movements', 'movements.id_item', '=', 'items.id')
                ->where('movements.id_branch', '=', Auth::user()->id_branch)
                ->where('movements.id_warehouse', '=', Auth::user()->id_warehouse)
                ->groupBy('items.id', 'name', 'descripcion')
                ->get();
        }
        $clientes = DB::table('clients')->select('id','name','lastname')->get();
        return view('facturas.index')->with('productos',$productos)->with('clientes',$clientes);
    }

    public function busquedafacturas(request $request)
    {
        $facturas_id = DB::table('invoice')
            ->select(DB::raw("invoice.id, invoice.user, invoice.taxes,invoice.subtotal, invoice.total, invoice.created_at, users.name as username"))
            ->leftjoin('users', 'users.id', '=', 'invoice.user')
            ->orderBy('invoice.id', 'ASC');


        return DataTables::of($facturas_id)->make(true);
    }

    public function detalladofactura(request $request)
    {
        $id = $request->get('id');

        $consulta = DB::table('head')
            ->select(DB::raw("head.invoice, head.client, head.seller, invoice.taxes, invoice.subtotal,invoice.total, invoice.created_at, clients.name as nombrecliente, users.name as nombrevendedor"))
            ->leftjoin('clients', 'clients.id', '=', 'head.client')
            ->leftjoin('users', 'users.id', '=', 'head.seller')
            ->leftjoin('invoice', 'invoice.id', '=', 'head.invoice')
            ->where('head.invoice', $id)
            ->get();

        return $consulta;
    }

    public function detalladotablefactura(request $request, $id)
    {
        $consulta = DB::table('items_invoice as ii')
            ->select(DB::raw("i.id, mov.quantity*-1 as quantity, ii.disccount, ii.subtotal, ii.total, i.name as nombreproducto"))
            ->join('movements as mov', 'ii.id_movimiento', 'mov.id')
            ->join('items as i', 'mov.id_item', 'i.id')
            ->where('mov.id_invoice', $id);

        /*
                $consulta = DB::table('items_invoice')
                                ->select(DB::raw("items_invoice.item, items_invoice.quantity, items_invoice.disccount, items_invoice.subtotal, items_invoice.total, items.name as nombreproducto"))
                                ->leftjoin('items','items.id','=','items_invoice.item')
                                ->where('items_invoice.invoice',$id);
        */
        return DataTables::of($consulta)->make(true);
    }

    public function crearfactura(request $request)
    {
        $fechaactual = date("y-m-d H:i:s");
        $datos=$request->all();

        try {
            $items = $datos['productos'];
            $cantidad = $datos['cantidades'];
            $cliente=$datos['cliente'];
            $descuento = $datos['descuentoAdd'];
            $comments = $datos['comentarioAdd'];
            
            
            $add = new invoice;
            $add->user =  Auth::User()->id;
            $add->taxes = $datos['impuestoAdd'];
            $add->subtotal = $datos['subtotalAdd'];
            $add->total = $datos['subtotalAdd'];
            $add->state ="Activo";
            $add->created_at = $fechaactual;
            $add->save();
            
            $dato_id = $add->id;
        
            $conteo = count($items);
            $calculo = 0;
            $acumulado = 0;
            $totalGeneral=0;
            for ($i = 0; $i < count($items); $i++) {
                
                $consultaitem = DB::table('items')->select('commision','price')->where('id', $items[$i])->first();
                $calculo = ($items[$i]*$cantidad[$i])*$consultaitem->commision;
                $total=$consultaitem->price*$cantidad[$i];
                $totalGeneral+=$total;

                $calculo = $total * $consultaitem->commision;
                $acumulado = $acumulado + $calculo;


                // agregar movimientos salientes

                $movimiento = new movements;
                $movimiento->id_item = $items[$i];
                $movimiento->id_invoice = $dato_id;
                $movimiento->id_user =  Auth::User()->id;
                $movimiento->id_branch = Auth::User()->id_branch;
                $movimiento->id_warehouse = Auth::User()->id_branch;
                $movimiento->id_status = DB::table('status')->select('id')->where('estado', 'like', 'facturado')->first()->id;
                $movimiento->quantity = ($cantidad[$i] * -1);
                $movimiento->created_at = $fechaactual;
                $movimiento->save();
        
                $additeminvoice = new itemsinvoice;
                $additeminvoice->id_movimiento = $movimiento->id;
                $additeminvoice->disccount = $descuento;
                $additeminvoice->subtotal = $datos['subtotalAdd'];;
                $additeminvoice->total = $total;
                $additeminvoice->created_at = $fechaactual;
                $additeminvoice->state = 'Activo';
                $additeminvoice->comments = $comments;
                $additeminvoice->save();
            }

            $addhead = new head;
            $addhead->invoice = $dato_id;
            $addhead->client = $cliente;
            $addhead->seller =  Auth::User()->id;
            $addhead->created_at = $fechaactual;
            $addhead->save();

            $addcomi = new salescommision;
            $addcomi->seller =  Auth::User()->id;
            $addcomi->invoice = $dato_id;
            $addcomi->total = $acumulado;
            $addcomi->state = 'Nopagado';
            $addcomi->created_at = $fechaactual;
            $addcomi->comments = $datos['comentarioAdd'];
            $addcomi->save();

            $idcommision = $addcomi->id;
          
            $addcommision = new sales;
            $addcommision->invoice = $dato_id;
            $addcommision->commision = $idcommision;
            $addcommision->created_at = $fechaactual;
            $addcommision->comments = '';
            $addcommision->save();

            $total_q = $totalGeneral / $datos['cuotasAdd'];

            // Si hay que actualizar se consulta y se trae los datos.

            $addacuerdo = new paymentagreement;
            $addacuerdo->client = $cliente;
            $addacuerdo->seller = Auth::User()->id;
            $addacuerdo->invoice = $dato_id;
            $addacuerdo->number_installments = $datos['cuotasAdd'];
            $addacuerdo->period = $datos['peridoAdd'];
            $addacuerdo->total_quota = $total_q;
            $addacuerdo->total = $totalGeneral;
            $addacuerdo->comments = '';
            $addacuerdo->created_at = $fechaactual;
            $addacuerdo->state = 'Activo';
            $addacuerdo->save();

            return 1;

        } catch (\Exception $e) {
            return $e;
        }
    }

    public function pagos(request $request)
    {
        try {
            $fechaactual = date("y-m-d H:i:s");

            $consulta = DB::table('payment_agreement')->select('id', 'client')->where('invoice', $request->get('invoice'))->first();

            $addpago = new payments;
            $addpago->payment_agreement = $consulta->id;
            $addpago->collector = $request->get('user');
            $addpago->paymentvalue = $request->get('paymentvalue');
            $addpago->totalrecieve = $request->get('totalrecieve');
            $addpago->iscompletedpayment = $request->get('completedpayment');
            $addpago->finalpayment = $request->get('paymenttotal');
            $addpago->created_at = $fechaactual;
            $addpago->comments = $request->get('comments');
            $addpago->save();

            $total = $request->get('paymenttotal') * 0.10;

            if ($request->get('paymenttotal') == 'No') {
                $consultamorosa = DB::table('delinquent_client')
                    ->where('client', '=', $consulta->client)
                    ->get();

                if (empty($consultamorosa)) {
                    $addmora = new delinquentclient;
                    $addmora->client = $consulta->client;
                    $addmora->payment_agreement = $consulta->id;
                    $addmora->state = 'Activo';
                    $addmora->comments = $request->get('comments');
                    $addmora->created_at = $fechaactual;
                    $addmora->save();
                } else {
                    $actualizar = DB::table('delinquent_client')
                        ->where('client', '=', $consulta->client)
                        ->update(['state' => 'Activo']);
                }

            }

            $addcomi = new salescommision;
            $addcomi->seller = $request->get('user');
            $addcomi->invoice = $consulta->id;
            $addcomi->total = $total;
            $addcomi->state = 'Activo';
            $addcomi->created_at = $fechaactual;
            $addcomi->comments = $request->get('comments');
            $addcomi->save();


        } catch (\Exception $e) {
            return $e;
        }
    }
}
