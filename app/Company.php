<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * モデルに関連付けるデータベースのテーブルを指定
     *
     * @var string
     */
    protected $table = 'ja_company';

     /**
     * createメソッド利用時に、入力を受け付けないカラムの指定
     *
     * @var array
     */

     /**
     * Get the Company's name.
     *
     * @param  string  $value
     * @return string
     */
    public function getNameAttribute($value)
    {
        return mb_strimwidth($value, 0, 128, "..");
    }

    /**
     * 都道府県テーブル関連付け
     */
    public function pref()
    {
        return $this->hasOne('App\Pref', 'id', 'pref_id');
    }

    /**
     * 登録年度テーブル関連付け
     */
    public function regist_year()
    {
        return $this->hasOne('App\RegistYear', 'id', 'regist_year_id');
    }

    /**
     * 工場テーブル関連付け
     */
    public function factories()
    {
//        return $this->hasMany('App\Factory','company_id', 'id');
        return $this->hasMany('App\Factory');
    }
    
//    public function company_history()
    public function company_historries()
    {
        return $this->hasMany('App\CompanyHistory','company_id');
    }

    public function PostNoConvert()
    {
        return "〒".substr($this->post_no, 0, 3) . "-" . substr($this->post_no, 3, 4);
    }

    public function getFactoryCount()
    {
        $factory_count = \App\Factory::where('company_id',$this->id)->count();

        return $factory_count;
    }

    public function getOldName()
    {
        $company_history = \App\CompanyHistory::where('company_id', $this->id)->orderBy('regist_year_id', 'desc')->first();

        return ($company_history->name != $this->name) ? $company_history->name : "-";
    }
}
