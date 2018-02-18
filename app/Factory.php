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
        return $this->belongsTo('App\FactoryBusinessType','factory_id','factory_id');
    }


    public function PostNoConvert()
    {
        return "〒".substr($this->post_no, 0, 3) . "-" . substr($this->post_no, 3, 4);
    }

}
