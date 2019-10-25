<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

// --------------------------------------------------------------------------------------------------
// 一週間カレンダーを作成するクラス
// --------------------------------------------------------------------------------------------------

class OneWeek extends Model{
    // カレンダーを表示するメソッド。引数として年・月・日を持ってくる
    public static function getCalendarDates($year, $month, $day){

        // 現在日付を-で区切る形で、日本のタイムゾーンに従って取得
        $date = Carbon::parse("$year-$month-$day") -> locale('ja_JP');

        // 現在の週の初日( = 日曜)を取得(2019/7/1なら6/30が入る)
        $date -> startOfWeek();
        
        // 現在の日時が属する一週間だけ配列に入れる
        for ($roopCount = 0; $roopCount < 7; $roopCount++, $date -> addDay()) {
            $dates[] = $date -> copy();            
        }
        
        // 呼び出し元のindexControllerに値(今週一週間分の日付の配列と今週の始まりの日付)を返却する
        return $dates;
    }
}
