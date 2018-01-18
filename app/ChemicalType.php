<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChemicalType extends Model
{
    /**
     * モデルに関連付けるデータベースのテーブルを指定
     *
     * @var string
     */
    protected $table = 'ja_chemical_type';

     /**
     * createメソッド利用時に、入力を受け付けないカラムの指定
     *
     * @var array
     */

}
