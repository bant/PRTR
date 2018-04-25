<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyHistory extends Model
{
    /**
     * モデルに関連付けるデータベースのテーブルを指定
     *
     * @var string
     */
    protected $table = 'ja_company_history';

     /**
     * createメソッド利用時に、入力を受け付けないカラムの指定
     *
     * @var array
     */
    //timestamps利用しない
    public $timestamps = false;

    /**
     * 会社テーブルと関連付け
     */
    public function companies()
    {
        return $this->belongsTo('App\Company');
    }
}
