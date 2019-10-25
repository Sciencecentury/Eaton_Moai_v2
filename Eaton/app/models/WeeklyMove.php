<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

// --------------------------------------------------------------------------------------------------
//週移動するクラス
// --------------------------------------------------------------------------------------------------
class WeeklyMove extends Model{
    public static function weekMove($move, $nowDisplay){

        // 受け取った文字列型の日付をdate型にする
        $year = substr($nowDisplay, 0, 4);
        $month = substr($nowDisplay, 5, 2);
        $day = substr($nowDisplay, 8, 2);
        
        $date = Carbon::create(
            $year, 
            $month, 
            $day
        );
        
        // moveの値によって日付を戻すのか進めるのか決める
        switch ($move) {
            case "forward" :
                $date -> addDays(7); 
                for ($roopCount = 0; $roopCount < 7; $roopCount++, $date -> addDay()) {
                    $dates[] = $date -> copy();
                }        
                break;
            case "back" :
                $date -> subDays(7); 
                for ($roopCount = 0; $roopCount < 7; $roopCount++, $date -> addDay()) {
                    $dates[] = $date -> copy();
                }
               break;
            default :
                $date -> addDays(7);
                for ($roopCount = 0; $roopCount < 7; $roopCount++, $date -> addDay()) {
                    $dates[] = $date -> copy();
                }     
        }
        return $dates;
    }
}
