<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ChemicalType;

class Chemical extends Model
{
    /**
     * モデルに関連付けるデータベースのテーブルを指定
     *
     * @var string
     */
    protected $table = 'ja_chemical';

     /**
     * createメソッド利用時に、入力を受け付けないカラムの指定
     *
     * @var array
     */

   /**
     * Get the chemical's name.
     *
     * @param  string  $value
     * @return string
     */
    public function getNameAttribute($value)
    {
        return mb_strimwidth($value, 0, 30, "..");
    }



   /**
     * Get the chemical's alias.
     *
     * @param  string  $value
     * @return string
     */
    public function getAliasAttribute($value)
    {
        return mb_strimwidth($value, 0, 30, "..");
    }


    /**
     * 薬品種別名を取得
     */
    public function chemical_type()
    {
        return $this->belongsTo('App\ChemicalType','chemical_type_id');
    }

    public function old_chemical_type()
    {
        return $this->belongsTo('App\ChemicalType','old_chemical_type_id');
    }

//    public function 

}
