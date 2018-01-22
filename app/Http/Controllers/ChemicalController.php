<?php

namespace App\Http\Controllers;

use App\Chemical;
use App\ChemicalType;
use Illuminate\Http\Request;

class ChemicalController extends Controller
{
    //

    public function index(Request $request)
    {
        $items = Chemical::all();
        return view('chemical.index', ['items'=>$items]);
    }

    /**
     * 
     */
    public function find(Request $request)
    {
        $name = '';
        $chemical_types = ChemicalType::all()->pluck('name', 'id');
        $chemical_types->prepend('選択してください', 0);    // 最初に追加
        $old_chemical_types = $chemical_types;
        $chemical_no = 0;
        $old_chemical_no = 0;
        $cas = 0;

        return view('chemical.find', compact('name','chemical_types','old_chemical_types','chemical_no','old_chemical_no','cas'));
    }

}
