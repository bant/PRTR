<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanyHistory;
use App\Discharge;
use App\Factory;
use App\FactoryHistory;
use App\Pref;
use App\RegistYear;
use App\PrtrCo2;

use Carbon\Carbon; // 日付操作
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * 
     */
    public function search(Request $request)
    {
        $company_prefs = Pref::all()->pluck('name','id');
        $company_prefs->prepend('全都道府県', 0);    // 最初に追加
    
        return view('company.search', compact('company_prefs'));
    }

    /**
     * 
     */
    public function list(Request $request)
    {
        // inputs
        $inputs = $request->all();

        $company_name = isset($inputs['company_name']) ? $inputs['company_name'] : null;
        $company_pref_id = isset($inputs['company_pref_id']) ? $inputs['company_pref_id'] : 0;
        $company_city = isset($inputs['company_city']) ? $inputs['company_city'] : null;
        $company_address = isset($inputs['company_address']) ? $inputs['company_address'] : null;

        $company_prefs = Pref::all()->pluck('name','id');
        $company_prefs->prepend('全都道府県', 0);    // 最初に追加

        // 検索用のデータを作成
        $years = RegistYear::all()->pluck('name','id');
        $years->prepend('全年度', 0);    // 最初に追加

        // 問い合わせSQLを構築
        $query = Company::query();
        if (!is_null($company_name))
        {
            $query->where('name','like', "%$company_name%");
        }
        if ($company_pref_id != '0')
        {
            $query->where('pref_id', '=', $company_pref_id);
        }
        if (!is_null($company_city))
        {
            $query->where('city','like', "%$company_city%");
        }
        if (!is_null($company_address))
        {
            $query->where('address','like', "%$company_address%");
        }
        $query->orderBy('pref_id', 'asc');
        $query->distinct('name');
        $company_count = $query->count();
        $companies = $query->paginate(10);

        $pagement_params =  $inputs;
        unset($pagement_params['_token']);

        return view('company.list', compact('company_prefs', 'years','inputs','companies','company_count','pagement_params'));
    }

    /**
     * 会社リスト
     */
    public function factories(Request $request)
    {
        // inputs
        $inputs = $request->all();

        $id = isset($inputs['id']) ? $inputs['id'] : 0;     // factory id

        // factory_idが設定されてない場合アボート
        if ($id == 0)
        {
            abort('404');
        }

        $company = Company::find($id);
        if($company == null)
        {
            abort('404');
        }

        $factories_count = Factory::where('company_id', $id)->count();
        $factories = Factory::where('company_id', $id)->get();

        $prtr_co2 = PrtrCo2::where('prtr_company_id', '=', $id)->first();

        return view('company.factories', compact('company','factories_count','factories', 'prtr_co2'));
    }

    /**
     * 届出情報
     */
    public function factory_report(Request $request)
    {

        // inputs
        $inputs = $request->all();

        $id = isset($inputs['id']) ? $inputs['id'] : 0;     // factory id
        $chemical_name = isset($inputs['chemical_name']) ? $inputs['chemical_name'] : null;
        $regist_year = isset($inputs['regist_year']) ? $inputs['regist_year'] : 0;

        // factory_idが設定されてない場合アボート
        if ($id == 0)
        {
            abort('404');
        }
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

        $query = Discharge::query();
        $query->where('factory_id', '=', $id);
        if (!is_null($chemical_name))
        {
            $query->join('ja_chemical','ja_chemical.id','=','ja_discharge.chemical_id');
            $query->where('ja_chemical.name','like', "%$chemical_name%");
        }
        if ($regist_year != 0)
        {
            $query->where('ja_discharge.regist_year_id', '=', $regist_year);
        }

        $discharge_count = $query->count();
        $discharges = $query->orderBy('regist_year_id', 'asc')->paginate(10);

        // 検索用のデータを作成
        $years = RegistYear::all()->pluck('name','id');
        $years->prepend('全年度', 0);    // 最初に追加

        $pagement_params =  $inputs;
        unset($pagement_params['_token']);

        return view('company.factory_report', compact('company', 'factory', 'factories_count', 'factory_histories', 'discharge_count','discharges', 'years', 'pagement_params'));
    }
}
