<?php

namespace App\Http\Controllers;

use App\Company;
use App\Pref;
use Carbon\Carbon; // 日付操作
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * 
     */
    public function find(Request $request)
    {
        $company_prefs = Pref::all()->pluck('name','id');
        $company_prefs->prepend('全都道府県', 0);    // 最初に追加
    
        return view('company.find', compact('company_prefs'));
    }

    /**
     * 
     */
    public function search(Request $request)
    {
        // inputs
        $inputs = $request->all();
        //dd($inputs);
        $name = $inputs['name'];
        $old_name = isset($inputs['is_old_name']) ? $inputs['name'] : null;
        $business_type_id = $inputs['business_type_id'];
        $pref_id = $inputs['pref_id'];
        $city = $inputs['city'];
        $address = $inputs['address'];

        $business_types = BusinessType::all()->pluck('name','id');
        $business_types->prepend('全業種', 0);    // 最初に追加
        $prefs = Pref::all()->pluck('name','id');
        $prefs->prepend('全都道府県', 0);    // 最初に追加

        $query = Factory::query();
        $query->join('ja_factory_business_type', 'ja_factory.id', '=', 'ja_factory_business_type.factory_id');
        if (!is_null($name))
        {
            $query->where('ja_factory.name','like', '%'.$name.'%');
        }
        
        if ($business_type_id != '0')
        {
            $query->where('ja_factory_business_type.business_type_id', $business_type_id);
        }

        if ($pref_id != '0')
        {
            $query->where('ja_factory.pref_id', $pref_id);
        }

        if (!is_null($city))
        {
            $query->where('ja_factory.city', 'like', '%'. $city. '%');
        }

        if (!is_null($address))
        {
            $query->where('ja_factory.address', 'like', '%'. $address. '%');
        }
        $query->orderBy('ja_factory.pref_id', 'asc');
        $query->distinct('ja_factory.name');
        $all_count = $query->count();
        $factorys = $query->paginate(10);

        return view('factory.list', compact('business_types','prefs','inputs','factorys','all_count'));




    }

}
