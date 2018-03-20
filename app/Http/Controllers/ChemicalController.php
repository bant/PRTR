<?php

namespace App\Http\Controllers;

use App\Chemical;
use App\ChemicalType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Validators\PrtrValidator;

class ChemicalController extends Controller
{
    /**
     * 
     */
    public function search(Request $request)
    {
        $chemical_types = ChemicalType::all()->pluck('name', 'id');
        $chemical_types->prepend('選択してください', 0);    // 最初に追加
        $old_chemical_types = $chemical_types;

        return view('chemical.search', compact('chemical_types', 'old_chemical_types'));
    }

    /**
     * 
     */
    public function list(Request $request)
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

        $validation = \Validator::make($inputs, $rules, $messages);

        // エラーの時
        if($validation->fails())
        {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
       
        $name = isset($inputs['name']) ? $inputs['name'] : null;
        $chemical_type_id = isset($inputs['chemical_type_id']) ? $inputs['chemical_type_id'] : 0;
        $old_chemical_type_id = isset($inputs['old_chemical_type_id']) ? $inputs['old_chemical_type_id'] : 0;
        $chemical_no = isset($inputs['chemical_no']) ? $inputs['chemical_no'] : null;
        $old_chemical_no = isset($inputs['old_chemical_no']) ? $inputs['old_chemical_no'] : null;
        $cas = isset($inputs['cas']) ? $inputs['cas'] : null;

        // 問い合わせSQLを構築
        $query = Chemical::query();
        if (!is_null($name))
        {
            $query->where('name','like', "%$name%");
        }
        if ($chemical_type_id != 0)
        {
            $query->where('chemical_type_id', '=', $chemical_type_id);
        }
        if ($old_chemical_type_id != 0)
        {
            $query->where('old_chemical_type_id', '=', $old_chemical_type_id);
        }
        if (!is_null($chemical_no))
        {
            $query->where('chemical_no','=', $chemical_no);
        }
        if (!is_null($old_chemical_no))
        {
            $query->where('old_chemical_no','=', $old_chemical_no);
        }        
        if (!is_null($cas))
        {
            $query->where('cas','=', $cas);
        }
        $query->orderBy('id', 'asc');
        $query->distinct('name');
        $all_count = $query->count();
        $chemicals = $query->paginate(10);

        $pagement_params =  $inputs;
        unset($pagement_params['_token']);

        $chemical_types = ChemicalType::all()->pluck('name', 'id');
        $chemical_types->prepend('選択してください', 0);    // 最初に追加
        $old_chemical_types = $chemical_types;

        return view('chemical.list', compact('chemical_types', 'old_chemical_types', 'inputs', 'chemicals','all_count','pagement_params'));

        /*

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
*/
    }
}
