<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

// --------------------------------------------------------------------------------------------------
// dbから予定を持ってくるクラス
// --------------------------------------------------------------------------------------------------
class GetPlans extends Model{
    public static function getPlans($weekStart){
        // 予定の日付とタイトルを入れるための多次元配列を宣言
        $plans = array();
        
        // dbにアクセスして指定された一週間分の予定のタイトルと日付を持ってくる
        for($roopCount = 0; $roopCount < 7; $roopCount++, $weekStart -> addDay()){

            // 日付型は使い勝手が悪いので文字列型に変更する
            $weekStartStr = substr($weekStart, 0 ,10);

            // ヒットする予定があれば持ってくる
            $plan = DB::table('tasks') -> select('*') -> where('start_date', '=', "{$weekStartStr}") -> get();            

            if($plan != null){
                $plans[$weekStartStr] = $plan;
            }
        }
       return $plans;
    }
}