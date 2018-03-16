<?php

namespace App\Http\Controllers;

use App\BusinessType;
use App\Discharge;
use App\Factory;
use App\FactoryHistory;
use App\FactoryBusinessType;
use App\Pref;
use App\RegistYear;

use Carbon\Carbon; // 日付操作
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FactoryController extends Controller
{
    /**
     * 工場検索
     */
    public function search(Request $request)
    {
        $business_types = BusinessType::all()->pluck('name','id');
        $business_types->prepend('全業種', 0);    // 最初に追加
        $prefs = Pref::all()->pluck('name','id');
        $prefs->prepend('全都道府県', 0);    // 最初に追加
    
        return view('factory.search', compact('business_types','prefs'));
    }


    /**
     * 工場リスト
     */
    public function list(Request $request)
    {
        // inputs
        $inputs = $request->all();
       
        $name = isset($inputs['name']) ? $inputs['name'] : null;
        $business_type_id = isset($inputs['business_type_id']) ? $inputs['business_type_id'] : 0;
        $pref_id = isset($inputs['pref_id']) ? $inputs['pref_id'] : 0;
        $city = isset($inputs['city']) ? $inputs['city'] : null;
        $address = isset($inputs['address']) ? $inputs['address'] : null;

        $business_types = BusinessType::all()->pluck('name','id');
        $business_types->prepend('全業種', 0);    // 最初に追加
        $prefs = Pref::all()->pluck('name','id');
        $prefs->prepend('全都道府県', 0);    // 最初に追加

        $query = Factory::query();
        if (!is_null($name))
        {
            $query->where('name','like', "%$name%");
        }
        
        if ($business_type_id != '0')
        {
            $query->where('business_type_id', '=',$business_type_id);
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

        $pagement_params =  $inputs;
        unset($pagement_params['_token']);

        return view('factory.list', compact('business_types', 'prefs', 'factories', 'all_count', 'pagement_params'));
    }

    /**
     * 工場届出情報の表示
     */
    public function report($id)
    {
        $factory = Factory::find($id);
        if($factory == null)
        {
            abort('404');
        }

        // 検索用のデータを作成
        $years = RegistYear::all()->pluck('name','id');
        $years->prepend('全年度', 0);    // 最初に追加

        $factory_count = Factory::where('company_id', '=', $factory->company_id)->count();
        $factory_histories = FactoryHistory::where('factory_id','=', $id)->orderBy('regist_year_id', 'asc')->get();
        $discharges_count = Discharge::where('factory_id', '=', $id)->count();
        $discharges = Discharge::where('factory_id', '=', $id)->orderBy('regist_year_id', 'asc')->get();

        return view('factory.report', compact('years','factory','factory_count', 'factory_histories','discharges', 'discharges_count'));
    }
}
