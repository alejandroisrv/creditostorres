<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Auth;

use App\Models\cliente;

use App\Models\routesdestination;

use Carbon\Carbon;
use DateTimeZone;

use App\Models\payments;

use App\Models\delinquentclient;

use App\Models\salescommision;

use App\Models\invoice;

use App\Models\head;

use App\Models\sales;

use App\Models\paymentagreement;

use App\Models\itemsinvoice;

use App\Models\movements;

class ApiController extends Controller
{
    public function listclient()
    {
        $consulta = DB::table('clients')->get();

        return $consulta;
    }

    public function apipromocion(request $request)
    {
        try {
            $consulta = DB::table('promotion')
                ->select(DB::raw("
                            promotion.id, 
                            items.id as id_producto, 
                            items.name, 
                            items.price, 
                            (items.price - promotion.promotionvalue ) as priceafter, 
                            promotion.dateexpiration, 
                            promotion.created_at"))
                ->leftjoin('items', 'items.id', '=', 'promotion.id_item')
                ->get();

            if (!empty($consulta)) {
                return $consulta;
            } else {
                return '15';
            }

        } catch (\Exception $e) {
            return '04';
        }

    }

    public function apiproductos(request $request)
    {
        //try{
        // Query Real
        /*    		$consulta = DB::select("
                        SELECT
                            distinct(items.id),
                            item_type.name,
                            items.descripcion,
                            ( SELECT SUM(quantity) FROM movements WHERE movements.id_item = items.id ) as cantidad,
                            items.price,
                            items.comments,
                            items.created_at,
                            items.reseller_price,
                            items.adjunto
                        FROM items
                        inner join item_type on item_type.id = type");
        */            // Query Real

        //Query de prueba
        $consulta = DB::select("
                SELECT 
                    distinct(items.id),
                    item_type.name as type,
                    items.name, 
                    items.descripcion, 
                    ( SELECT SUM(quantity) FROM movements WHERE movements.id_item = items.id ) as cantidad,
                    items.price, 
                    items.comments, 
                    items.created_at,
                    items.reseller_price, 
                    items.commision,
                    items.adjunto 
                FROM items 
                inner join item_type on item_type.id = type");

        /* No aplican
        items.id as id_local,
        items.id as iva,
        item_type.name as nombreimage,
        */

        //Query de prueba

        return $consulta;
        /*}
        catch(\Exception $e)
        {
            return '04';
        }*/
    }

    public function entregar_productos()
    {

        $fecha = Carbon::now(new DateTimeZone('America/Bogota'));
        $fecha = $fecha->format('Y-m-d');

        $consulta = DB::select("
        SELECT 
            distinct(items.id),
            item_type.name as type,
            items.name, 
            items.descripcion, 
			-1*movements.quantity as cantidad,
            items.price, 
            items.comments, 
            items.created_at,
            items.reseller_price, 
            items.commision,
            items.adjunto,
            items_sellers.id_user as seller
        FROM items 
        inner join item_type on item_type.id = type
        inner join movements on items.id = movements.id_item
        inner join items_sellers on items_sellers.id_movement = movements.id
        inner join status on items_sellers.id_status = status.id
        WHERE items_sellers.created_at like '$fecha%' AND status.estado not like 'cerrado'");

        return $consulta;
    }

    public function detailuser($id)
    {
        try {
            $consulta = DB::table('users')
                ->select('users.identificacion', 'users.name', 'users.telefono', 'users.email', 'users.usuario')
                ->where('id', $id)
                ->get();

            return $consulta;

        } catch (\Exception $e) {
            return '04';
        }
    }

    public function clientlist()
    {
        try {
            $fecha = Carbon::now(new DateTimeZone('America/Bogota'));
            $consulta = DB::table('clients')
                ->select(DB::raw("
                        distinct(clients.id), 
                        cities.name as municipio,
                        cedula, 
                        clients.name, 
                        lastname, 
                        telephone, 
                        email, 
                        address, 
                        comments, 
                        good_customer,
                        telephone as coordinate, 
                        clients.id as collector"))
                ->join('cities', 'clients.id_municipio', 'cities.id')
                ->get();

            return ($consulta);
        } catch (\Exception $e) {
            return '04';
        }
    }

    /*
    public function clientlist()
    {
        
        $fecha = Carbon::now(new DateTimeZone('America/Bogota'));
        try{
            $consulta = DB::table('clients')
                        ->select(DB::raw("
                        distinct(clients.id), 
                        cities.name as municipio,
                        clients.cedula, 
                        clients.name, 
                        clients.lastname, 
                        clients.telephone, 
                        clients.email, 
                        clients.address, 
                        clients.comments, 
                        clients.good_customer,
                        routes_destination.coordinate, 
                        routes.collector"))
                        ->join('routes_destination','routes_destination.client','clients.id')
                        ->join('routes','routes.id','routes_destination.route')
                        //->join('routes_shedule','routes_shedule.route','routes.id')
                        ->join('cities', 'clients.id_municipio', 'cities.id')
                        ->where('routes.state','like', 'activo')
                        //->where('routes_destination.state','like', 'activo')
                        ->get();

            return ($consulta);
        }catch(\Exception $e)
        {
            return '04';
        }
    }
    */

    public function log($id_usuario, $origen, $clase, $mensaje)
    {
        $fecha = Carbon::now()->__toString();
        DB::table('log')->insert(['id_usuario' => $id_usuario, 'origen' => $origen, 'clase' => $clase, 'mensaje' => $mensaje, 'sucedio' => $fecha]);
    }

    public function addclient($municipio, $cedula, $name, $lastname, $telephone, $address, $email, $comments, $good)
    {
        if (!DB::table('clients')->where('cedula', $cedula)->exists()) {

            $addcliente = new cliente;
            $fechaactual = date("y-m-d H:i:s");

            $municipio = str_replace('+', ' ', $municipio);
            $name = str_replace('+', ' ', $name);
            $lastname = str_replace('+', ' ', $lastname);
            $address = str_replace('+', ' ', $address);
            $comments = str_replace('+', ' ', $comments);
            $good = str_replace('+', ' ', $good);

            if (substr($municipio, -1) == " ") {
                $municipio = substr($municipio, 0, -1);
            }

            if (DB::table('cities')->where('name', 'like', $municipio)->exists()) {
                $addcliente->id_municipio = DB::table('cities')->select('id')->where('name', 'like', $municipio)->first()->id;
            } else {
                $addcliente->id_municipio = DB::table('cities')->insertGetId(
                    ['name' => $municipio, 'state' => 'Activo']
                );
            }

            $addcliente->name = $name;
            $addcliente->lastname = $lastname;
            $addcliente->telephone = $telephone;
            $addcliente->address = $address;
            $addcliente->state = 'A';
            $addcliente->email = $email;
            $addcliente->created_at = $fechaactual;
            $addcliente->comments = $comments;
            $addcliente->good_customer = $good;
            $addcliente->cedula = $cedula;
            $addcliente->save();

            return $addcliente->id;
        } else {
            return DB::table('clients')->where('cedula', $cedula)->first()->id;
        }
    }

    public function updatecomment(request $request)
    {
        $comentario = str_replace('+', ' ', $request->comments);

        $update = DB::table('clients')
            ->where('id', $request->id)
            ->update(['comments' => $comentario]);
        return response($update);
    }

    public function updatechekin(request $request)
    {
        try {
            $id_ruta = $request->get('route');
            $id_cliente = $request->get('client');

            $checkin = $request->get('checkin');
            $checkin_time = $request->get('checkin_time');
            $checkin_coordinate = $request->get('checkin_coordinate');

            if (empty($id_ruta) || empty($id_cliente)) {
                return '04';
            }

            if (empty($checkin) || empty($checkin_time) || empty($checkin_coordinate)) {
                return '04';
            }

            $actualizar = DB::table('routes_destination')
                ->where('route', $id_ruta)
                ->where('client', $id_cliente)
                ->update(['checkin' => $checkin, 'checkin_time' => $checkin_time, 'checkin_coordinates' => $checkin_coordinate]);

            return '07';

        } catch (\Exception $e) {
            return '04';
        }
    }

    public function routedate()
    {
        try {
            //$fecha = $date.' 00:00:00';

            $consulta = DB::table('routes')
                ->select(DB::raw("
                            routes.id, 
                            users.name, 
                            routes.comments, 
                            routes.created_at, 
                            routes_destination.client, 
                            clients.name, 
                            clients.telephone,
                            clients.good_customer, 
                            routes_destination.coordinate, 
                            routes_destination.address,
                            routes.collector as empleado, 
                            IF(EXISTS(SELECT  dc.client FROM delinquent_client dc WHERE dc.client=routes_destination.client),1,0) as mora"))
                ->join('routes_destination', 'routes_destination.route', '=', 'routes.id')
                ->join('users', 'users.id', '=', 'routes.collector')
                ->join('clients', 'clients.id', '=', 'routes_destination.client')
                ->get();

            return $consulta;
        } catch (\Exception $e) {
            return '04';
        }

    }

    public function routeall($empleado)
    {
        try {
            $consulta = DB::table('routes')
                ->select(DB::raw("routes.id, routes.collector, users.name, routes.comments, routes.created_at, routes_destination.client, clients.name, routes_destination.coordinate, routes_destination.address"))
                ->leftjoin('routes_destination', 'routes_destination.route', '=', 'routes.id')
                ->leftjoin('users', 'users.id', '=', 'routes.collector')
                ->leftjoin('clients', 'clients.id', '=', 'routes_destination.client')
                ->where('routes.collector', $empleado)
                ->get();

            return $consulta;
        } catch (\Exception $e) {
            return '04';
        }
    }

    public function schedules()
    {
        return DB::table('routes_shedule')->get();
    }

    public function addnewpayment(request $request)
    {
        //try
        //{
        $fechaactual = date("y-m-d H:i:s");

        $consulta = DB::table('payment_agreement')->select('id', 'client', 'total', 'total_quota')->where('invoice', $request->invoice)->first();

        $totalpagos = DB::table('payments')->select(DB::raw("SUM(payments.totalrecieve) as totalpago"))
            ->where('payments.payment_agreement', $consulta->id)
            ->first();

        $resta = $consulta->total - ($totalpagos->totalpago + $request->valor);

        $addpago = new payments;
        $addpago->payment_agreement = $consulta->id;
        $addpago->collector = $request->empleado;
        $addpago->paymentvalue = $consulta->total_quota;
        $addpago->totalrecieve = $request->valor;

        if ($consulta->total == $totalpagos->totalpago) {
            $addpago->iscompletedpayment = 1;
        } else {
            $addpago->iscompletedpayment = 0;
        }

        $addpago->finalpayment = $resta;
        $addpago->created_at = $fechaactual;
        $addpago->comments = $request->observacion;
        $addpago->save();

        $addcomi = new salescommision;
        $addcomi->seller = $request->empleado;
        $addcomi->invoice = $consulta->id;
        $addcomi->total = $request->valor*.10;
        $addcomi->state = 'NoPagado';
        $addcomi->created_at = $fechaactual;
        $addcomi->comments = $request->observacion;
        $addcomi->save();

        return "ok";
        /*    $total = $request->get('paymenttotal') * 0.10;

        if($request->get('paymenttotal') == 'No')
        {
            $consultamorosa = DB::table('delinquent_client')
                            ->where('client','=',$consulta->client)
                            ->get();

            if(empty($consultamorosa))
            {
                $addmora = new delinquentclient;
                $addmora->client = $consulta->client;
                $addmora->payment_agreement = $consulta->id;
                $addmora->state = 'Activo';
                $addmora->comments = $request->get('comments');
                $addmora->created_at = $fechaactual;
                $addmora->save();
            }else
            {
                $actualizar = DB::table('delinquent_client')
                                 ->where('client','=',$consulta->client)
                                 ->update(['state'=>'Activo']);
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
*/
        //  return '93';

        /*        }
                catch(\Exception $e)
                {
                    return '04';
                }*/
    }

    public function getClientBuys()
    {
        try {
            $consulta = DB::table('head')
                ->select(DB::raw("head.invoice, clients.name, invoice.total, invoice.created_at,head.client, head.seller as vendedor"))
                ->join('clients', 'clients.id', '=', 'head.client')
                ->join('invoice', 'invoice.id', '=', 'head.invoice')
                ->get();

            return $consulta;
        } catch (\Exception $e) {
            return '04';
        }
    }

    public function myPayments($cliente)
    {
        try {
            $consulta = DB::table('head')
                ->select(DB::raw("head.invoice, clients.name, invoice.total, invoice.created_at"))
                ->leftjoin('clients', 'clients.id', '=', 'head.client')
                ->leftjoin('invoice', 'invoice.id', '=', 'head.invoice')
                ->where('head.client', $cliente)
                ->get();
            $totaldebe = 0;

            foreach ($consulta as $value) {
                $totaldebe = $totaldebe + $value->total;
            }

            $consulta2 = DB::table('payments')
                ->select(DB::raw("SUM(payments.totalrecieve) as totalpagado"))
                ->leftjoin('payment_agreement', 'payment_agreement.id', '=', 'payments.payment_agreement')
                ->leftjoin('clients', 'clients.id', '=', 'payment_agreement.client')
                ->where('clients.id', $cliente)
                ->get();
            $totalpagado = 0;

            foreach ($consulta2 as $key) {
                $totalpagado = $totalpagado + $key->totalpagado;
            }

            $consulta3 = DB::table('payments')
                ->select('payments.totalrecieve', 'payments.created_at', 'payments.comments')
                ->leftjoin('payment_agreement', 'payment_agreement.id', '=', 'payments.payment_agreement')
                ->leftjoin('clients', 'clients.id', '=', 'payment_agreement.client')
                ->where('clients.id', $cliente)
                ->get();

            $totales = array('TotalDebe' => $totaldebe, 'TotalPagado' => $totalpagado, 'pagos' => $consulta3);

            return $totales;

        } catch (\Exception $e) {
            return '04';
        }
    }

    public function items_invoice()
    {
        //try{
        $consulta = DB::table('items_invoice')
            ->select(DB::raw("
                                items_invoice.id, 
                                
                                movements.id_item as iditem, 
                                movements.id_invoice as invoice,
                                movements.quantity, 

                                items_invoice.disccount, 
                                items_invoice.subtotal,
                                items_invoice.total,
                                items_invoice.created_at, 
                                items_invoice.state, 
                                items.name as item, 
                                movements.id_user as user"))
            ->join('movements', 'items_invoice.id_movimiento', 'movements.id')
            ->join('items', 'items.id', 'movements.id_item')
            ->get();

        return $consulta;
        /*}catch(\Exception $e)
        {
            return '04';
        }*/
    }

    public function myPaymentAgreement()
    {
        try {
            $consulta = DB::table('payment_agreement')
                ->select(DB::raw("
                                payment_agreement.id, 
                                payment_agreement.client, 
                                payment_agreement.invoice, 
                                payment_agreement.number_installments, 
                                payment_agreement.period, 
                                payment_agreement.total_quota, 
                                payment_agreement.total, 
                                payment_agreement.created_at"))
                ->get();

            return $consulta;
        } catch (\Exception $e) {
            return '04';
        }
    }

    public function listuser()
    {
        try {
            $consulta = DB::table('users')
                ->join('branches', 'users.id_branch', 'branches.id')
                ->join('cities', 'branches.id_ciudad', 'cities.id')

                ->select(DB::raw("users.id, cities.name as municipio, users.identificacion, users.name, users.telefono, users.email, users.usuario, roles.name as nombrerol, users.pass, users.created_at"))
                ->leftjoin('roles', 'roles.id', '=', 'users.id_rol')
                ->get();
            return $consulta;
        } catch (\Exception $e) {
            return '**04';
        }
    }

    public function crearfactura($user, $subtotal_total, $client, $number_quota, $period, $acumulado)
    {
        $fechaactual = date("y-m-d H:i:s");

        //try{

        $add = new invoice;
        $add->user = $user;
        $add->taxes = 0;
        $add->subtotal = $subtotal_total;
        $add->total = $subtotal_total;
        $add->state = 'Activo';
        $add->created_at = $fechaactual;
        $add->save();

        /*            $Id_Datos =  invoice::select('id')->orderBy('id','desc')->first()->get();
                    $dato_id = '';
                    foreach ($Id_Datos as $dato) {
                       $dato_id = $dato->id;
                    }*/
        $dato_id = $add->id;

        $addhead = new head;
        $addhead->invoice = $dato_id;
        $addhead->client = $client;
        $addhead->seller = $user;
        $addhead->created_at = $fechaactual;
        $addhead->save();

        $addcomi = new salescommision;
        $addcomi->seller = $user;
        $addcomi->invoice = $dato_id;
        $addcomi->total = $acumulado;
        $addcomi->state = 'Nopagado';
        $addcomi->created_at = $fechaactual;
        $addcomi->save();

        /*            $datoscomision =  salescommision::select('id')->orderBy('id','desc')->first()->get();
                    $idcommision = '';
                    foreach ($datoscomision as $value) {
                       $idcommision = $value->id;
                    }
                    */
        $idcommision = $addcomi->id;

        $addcommision = new sales;
        $addcommision->invoice = $dato_id;
        $addcommision->commision = $idcommision;
        $addcommision->created_at = $fechaactual;
        $addcommision->comments = '';
        $addcommision->save();

        $total_q = $subtotal_total / $number_quota;

        // Si hay que actualizar se consulta y se trae los datos.

        $addacuerdo = new paymentagreement;
        $addacuerdo->client = $client;
        $addacuerdo->seller = $user;
        $addacuerdo->invoice = $dato_id;
        $addacuerdo->number_installments = $number_quota;
        $addacuerdo->period = $period;
        $addacuerdo->total_quota = $total_q;
        $addacuerdo->total = $subtotal_total;
        $addacuerdo->comments = '';
        $addacuerdo->created_at = $fechaactual;
        $addacuerdo->state = 'Activo';
        $addacuerdo->save();

        /*            $datos = array(
                            'idfactura' => $dato_id,
                            'empleado' => $user
                        );
                        //Devolvemos el array pasado a JSON como objeto
                        //echo json_encode($datos, JSON_FORCE_OBJECT);
                    return json_encode($datos, JSON_FORCE_OBJECT);
        */
        return $dato_id;
        /*}
        catch(\Exception $e)
        {
            return '04';
        }*/
    }

    public function creardetalle($items, $cantidad, $descuento, $subtotal, $total, $comments, $dato_id, $user)
    {
        $fechaactual = date("y-m-d H:i:s");

        $usuario = DB::table('users')->where('id', $user)->first();

        $movimiento = new movements;
        $movimiento->id_item = $items;
        $movimiento->id_invoice = $dato_id;
        $movimiento->id_user = $user;
        $movimiento->id_branch = $usuario->id_branch;
        $movimiento->id_warehouse = $usuario->id_warehouse;
        $movimiento->id_status = DB::table('status')->select('id')->where('estado', 'like', 'facturado')->first()->id;
        $movimiento->quantity = ($cantidad * -1);
        $movimiento->created_at = $fechaactual;
        $movimiento->save();

        $additeminvoice = new itemsinvoice;
        $additeminvoice->id_movimiento = $movimiento->id;
        $additeminvoice->disccount = $descuento;
        $additeminvoice->subtotal = $subtotal;
        $additeminvoice->total = $total;
        $additeminvoice->created_at = $fechaactual;
        $additeminvoice->state = 'Activo';
        $additeminvoice->comments = $comments;
        $additeminvoice->save();

        return "ok";
    }

    public function miscierres()
    {
        $consulta = DB::table('invoice')->select(DB::raw('user as empleado, id as invoice, total, created_at'))->get();
        return $consulta;
    }

    public function cerrardia($usuario)
    {
        $fechaactual = date("y-m-d");

        DB::table('movements as m')->join('items_sellers as i', 'm.id', 'i.id_movement')->where('i.id_user', $usuario)->where('i.created_at', 'like', '%' . $fechaactual . '%')->update(['m.id_status' => DB::table('status')->where('estado', 'like', 'inactivo')->first()->id]);

        return DB::table('items_sellers')->where('id_user', $usuario)->where('created_at', 'like', '%' . $fechaactual . '%')->update(['id_status' => DB::table('status')->where('estado', 'like', 'cerrado')->first()->id]);
    }

    public function datosvendedor(Request $r)
    {
        $datos = json_decode($r->datos);

        $fechaactual = date("y-m-d H:i:s");

        $id_cliente = 0;
        foreach ($datos->clientes as $cliente) {
            if (!DB::table('clients')->where('cedula', $cliente->cedula)->exists()) {

                $addcliente = new cliente;

                if (substr($municipio, -1) == " ") {
                    $municipio = substr($municipio, 0, -1);
                }
                if (DB::table('cities')->where('name', 'like', $cliente->municipio)->exists()) {
                    $addcliente->id_municipio = DB::table('cities')->select('id')->where('name', 'like', $cliente->municipio)->first()->id;
                } else {
                    $addcliente->id_municipio = DB::table('cities')->insertGetId(['name' => $cliente->municipio, 'state' => 'Activo']);
                }

                $addcliente->name = $cliente->nombres;
                $addcliente->lastname = $cliente->apellidos;
                $addcliente->telephone = $cliente->telefono;
                $addcliente->address = $cliente->direccion;
                $addcliente->state = 'A';
                $addcliente->email = $cliente->correo;
                $addcliente->created_at = $fechaactual;
                $addcliente->comments = $cliente->comentarios;
                $addcliente->good_customer = $cliente->buen_cliente;
                $addcliente->cedula = $cedula;
                $addcliente->save();

                $id_cliente = $addcliente->id;
            } else {
                $id_cliente = DB::table('clients')->where('cedula', $cedula)->first()->id;
            }

            // facturas
            $addfactura = new invoice;
            $addfactura->user = $user;
            $addfactura->taxes = 0;
            $addfactura->subtotal = $subtotal_total;
            $addfactura->total = $subtotal_total;
            $addfactura->state = 'Activo';
            $addfactura->created_at = $fechaactual;
            $addfactura->save();
            $id_factura = $addfactura->id;

            $addhead = new head;
            $addhead->invoice = $id_factura;
            $addhead->client = $id_cliente;
            $addhead->seller = $user;
            $addhead->created_at = $fechaactual;
            $addhead->save();

            $addcomi = new salescommision;
            $addcomi->seller = $user;
            $addcomi->invoice = $id_factura;
            $addcomi->total = $acumulado;
            $addcomi->state = 'Nopagado';
            $addcomi->created_at = $fechaactual;
            $addcomi->save();

            $datoscomision = salescommision::select('id')->orderBy('id', 'desc')->first()->get();
            $idcommision = '';
            foreach ($datoscomision as $value) {
                $idcommision = $value->id;
            }
            //

            $addcommision = new sales;
            $addcommision->invoice = $id_factura;
            $addcommision->commision = $idcommision;
            $addcommision->created_at = $fechaactual;
            $addcommision->comments = '';
            $addcommision->save();

            $total_q = $subtotal_total / $number_quota;

            // Si hay que actualizar se consulta y se trae los datos.

            $addacuerdo = new paymentagreement;
            $addacuerdo->client = $id_cliente;
            $addacuerdo->seller = $user;
            $addacuerdo->invoice = $id_factura;
            $addacuerdo->number_installments = $number_quota;
            $addacuerdo->period = $period;
            $addacuerdo->total_quota = $total_q;
            $addacuerdo->total = $subtotal_total;
            $addacuerdo->comments = '';
            $addacuerdo->created_at = $fechaactual;
            $addacuerdo->state = 'Activo';
            $addacuerdo->save();

            $datos = array(
                'idfactura' => $id_factura,
                'empleado' => $user
            );
            //Devolvemos el array pasado a JSON como objeto
            //echo json_encode($datos, JSON_FORCE_OBJECT);
            return json_encode($datos, JSON_FORCE_OBJECT);

            // facturas
        }

        return response($c);
    }
}
