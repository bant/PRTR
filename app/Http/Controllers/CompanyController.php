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
        $comapny_prefs = Pref::all()->pluck('name','id');
        $company_prefs->prepend('全都道府県', 0);    // 最初に追加
    
        return view('company.find', compact('company_prefs'));
    }
}
