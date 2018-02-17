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

    public function pref()
    {
        return $this->belongsTo('App\Pref','pref_id');
    }

    public function regist_year()
    {
        return $this->belongsTo('App\RegistYear','regist_year_id');
    }

    public function PostNoConvert()
    {
        return "〒".substr($this->post_no, 0, 3) . "-" . substr($this->post_no, 3, 4);
    }


}
