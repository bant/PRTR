<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FactoryHistory extends Model
{
    /**
     * モデルに関連付けるデータベースのテーブルを指定
     *
     * @var string
     */
    protected $table = 'ja_factory_history';

     /**
     * createメソッド利用時に、入力を受け付けないカラムの指定
     *
     * @var array
     */

         //timestamps利用しない
    public $timestamps = false;

    public function pref()
    {
        return $this->belongsTo('App\Pref','pref_id');
    }

    public function PostNoConvert()
    {
        return "〒".substr($this->post_no, 0, 3) . "-" . substr($this->post_no, 3, 4);
    }
}
