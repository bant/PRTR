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
        $factory_business_types = BusinessType::all()->pluck('name','id');
        $factory_business_types->prepend('全業種', 0);    // 最初に追加
        $factory_prefs = Pref::all()->pluck('name','id');
        $factory_prefs->prepend('全都道府県', 0);    // 最初に追加
    
        return view('factory.search', compact('factory_business_types','factory_prefs'));
    }


    /**
     * 工場リスト
     */
    public function list(Request $request)
    {
        // inputs
        $inputs = $request->all();
       
        $factory_name = isset($inputs['factory_name']) ? $inputs['factory_name'] : null;
        $factory_business_type_id = isset($inputs['factory_business_type_id']) ? $inputs['factory_business_type_id'] : 0;
        $factory_pref_id = isset($inputs['factory_pref_id']) ? $inputs['factory_pref_id'] : 0;
        $factory_city = isset($inputs['factory_city']) ? $inputs['factory_city'] : null;
        $factory_address = isset($inputs['factory_address']) ? $inputs['factory_address'] : null;

        $factory_business_types = BusinessType::all()->pluck('name','id');
        $factory_business_types->prepend('全業種', 0);      // 最初に追加
        $factory_prefs = Pref::all()->pluck('name','id');
        $factory_prefs->prepend('全都道府県', 0);           // 最初に追加

        $query = Factory::query();
        if (!is_null($factory_name))
        {
            $query->where('name','like', "%$factory_name%");
        }
        
        if ($factory_business_type_id != '0')
        {
            $query->join('ja_factory_business_type','ja_factory_business_type.factory_id','=','ja_factory.id');
            $query->where('business_type_id', '=',$factory_business_type_id);
        }

        if ($factory_pref_id != '0')
        {
            $query->where('pref_id', '=',$factory_pref_id);
        }

        if (!is_null($factory_city))
        {
            $query->where('city', 'like', "%$factory_city%");
        }

        if (!is_null($factory_address))
        {
            $query->where('address', 'like', "%$factory_address%");
        }
        $query->orderBy('pref_id', 'asc');
        $query->distinct('name');
        $all_count = $query->count();
        $factories = $query->paginate(10);

        $pagement_params =  $inputs;
        unset($pagement_params['_token']);

        return view('factory.list', compact('factory_business_types', 'factory_prefs', 'factories', 'all_count', 'pagement_params'));
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
