<?php

namespace App\Http\Controllers;

use App\Factory;
use App\RegistYear;
use App\Pref;
use App\Discharge;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DischargeController extends Controller
{
    /**
     * 事業所比較
     */
    public function search(Request $request)
    {
        $prefs = Pref::all()->pluck('name','id');
        $prefs->prepend('全都道府県', 0);    // 最初に追加
        $regist_years = RegistYear::select()->orderBy('id', 'desc')->pluck('name', 'id');
        $regist_years->prepend('最新年度', 0);

        return view('discharge.search', compact('prefs', 'regist_years'));
    }

    /**
     * 事業所比較結果
     */
    public function compare(Request $request)
    {
        // inputs
        $inputs = $request->all();

        $factory_pref_id = isset($inputs['factory_pref_id']) ? $inputs['factory_pref_id'] : 0;
        $factory_city = isset($inputs['factory_city']) ? $inputs['factory_city'] : null;
        $factory_address = isset($inputs['factory_address']) ? $inputs['factory_address'] : null;
        $factory_name1 = isset($inputs['factory_name1']) ? $inputs['factory_name1'] : null;
//        $factory_name2 = isset($inputs['factory_name2']) ? $inputs['factory_name2'] : null;
        $chemical_name = isset($inputs['chemical_name']) ? $inputs['chemical_name'] : null;
        $regist_year = isset($inputs['regist_year']) ? $inputs['regist_year'] : 0;

        $prefs = Pref::all()->pluck('name','id');
        $prefs->prepend('全都道府県', 0);    // 最初に追加
        $regist_years = RegistYear::select()->orderBy('id', 'desc')->pluck('name','id');
        $regist_years->prepend('最新年度', 0);

        $query = Discharge::query();
        $query->select([ '*', 'ja_discharge.regist_year_id as report_regist_year_id']);
        $query->join('ja_factory','ja_factory.id','=','ja_discharge.factory_id');
        $query->join('ja_chemical','ja_chemical.id','=','ja_discharge.chemical_id');
        if ($factory_pref_id != 0)
        {
            $query->where('ja_factory.pref_id', '=', $factory_pref_id);
        }
        if (!is_null($factory_city))
        {
            $query->where('ja_factory.city','like', "%$factory_city%");
        }
        if (!is_null($factory_address))
        {
            $query->where('ja_factory.address','like', "%$factory_address%");
        }
        if (!is_null($factory_name1))
        {
            $query->where('ja_factory.name','like', "%$factory_name1%");
        }
/*
        if (!is_null($factory_name2))
        {
            $query->where('ja_factory.name','like', "%$factory_name2%");
        }
 */
        if (!is_null($chemical_name))
        {
            $query->where('ja_chemical.name','like', "%$chemical_name%"); 
        }
        if ($regist_year==0)
        {
            $regist_year = RegistYear::max('id');
        }
        $query->where('ja_discharge.regist_year_id', '=', $regist_year);

        $discharge_count = $query->count();
        $discharges = $query->orderBy('ja_discharge.regist_year_id', 'desc')->paginate(10);

        $pagement_params =  $inputs;
        unset($pagement_params['_token']);

        return view('discharge.compare', compact('prefs', 'regist_years', 'discharge_count', 'discharges', 'pagement_params'));
    }
}
