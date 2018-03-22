<?php

namespace App\Http\Controllers;

use App\Chemical;
use App\ChemicalType;
use App\Discharge;
use App\RegistYear;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Validators\PrtrValidator;

class ChemicalController extends Controller
{
    /**
     * 化学物質検索
     */
    public function search(Request $request)
    {
        $chemical_types = ChemicalType::all()->pluck('name', 'id');
        $chemical_types->prepend('選択してください', 0);    // 最初に追加
        $old_chemical_types = $chemical_types;

        return view('chemical.search', compact('chemical_types', 'old_chemical_types'));
    }

    /**
     * 化学物質検索結果
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
    }

    /**
     * 
     */
    public function factories($id)
    {
        $chemical = Chemical::find($id);
        if($chemical == null)
        {
            abort('404');
        }

        // 取扱工場情報を取得
        $years = RegistYear::all();      

        $chemical_infos = array();
        $sum_exhaust_infos = array();
        $sum_movement_infos = array();
        foreach ($years as $year)
        {
            $count = Discharge::where('regist_year_id', '=', $year->id)->count();
            $all_sum_exhaust = Discharge::sum('sum_exhaust')->where('regist_year_id', '=', $year->id)->get();
            $all_sum_movement = Discharge::sum('sum_movement')->where('regist_year_id', '=', $year->id)->get();

            $chemical_infos[] = array(
                'YEAR' => $year->name,
                'COUNT' => $count,
                'SUM_EXHAUST' => $all_sum_exhaust,
                'SUM_MOVEMENT' => $all_sum_movement );
            
            $sum_exhaust_infos[$year->id] = $all_sum_exhaust;
            $sum_movement_infos[$year->id] = $all_sum_movement;
        }

        return view('chemical.factories', compact('chemical', 'years', 'chemical_infos', 'sum_exhaust_infos', 'sum_movement_infos'));
    }
}
