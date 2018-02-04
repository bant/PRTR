<?php

namespace App\Http\Controllers;

use App\Chemical;
use App\ChemicalType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // 日付操作

class ChemicalController extends Controller
{
    //

    public function index(Request $request)
    {
//        $items = Chemical::all();
        $query_folder = '';
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
        $copyright_year = Carbon::now()->format('Y');

        return view('chemical.find', compact('name','chemical_types','old_chemical_types','chemical_no','old_chemical_no','cas','copyright_year'));
    }

    /**
     * 
     */
    public function search(Request $request)
    {
        $name = $request->input('name');
        $chemical_type_id = $request->input('chemical_type_id');
        $old_chemical_type_id = $request->input('old_chemical_type_id');
        $chemical_no = $request->input('chemical_no');
        $old_chemical_no = $request->input('old_chemical_no');
        $cas = $request->input('cas');

        $chemicals = Chemical::select('*')
        ->when($name, function ($query) use ($name) {
            return $query->where('name','like', '%'.$name.'%');
        })
        ->when($chemical_type_id!=0, function ($query) use ($chemical_type_id) {
            return $query->where('chemical_type_id', $chemical_type_id);
        })
        ->when($old_chemical_type_id!=0, function ($query) use ($old_chemical_type_id) {
            return $query->where('old_chemical_type_id', $old_chemical_type_id);
        })
        ->when($chemical_no, function ($query) use ($chemical_no) {
            return $query->where('chemical_no', $chemical_no);
        })
        ->when($old_chemical_no, function ($query) use ($old_chemical_no) {
            return $query->where('old_chemical_no', $old_chemical_no);
        })
        ->when($cas, function ($query) use ($cas) {
            return $query->orWhere('cas', $cas);
        })
        ->paginate(10);
//        ->get();


/*
        $chemicals = DB::table( 'ja_chemical')
                        ->when($name, function ($query) use ($name) {
                            return $query->where('name','like', '%'.$name.'%');
                        })
                        ->when($chemical_type_id!=0, function ($query) use ($chemical_type_id) {
                            return $query->where('chemical_type_id', $chemical_type_id);
                        })
                        ->when($old_chemical_type_id!=0, function ($query) use ($old_chemical_type_id) {
                            return $query->where('old_chemical_type_id', $old_chemical_type_id);
                        })
                        ->when($chemical_no, function ($query) use ($chemical_no) {
                            return $query->where('chemical_no', $chemical_no);
                        })
                        ->when($old_chemical_no, function ($query) use ($old_chemical_no) {
                            return $query->where('old_chemical_no', $old_chemical_no);
                        })
                        ->when($cas, function ($query) use ($cas) {
                            return $query->orWhere('cas', $cas);
                        })
                        ->get();
*/
        return view('chemical.list', compact('chemicals'));

    }
}
