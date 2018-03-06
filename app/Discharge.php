<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discharge extends Model
{
    /**
     * モデルに関連付けるデータベースのテーブルを指定
     *
     * @var string
     */
    protected $table = 'ja_discharge';

    public function regist_year()
    {
        return $this->belongsTo('App\RegistYear','regist_year_id');
    }

}
