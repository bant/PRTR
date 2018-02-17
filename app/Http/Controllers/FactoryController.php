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
/*
        // ルール
        $rules = [
            'chemical_no' => 'numeric',
            'old_chemical_no' => 'numeric',
            'cas' => 'numeric',
        ];

        //
        $messages = [
            'chemical_no.numeric' => '化学物質番号は整数で入力してください。',
            'old_chemical_no.numeric' => '旧化学物質番号は整数で入力してください。',
            'cas.numeric' => 'CAS登録番号は整数で入力してください。',
        ];

        // バリデーション
        $validation = \Validator::make($inputs, $rules, $messages);
        // エラーの時

        if($validation->fails())
        {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
*/
        //dd($inputs);
        $name = $inputs['name'];
        $is_old_name = isset($inputs['name']) ? $inputs['name'] : null;
        $business_type_id = $inputs['business_type_id'];
        $pref_id = $inputs['pref_id'];
        $city = $inputs['city'];
        $address = $inputs['address'];

//        $factorys = Factory::select('*')->get();
//         dd($factorys);


        
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
        ->distinct()
        ->orderBy('ja_factory.pref_id', 'desc')
        ->paginate(10);

        /*
        $factorys = DB::table('ja_factory')
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
            ->join('ja_company', 'ja_factory.company_id', '=', 'ja_company.id')
            ->distinct()
            ->orderBy('ja_factory.pref_id', 'desc')
//            ->toSql();
            ->paginate(10);

            //            dd($factorys);
*/
            return view('factory.list', compact('inputs','factorys'));
    }

}
