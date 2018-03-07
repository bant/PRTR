<?php

namespace App\Http\Controllers;

use App\Factory;
use App\FactoryHistory;
use App\Discharge;
use App\RegistYear;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
   /**
    * 工場の届出情報リストの表示
    */
    public function ListByFactory($id)
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

        return view('report.ListByFactory', compact('years','factory','factory_count', 'factory_histories','discharges', 'discharges_count'));
/*


        if ($factory->company->image_file != '')
        {
            $exists = Storage::disk('public')->exists("/uploads/" . $factory->company->image_file );
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

        dd($id);
        $query = Discharge::query();
        $query->where('factory_id', '=', $id);
        
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

        return view('report.ListByFactory');
  //    return view('report.ListByFactory');
*/
    }
}
