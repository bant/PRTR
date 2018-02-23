<?php

namespace App\Http\Controllers;

use App\Chemical;
use App\ChemicalType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Validators\PrtrValidator;

class ChemicalController extends Controller
{
    //

    public function index(Request $request)
    {
        $items = Chemical::all();
//        $query_folder = '';
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
        return view('chemical.find', compact('chemical_types'));
    }

    /**
     * 
     */
    public function search(Request $request)
    {
        // inputs
        $inputs = $request->all();

        // ルール
        $rules = [
           'chemical_no' => 'numeric2',
            'old_chemical_no' => 'numeric2',
            'cas' => 'numeric2',
        ];

        //
        $messages = [
            'chemical_no.numeric2' => '化学物質番号は整数で入力してください。',
            'old_chemical_no.numeric2' => '旧化学物質番号は整数で入力してください。',
            'cas.numeric2' => 'CAS登録番号は整数で入力してください。',
        ];

        // バリデーション
 //       $validation = \Validator::make($inputs, $rules, $messages);
         $validation = \Validator::make($inputs, $rules, $messages);
        // エラーの時

        if($validation->fails())
        {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }

        $name = $inputs['name'];
        $chemical_type_id = $inputs['chemical_type_id'];
        $old_chemical_type_id = $inputs['old_chemical_type_id'];
        $chemical_no = $inputs['chemical_no'];
        $old_chemical_no = $inputs['old_chemical_no'];
        $cas = $inputs['cas'];

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
            return $query->Where('cas', $cas);
        })
        ->paginate(10);

        return view('chemical.list', compact('inputs','chemicals'));

    }
}
