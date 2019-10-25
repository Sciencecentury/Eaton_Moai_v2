<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Validator;
// --------------------------------------------------------------------------------------------------
//バリテーションをするクラス
// --------------------------------------------------------------------------------------------------
class Vali extends Model{
    public static function vali($request){
	//タイトルの文字数が12文字以下かを判定
        $request -> validate ([
                'title' => 'max : 12',
        ]);

	//備考が10文字以下かを判定
        $request -> validate ([
                'remarks' => 'max : 10',
        ]);

	//設定時間が正しい値を判定
       $end_date = $request -> end_date;
       $end_time = $request -> end_time;
       $start_date = $request -> start_date;
       $start_time = $request -> start_time;

       $request -> validate ([
          'end_date' => 'after_or_equal :start_date',
       ]);

       if(!strcmp($end_date, $start_date) && !empty($start_time) && !empty($end_time)){
          $request -> validate ([
             'end_time' => 'after_or_equal :start_time',
          ]);
       }
    }
}
