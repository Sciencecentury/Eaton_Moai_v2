<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

// --------------------------------------------------------------------------------------------------
// 今月の(指定された)1ヶ月カレンダーを作成するクラス
// --------------------------------------------------------------------------------------------------
class OneMonth extends Model{
    public static function getOneMonth($year, $month){

        $dateStr = sprintf('%04d-%02d-01', $year, $month);
        $date = new Carbon($dateStr);

        // カレンダーを四角形にするため、前月となる左上の隙間用のデータを入れるためずらす
        $date->subDay($date->dayOfWeek);

        // 同上。右下の隙間のための計算。
        $count = 31 + $date->dayOfWeek;
        $count = ceil($count / 7) * 7;
        $oneMonthCalendar = [];

        for ($i = 0; $i < $count; $i++, $date->addDay()) {
            // copyしないと全部同じオブジェクトを入れてしまうことになる
            $oneMonthCalendar[] = $date->copy();
        }
        $test = $oneMonthCalendar[1];
        return $test;
        // return $oneMonthCalendar[2];
    }
}