<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    /**
     * モデルに関連付けるデータベースのテーブルを指定
     *
     * @var string
     */
    protected $table = 'ja_unit';

     /**
     * createメソッド利用時に、入力を受け付けないカラムの指定
     *
     * @var array
     */
    //timestamps利用しない
    public $timestamps = false;

    

}
