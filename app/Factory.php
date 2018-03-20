<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factory extends Model
{
    /**
     * モデルに関連付けるデータベースのテーブルを指定
     *
     * @var string
     */
    protected $table = 'ja_factory';

     /**
     * createメソッド利用時に、入力を受け付けないカラムの指定
     *
     * @var array
     */
    //timestamps利用しない
    public $timestamps = false;

     /**
     * Get the Factory's name.
     *
     * @param  string  $value
     * @return string
     */
    public function getNameAttribute($value)
    {
        return mb_strimwidth($value, 0, 24, "..");
    }

    // 親会社は一社だけ
    public function company()
    {
        return $this->belongsTo('App\Company','company_id');
    }


    public function pref()
    {
        return $this->belongsTo('App\Pref','pref_id');
    }

    
    public function regist_year()
    {
        return $this->belongsTo('App\RegistYear','regist_year_id');
    }


    public function factory_business_type()
    {
        return $this->belongsTo('App\FactoryBusinessType', 'id', 'factory_id');
    }
   
    public function factory_history()
    {
        return $this->belongsTo('App\FactoryHistory','factory_id','id');
    }

    public function getBusinessTypeName()
    {
        $factory_business_type = \App\FactoryBusinessType::where('factory_id', '=', $this->id)->first();
        $business_type = \App\BusinessType::where('id', '=', $factory_business_type->business_type_id)->first();
        return $business_type->name;
    }


    public function getAverageEmployee()
    {
        $factory_historys = \App\FactoryHistory::where('factory_id', '=',$this->id)->get();
        $employee = 0;
        $count = 0;

        foreach($factory_historys as $factory_history)
        {
            $employee += $factory_history->employee;
            $count +=1;     
        }
        
        if ($count != 0) {
            return round($employee/$count);
        }
        else {
            return 0;
        } 
    }

    public function getAverageReportCount()
    {
        $factory_historys = \App\FactoryHistory::where('factory_id', '=',$this->id)->get();
        $report_count = 0;
        $count = 0;

        foreach($factory_historys as $factory_history)
        {
            $report_count += $factory_history->report_count;
            $count +=1;     
        }
        
        if ($count!=0) {
            return round($report_count/$count);
        }
        else {
            return 0;
        }
    }

    public function PostNoConvert()
    {
        return "〒".substr($this->post_no, 0, 3) . "-" . substr($this->post_no, 3, 4);
    }

    public function getOldName()
    {
        $factory_history = \App\FactoryHistory::where('factory_id', $this->id)->orderBy('regist_year_id', 'desc')->first();

        return ($factory_history->name != $this->name) ? $factory_history->name : "-";
    }
}
