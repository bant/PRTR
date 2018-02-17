<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessType extends Model
{
    /**
     * モデルに関連付けるデータベースのテーブルを指定
     *
     * @var string
     */
    protected $table = 'ja_business_type';

     /**
     * createメソッド利用時に、入力を受け付けないカラムの指定
     *
     * @var array
     */

     /**
     * Get the BusinessType's name.
     *
     * @param  string  $value
     * @return string
     */
    public function getNameAttribute($value)
    {
        return mb_strimwidth($value, 0, 24, "..");
    }

}
