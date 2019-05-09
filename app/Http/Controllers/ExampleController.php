<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function create(Request $request,$id){

        return $request->all();
    }
}
