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
    public function factories($id, $select_year=null)
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
            $count = Discharge::where('chemical_id', '=', $id)->where('regist_year_id', '=', $year->id)->count();
            $totals = Discharge::select(DB::raw('SUM(sum_exhaust) AS total_sum_exhaust,SUM(sum_movement) AS total_sum_movement'))
                                ->where('chemical_id', '=', $id)->where('regist_year_id', '=', $year->id)->get();

            $total_sum_exhaust = round($totals[0]['total_sum_exhaust'], 1);
            $total_sum_movement = round($totals[0]['total_sum_movement'], 1);

            $chemical_infos[] = array(
                'YEAR' => $year->name,
                'COUNT' => $count,
                'TOTAL_SUM_EXHAUST' => $total_sum_exhaust,
                'TOTAL_SUM_MOVEMENT' => $total_sum_movement 
            );
            
            $total_exhaust_infos[$year->id] = $total_sum_exhaust;
            $total_movement_infos[$year->id] = $total_sum_movement;
        }
        
        $discharge_count = Discharge::where('chemical_id', '=', $id)
            ->when($select_year, function ($query) use ($select_year) {
                return $query->where('regist_year_id', '=', $select_year);
            })       
            ->count();
        $discharges = Discharge::where('chemical_id', '=', $id)
            ->when($select_year, function ($query) use ($select_year) {
                return $query->where('regist_year_id', '=', $select_year);
            })  
            ->orderBy('regist_year_id', 'asc')
            ->paginate(10);

        // 検索用のデータを作成
        $select_years = RegistYear::all()->pluck('name','id');
        $select_years->prepend('全年度', 0);    // 最初に追加


        return view('chemical.factories', compact('chemical', 'years', 'chemical_infos', 'total_exhaust_infos', 'total_movement_infos', 'select_year', 'discharges', 'discharge_count'));
    }

    /**
     * 都道府県別化学物質レポート
     */
    public function prefectures($id, $select_year=null)
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
            $count = Discharge::select()
                ->join('ja_factory','ja_factory.id','=','ja_discharge.factory_id')
                ->where('ja_factory.pref_id', '=', $id)->where('ja_discharge.regist_year_id', '=', $year->id)->count();
            $totals = Discharge::select(DB::raw('SUM(sum_exhaust) AS total_sum_exhaust,SUM(sum_movement) AS total_sum_movement'))
                ->join('ja_factory','ja_factory.id','=','ja_discharge.factory_id')
                ->where('ja_factory.pref_id', '=', $id)->where('ja_discharge.regist_year_id', '=', $year->id)->get();

//            dd($count);
//            dd($totals);

            $total_sum_exhaust = round($totals[0]['total_sum_exhaust'], 1);
            $total_sum_movement = round($totals[0]['total_sum_movement'], 1);

            $chemical_infos[] = array(
                'YEAR' => $year->name,
                'COUNT' => $count,
                'TOTAL_SUM_EXHAUST' => $total_sum_exhaust,
                'TOTAL_SUM_MOVEMENT' => $total_sum_movement 
            );
            
            $total_exhaust_infos[$year->id] = $total_sum_exhaust;
            $total_movement_infos[$year->id] = $total_sum_movement;
        }

        $discharge_count = Discharge::select()
            ->join('ja_factory','ja_factory.id','=','ja_discharge.factory_id')        
            ->where('ja_discharge.chemical_id', '=', $id)
            ->when($select_year, function ($query) use ($select_year) {
                return $query->where('ja_discharge.regist_year_id', '=', $select_year);
            })       
            ->count();

        $discharges = Discharge::select(DB::raw('ja_factory.pref_id AS pref_id, SUM(sum_exhaust) AS total_sum_exhaust,SUM(sum_movement) AS total_sum_movement'))
            ->join('ja_factory','ja_factory.id','=','ja_discharge.factory_id') 
            ->where('ja_discharge.chemical_id', '=', $id)
            ->when($select_year, function ($query) use ($select_year) {
                return $query->where('ja_discharge.regist_year_id', '=', $select_year);
            })  
            ->groupBy('ja_factory.pref_id', 'ja_discharge.id')
 //           ->orderBy('ja_discharge.regist_year_id', 'asc')
            ->paginate(10);


        return view('chemical.prefectures', compact('chemical', 'years', 'chemical_infos', 'total_exhaust_infos', 'total_movement_infos', 'select_year', 'discharges', 'discharge_count'));
    }

}
