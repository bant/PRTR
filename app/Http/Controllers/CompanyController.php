<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanyHistory;
use App\Discharge;
use App\Factory;
use App\FactoryHistory;
use App\Pref;
use App\RegistYear;

use Carbon\Carbon; // 日付操作
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * 
     */
    public function search(Request $request)
    {
        $prefs = Pref::all()->pluck('name','id');
        $prefs->prepend('全都道府県', 0);    // 最初に追加
    
        return view('company.search', compact('prefs'));
    }

    /**
     * 
     */
    public function list(Request $request)
    {
        // inputs
        $inputs = $request->all();

        $name = isset($inputs['name']) ? $inputs['name'] : null;
        $pref_id = isset($inputs['pref_id']) ? $inputs['pref_id'] : 0;
        $city = isset($inputs['city']) ? $inputs['city'] : null;
        $address = isset($inputs['address']) ? $inputs['address'] : null;

        $prefs = Pref::all()->pluck('name','id');
        $prefs->prepend('全都道府県', 0);    // 最初に追加

        // 問い合わせSQLを構築
        $query = Company::query();
        if (!is_null($name))
        {
            $query->where('name','like', "'%$name%");
        }
        if ($pref_id != '0')
        {
            $query->where('pref_id', '=', $pref_id);
        }
        if (!is_null($city))
        {
            $query->where('city','like', "%$city%");
        }
        if (!is_null($address))
        {
            $query->where('address','like', "%$address%");
        }
        $query->orderBy('pref_id', 'asc');
        $query->distinct('name');
        $all_count = $query->count();
        $companies = $query->paginate(10);

        $pagement_params =  $inputs;
        unset($pagement_params['_token']);

        return view('company.list', compact('prefs','inputs','companies','all_count','pagement_params'));
    }

    /**
     * 会社リスト
     */
    public function factories($id)
    {
        $company = Company::find($id);
        if($company == null)
        {
            abort('404');
        }

        $factories_count = Factory::where('company_id', $id)->count();
        $factories = Factory::where('company_id', $id)->get();

        return view('company.factories', compact('company','factories_count','factories'));
    }

    /**
     * 届出情報
     */
    public function report($id)
    {
        $factory = Factory::find($id);
        if ($factory == null)
        {
            abort(404);
        }

        $company = Company::find($factory->company_id);
        if ($company == null)
        {
            abort(404);
        }

        $factories_count = Factory::where('company_id', '=',$id)->count();
        $factory_histories = FactoryHistory::where('factory_id', '=', $id)->orderBy('regist_year_id', 'asc')->get();
        $discharges = Discharge::where('factory_id', '=', $id)->orderBy('regist_year_id', 'asc')->get();

        // 検索用のデータを作成
        $years = RegistYear::all()->pluck('name','id');
        $years->prepend('全年度', 0);    // 最初に追加

        return view('company.report', compact('company', 'factory', 'factories_count', 'factory_histories', 'discharges', 'years'));
    }
}
