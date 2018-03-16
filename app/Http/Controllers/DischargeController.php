<?php

namespace App\Http\Controllers;

use App\Factory;
use App\RegistYear;
use App\Pref;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DischargeController extends Controller
{
    /**
     * 事業所(工場)比較
     */
    public function search(Request $request)
    {
        $prefs = Pref::all()->pluck('name','id');
        $prefs->prepend('全都道府県', 0);    // 最初に追加
        $regist_years = RegistYear::all()->pluck('name', 'id');
        $regist_years->prepend('全年度', 0);

        return view('discharge.search', compact('prefs', 'regist_years'));
    }

    /**
     * 事業所(工場)比較結果
     */
    public function compare(Request $request)
    {
        // inputs
        $inputs = $request->all();

        $pref_id = isset($inputs['pref_id']) ? $inputs['pref_id'] : 0;
        $city = isset($inputs['city']) ? $inputs['city'] : null;
        $address = isset($inputs['address']) ? $inputs['address'] : null;
        $name1 = isset($inputs['name1']) ? $inputs['name1'] : null;
        $name2 = isset($inputs['name2']) ? $inputs['name2'] : null;
        $name3 = isset($inputs['name3']) ? $inputs['name3'] : null;
        $name4 = isset($inputs['name4']) ? $inputs['name4'] : null;
        $name5 = isset($inputs['name5']) ? $inputs['name5'] : null;
        $chemical_name = isset($inputs['chemical_name']) ? $inputs['chemical_name'] : null;
        $regist_year_id = isset($inputs['regist_year_id']) ? $inputs['regist_year_id'] : 0;

        $prefs = Pref::all()->pluck('name','id');
        $prefs->prepend('全都道府県', 0);    // 最初に追加
        $regist_years = RegistYear::all()->pluck('name', 'id');
        $regist_years->prepend('全年度', 0);




        return view('discharge.compare', compact('prefs', 'regist_years'));
    }
}
