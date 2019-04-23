<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\movementsin;

use App\Models\movementsout;

use Auth;

use DB;

use DataTables;

class MovimientosController extends Controller
{
    public function indexout()
    {
    	return view('movimientos.movout');
    }

    public function busqueda()
    {
        $movimientosout;
        if (Auth::user()->id_warehouse < 1) {
            $movimientosout = DB::table('movements')
                            ->join('items','items.id','=','movements.id_item')
                            ->join('users','users.id','=','movements.id_user')
                            ->select(DB::raw('items.name as nombreitem'), 'id_invoice', DB::raw('users.name as nombreusuario'), 'quantity', 'movements.created_at')
                            ->where('movements.id_branch', '=', Auth::user()->id_branch)
                            ->where('quantity', '<', 0);
        } else {
            $movimientosout = DB::table('movements')
                            ->join('items','items.id','=','movements.id_item')
                            ->join('users','users.id','=','movements.id_user')
                            ->select(DB::raw('items.name as nombreitem'), 'id_invoice', DB::raw('users.name as nombreusuario'), 'quantity', 'movements.created_at')
                            ->where('movements.id_branch', '=', Auth::user()->id_branch)
                            ->where('movements.id_warehouse', '=', Auth::user()->id_warehouse)
                            ->where('quantity', '<', 0);
        }

        return DataTables::of($movimientosout)->make(true);
    }

    public function indexin()
    {
    	return view('movimientos.movin');
    }

    public function busquedain()
    {
        $movimientosin;
        if (Auth::user()->id_warehouse < 1) {
            $movimientosin = DB::table('movements')
                            ->join('items','items.id','=','movements.id_item')
                            ->join('users','users.id','=','movements.id_user')
                            ->select(DB::raw('items.name as nombreitem'), 'id_invoice', DB::raw('users.name as nombreusuario'), 'quantity', 'movements.created_at')
                            ->where('movements.id_branch', '=', Auth::user()->id_branch)
                            ->where('quantity', '>', 0);
        } else {
            $movimientosin = DB::table('movements')
                            ->join('items','items.id','=','movements.id_item')
                            ->join('users','users.id','=','movements.id_user')
                            ->select(DB::raw('items.name as nombreitem'), 'id_invoice', DB::raw('users.name as nombreusuario'), 'quantity', 'movements.created_at')
                            ->where('movements.id_branch', '=', Auth::user()->id_branch)
                            ->where('movements.id_warehouse', '=', Auth::user()->id_warehouse)
                            ->where('quantity', '>', 0);
        }
		
        return DataTables::of($movimientosin)->make(true);
    }
}
