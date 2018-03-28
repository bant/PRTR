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
        $regist_years->prepend('最新年度', 0);

        return view('discharge.search', compact('prefs', 'regist_years'));
    }

    /**
     * 事業所(工場)比較結果
     */
    public function compare(Request $request)
    {
        // inputs
        $inputs = $request->all();

        $pref_id = isset($inputs['discharge_pref_id']) ? $inputs['discharge_pref_id'] : 0;
        $city = isset($inputs['discharge_city']) ? $inputs['discharge_city'] : null;
        $address = isset($inputs['discharge_address']) ? $inputs['discharge_address'] : null;
        $name = isset($inputs['discharge_factroy_name']) ? $inputs['discharge_factory_name'] : null;
        $chemical_name = isset($inputs['chemical_name']) ? $inputs['chemical_name'] : null;
        $regist_year_id = isset($inputs['regist_year_id']) ? $inputs['regist_year_id'] : 0;

        $prefs = Pref::all()->pluck('name','id');
        $prefs->prepend('全都道府県', 0);    // 最初に追加
        $regist_years = RegistYear::all()->pluck('name', 'id');
        $regist_years->prepend('最新年度', 0);

        $query = Factory::join('ja_discharge','ja_factory.id','=','ja_discharge.factory_id')
        ->when(!is_null($chemical_name), function ($query) use ($chemical_name) {
            $query->join('ja_chemical','ja_chemical.id','=','ja_discharge.chemical_id');
            return $query->where('ja_chemical.name','like', "%$chemical_name%");
        })
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
        ->when($regist_year_id != '0', function ($query) use ($regist_year_id) {
            return $query->where('ja_factory.regist_year_id', '=', $regist_year_id);
        });
        
        $factory_count = $query->count();

        $factories = $query->orderBy('ja_discharge.regist_year_id', 'asc')->distinct('ja_factory.name')->paginate(10);

        $pagement_params =  $inputs;
        unset($pagement_params['_token']);

        return view('discharge.compare', compact('prefs', 'regist_years', 'factory_count', 'factories', 'pagement_params'));
    }
}
