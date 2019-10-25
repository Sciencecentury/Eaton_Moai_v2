<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

// --------------------------------------------------------------------------------------------------
// 設定された開始日時、終了日時等が論理的に正しいかを判定するクラス
// --------------------------------------------------------------------------------------------------
class TimeJudgment extends Model{
    // カレンダーを表示するメソッド。引数として年・月・日を持ってくる
    public static function timeJudg($request){

        // 呼びだしもとに返却するフラグ
        $result = true;

        // オブジェクト型を日付型に変換
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        // dd($endDate);

        // 開始と終了の日付や時刻が論理的に正しいかどうかを判定する
        // 終了の日付が開始の日付以上であるかどうか
        if($endDate -> gte($startDate)){
            // dd($startDate);
            // 日付の設定が正しかった場合、時間の設定が正しいかどうか判定するために、開始日時と終了日時が同じかどうかを判定する
            if($endDate -> eq($startDate)){
                // 開始と終了の日付が等しかった場合、終了の時間が論理的に正しいかどうかを判定する。等しいなら、開始と終了の時間を取得する
                $startTime = Carbon::parse($request->start_time);
                $endTime = Carbon::parse($request->end_time);

                // 比較して、終了時刻の方が大きいまたは片方がnullなら論理的に正しいと判断
                if($endTime -> gte($startTime) || empty($startTime) || empty($endTime)){
                    $result = true;                
                }else {
                    $result = false;
                }
            }else {
                $result = true;
            }
        }else {
            $result = false;
        }
        return $result;
    }
}
