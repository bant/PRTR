<?php

namespace App\Http\Controllers;

use App\Chemical;
use Illuminate\Http\Request;

class ChemicalController extends Controller
{
    //

    public function index(Request $request)
    {
        $items = Chemical::all();
        return view('chemical.index', ['items'=>$items]);
    }
}
