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
//        $prefs->prepend('全都道府県', 0);    // 最初に追加
        $regist_years = RegistYear::all()->pluck('name', 'id');
 //       $regist_years->prepend('全年度', 0);

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
        $name = isset($inputs['name']) ? $inputs['name'] : null;
/*
        $name2 = isset($inputs['name2']) ? $inputs['name2'] : null;
        $name3 = isset($inputs['name3']) ? $inputs['name3'] : null;
        $name4 = isset($inputs['name4']) ? $inputs['name4'] : null;
        $name5 = isset($inputs['name5']) ? $inputs['name5'] : null;
*/
        $chemical_name = isset($inputs['chemical_name']) ? $inputs['chemical_name'] : null;
        $regist_year_id = isset($inputs['regist_year_id']) ? $inputs['regist_year_id'] : 0;

        $prefs = Pref::all()->pluck('name','id');
//        $prefs->prepend('全都道府県', 0);    // 最初に追加

        $regist_years = RegistYear::all()->pluck('name', 'id');
 //       $regist_years->prepend('全年度', 0);

        $query = Factory::join('ja_discharge','ja_factory.id','=','ja_discharge.factory_id')
        ->when(!is_null($name), function ($query) use ($name) {
            return $query->where('ja_factory.name','like', "%$name%");
        })
        ->when($pref_id != '0', function ($query) use ($pref_id) {
            return $query->where('ja_factory.pref_id', '=', $pref_id);
        })
        ->when(!is_null($city), function ($query) use ($city) {
            return $query->where('ja_factory.city','like', "'%$city%");
        })
        ->when(!is_null($address), function ($query) use ($address) {
            return $query->where('ja_factory.address','like', "'%$address%");
        })
        ->orderBy('ja_discharge.regist_year_id', 'asc')
        ->distinct('ja_factory.name');
        
        $all_count = $query->count();
        $factories = $query->paginate(10);



 /*
        $query = Factory::query();
        if (!is_null($name))
        {
            $query->where('name','like', "%$name%");
        }

        if ($pref_id != '0')
        {
            $query->where('pref_id', '=',$pref_id);
        }

        if (!is_null($city))
        {
            $query->where('city', 'like', "%$city%");
        }

        if (!is_null($address))
        {
            $query->where('address', 'like', "%$address%");
        }
        $query->orderBy('pref_id', 'asc');
        $query->distinct('name');
        $all_count = $query->count();
        $factories = $query->paginate(10);
*/

        return view('discharge.compare', compact('prefs', 'regist_years', 'factories'));
    }
}
