<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FactoryBusinessType extends Model
{
    /**
     * モデルに関連付けるデータベースのテーブルを指定
     *
     * @var string
     */
    protected $table = 'ja_factory_business_type';

     /**
     * createメソッド利用時に、入力を受け付けないカラムの指定
     *
     * @var array
     */

         //timestamps利用しない
    public $timestamps = false;

    

}
