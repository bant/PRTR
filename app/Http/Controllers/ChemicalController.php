<?php

namespace App\Http\Controllers;

use App\Chemical;
use App\ChemicalType;
use App\Discharge;
use App\RegistYear;
use App\Pref;

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
    public function factories($id, $sort_op, $select_year=null)
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
    public function prefectures($id, $sort_op, $select_year=null)
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

        $table_totals = Discharge::select(
            DB::raw("
                    ja_factory.pref_id AS pref_id,
                    ja_discharge.regist_year_id AS regist_year_id,
                    SUM(ja_discharge.atmosphere) AS total_atmosphere,
                    SUM(ja_discharge.sea) AS total_sea,
                    SUM(ja_discharge.soil) AS total_soil,
                    SUM(ja_discharge.reclaimed) AS total_reclaimed,
                    SUM(ja_discharge.sewer) AS total_sewer,
                    SUM(ja_discharge.other) AS total_other,
                    SUM(ja_discharge.sum_exhaust) AS total_sum_exhaust,
                    SUM(ja_discharge.sum_movement) AS total_sum_movement
                "))
            ->join('ja_factory','ja_factory.id','=','ja_discharge.factory_id') 
            ->where('ja_discharge.chemical_id', '=', $id)
            ->when($select_year, function ($query) use ($select_year) {
                return $query->where('ja_discharge.regist_year_id', '=', $select_year);
            })  
            ->groupBy('ja_factory.pref_id', 'ja_discharge.regist_year_id')
            ->orderBy('total_sum_movement', 'desc')
//            ->orderBy('ja_discharge.regist_year_id', 'asc')
            ->get();

        $pref_discharges = array();
        $pref_discharges_count = 0;

        foreach($table_totals as $table_total)
        {
            $pref = Pref::find($table_total['pref_id']);
            $regist_year = RegistYear::find($table_total['regist_year_id']);

            $total_atmosphere = round($table_total['total_atmosphere'], 1);
            $total_sea = round($table_total['total_sea'], 1);
            $total_soil = round($table_total['total_soil'], 1);
            $total_reclaimed = round($table_total['total_reclaimed'], 1);
            $total_sewer = round($table_total['total_sewer'], 1);
            $total_other = round($table_total['total_other'], 1);
            $total_sum_exhaust = round($table_total['total_sum_exhaust'], 1);
            $total_sum_movement = round($table_total['total_sum_movement'], 1);


/*
            $total_atmosphere = (double)$table_total['total_atmosphere'];
            $total_sea = (double)$table_total['total_sea'];
            $total_soil = (double)$table_total['total_soil'];
            $total_reclaimed = (double)$table_total['total_reclaimed'];
            $total_sewer = (double)$table_total['total_sewer'];
            $total_other = (double)$table_total['total_other'];
            $total_sum_exhaust = (double)$table_total['total_sum_exhaust'];
            $total_sum_movement = (double)$table_total['total_sum_movement'];
*/
            if ($total_atmosphere == 0.0 
                and $total_sea == 0.0 
                and $total_soil == 0.0 
                and $total_reclaimed == 0.0
                and $total_sewer == 0.0 
                and $total_other == 0.0
                
                and $total_sum_exhaust == 0.0 
                and $total_sum_movement == 0.0)
                continue;

            $pref_discharges[] = array (
                'PREF' => $pref->name,
                'REGIST_YEAR' => $regist_year->name,
                'TOTAL_ATMOSPHERE' => $total_atmosphere,
                'TOTAL_SEA' => $total_sea,
                'TOTAL_SOIL' => $total_soil,
                'TOTAL_RECLAIMED' => $total_reclaimed,
                'TOTAL_SEWER' => $total_sewer,
                'TOTAL_OTHER' => $total_other,
                'TOTAL_EXHAUST' => $total_sum_exhaust,
                'TOTAL_SUM_MOVEMENT' => $total_sum_movement,
                );
            $pref_discharges_count += 1;
        }

        return view('chemical.prefectures', compact('chemical', 'years', 'chemical_infos', 'total_exhaust_infos', 'total_movement_infos', 'select_year', 'pref_discharges', 'pref_discharges_count'));
    }

}
