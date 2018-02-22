<?php

namespace App\Http\Controllers;

use App\BusinessType;
use App\Factory;
use App\FactoryBusinessType;
use App\Pref;
use Carbon\Carbon; // 日付操作
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FactoryController extends Controller
{
    /**
     * 
     */
    public function find(Request $request)
    {
        $business_types = BusinessType::all()->pluck('name','id');
        $business_types->prepend('全業種', 0);    // 最初に追加
        $prefs = Pref::all()->pluck('name','id');
        $prefs->prepend('全都道府県', 0);    // 最初に追加
    
        return view('factory.find', compact('business_types','prefs'));
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
        $factorys = $query->paginate(10);

//        dd($factorys);
        return view('factory.list', compact('inputs','factorys'));


        /*
        $query = Factory::query();
        if ($business_type_id!='0')
        {
            $query->join('ja_factory_business_type', 'ja_factory.id', '=', 'ja_factory_business_type.factory_id');
            $query->where('ja_factory_business_type.business_type_id', $business_type_id);   
        }

        $query->join('ja_factory_history', 'ja_factory.id', '=', 'ja_factory_history.factory_id');
        if (!is_null($name))
        {

            if (!is_null($old_name))
            {
                $query->where('ja_factory_history.name','like', '%'.$old_name.'%');
            }
            else
            {
                $query->where('ja_factory.name','like', '%'.$name.'%');
            }
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
        $query->distinct('*');
        $query->orderBy('ja_factory.pref_id', 'asc');

        $factorys = $query->paginate(10);

        return view('factory.list', compact('inputs','factorys'));
*/
/*
        $factorys = Factory::select()
        ->when($business_type_id, function ($query) use ($business_type_id) {
            // inner join...
            $query->join('ja_factory_business_type', 'ja_factory.id', '=', 'ja_factory_business_type.factory_id');
            return $query->where('ja_factory_business_type.business_type_id', $business_type_id);
        })
        ->when(($name and !$is_old_name), function ($query) use ($name) {
            return $query->where('ja_factory.name','like', '%'.$name.'%');
        })
        ->when(($name and $is_old_name), function ($query) use ($name) {
            $query->join('ja_factory_history', 'ja_factory.id', '=', 'ja_factory_history.factory_id');
            return $query->where('ja_factory_history.name','like', '%'.$name.'%');
        })
        ->when($pref_id != "0", function ($query) use ($pref_id) {
            return $query->where('ja_factory.pref_id',$pref_id);
        })
        ->when($city, function ($query) use ($city) {
            return $query->where('ja_factory.city','like', '%'.$city.'%');
        })
        ->when($address, function ($query) use ($address) {
            return $query->where('ja_factory.address','like', '%'.$address.'%');
        })
        ->distinct('ja_factory.id')
        ->orderBy('ja_factory.pref_id', 'asc')
        ->toSql();
//        ->paginate(10);
        dd($factorys);
        return view('factory.list', compact('inputs','factorys'));
        */
    }
}
