<?php

namespace App\Http\Controllers;

use App\Factory;
use App\FactoryBusinessType;
use App\Pref;
use Carbon\Carbon; // 日付操作
use Illuminate\Http\Request;

class FactoryController extends Controller
{
    /**
     * 
     */
    public function find(Request $request)
    {
        $name = '';
        $is_old_name = '';
        $factory_business_types = FactoryBusinessType::all()->pluck('name','id');
        $prefs = Pref::all()->pluck('name','id');
        $prefs->prepend('選択してください', 0);    // 最初に追加
        $city = '';
        $address = '';
        $copyright_year = Carbon::now()->format('Y');
    
        return view('factory.find', compact('name','is_old_name','factory_business_types','prefs','city','address','copyright_year'));
    }
}
