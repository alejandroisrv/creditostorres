<?php

namespace App\Http\Controllers;

use App\bodega;
use Illuminate\Http\Request;

class BodegaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return bodega::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $bodega = bodega::create($request->all());
        return $bodega;
    }

    public function update(Request $request,$id)
    {
        $bodega = bodega::find($id);
        $bodega->update($request->all());

        $bodega->save();
        return $bodega;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\bodega  $bodega
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        return bodega::destroy($id);
    }
}
