<?php

namespace App\Http\Controllers;

use App\Factory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DischargeController extends Controller
{
   /**
    * 工場の届出情報リストの表示
    */
    public function ListByFactory(Request $request)
    {
        // inputs
        $inputs = $request->all();

        // 工場が登録されてないときは404
        $factory = Factory::find($input['id']);
        if($factory == null)
        {
            abort('404');
        }

        if ($factory->company->image_file != '')
        {
            $exists = Storage::disk('public')->exists("/uploads/" . $fcatory->company->image_file );
            if ($exists)
            {
                $image_file =  '/uploads/'.$factory->comapny->image_file;
            }
            else
            {
                $image_file =  '/images/default.png';                
            }
        }
        else
        {
            $image_file =  '/images/default.png';            
        }

        $query = Discharge::query();
        $query->where('factory_id', '=', $input['id']);
        
        if ($input['year_id'] != "")
        {
            $query->where('regist_year_id', '=', $input['year_id']);            
        }
        else
        {
            $query->orderBy('regist_year_id', 'desc');
        }


        // 化学部質も含める
        if ($input['chemical_name'] != '')
        {
            $query->join('ja_factory_business_type', 'ja_factory.id', '=', 'ja_factory_business_type.factory_id');
        } 


//            public function store(Request $request)
//            $input = $request->all();
            $fileName = $input['fileName']->getClientOriginalName();



            $path = $request->file('fileName')->storeAs('public',"image/{$fileName}");
        }


            getClientOriginalName
            $store_file =  /uploads/'. $this->factory->getCompany()->getImageFile();
            $image_file_path = url('/uploads/$factory->company->image_file');
        }
        else
        {

        }




        $business_types = BusinessType::all()->pluck('name','id');
        $business_types->prepend('全業種', 0);    // 最初に追加
        $prefs = Pref::all()->pluck('name','id');
        $prefs->prepend('全都道府県', 0);    // 最初に追加
    
        return view('factory.find', compact('business_types','prefs'));
    }
}
