<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use DataTables;

class CobroController extends Controller
{
    public function index()
    {
    	return view('cobros.index');
    }

    public function busquedacobro(request $request)
    {
		$pagos = DB::table('payments')
		            ->select(DB::raw("payments.id, payments.payment_agreement, payments.collector, payments.paymentvalue, payments.totalrecieve, payments.iscompletedpayment,payments.finalpayment, payments.created_at, payments.comments, users.name as nombrecobrador"))
		            ->leftjoin('users','users.id','=','payments.collector');

        return DataTables::of($pagos)->make(true);
    }

    public function indexacuerdo()
    {
    	return view('cobros.acuerdos');
    }

    public function busquedaacuerdos(request $request)
    {
    	$acuerdos = DB::table('payment_agreement')
            ->select(DB::raw("payment_agreement.id, payment_agreement.client, payment_agreement.seller, payment_agreement.invoice, payment_agreement.number_installments, payment_agreement.period, payment_agreement.total_quota, payment_agreement.total, payment_agreement.comments, payment_agreement.created_at,clients.name as nombrecliente, users.name as nombrevendedor"))
            ->leftjoin('users','users.id','=','payment_agreement.seller')
            ->leftjoin('clients','clients.id','=','payment_agreement.client');

        return DataTables::of($acuerdos)->make(true);
    }
}
