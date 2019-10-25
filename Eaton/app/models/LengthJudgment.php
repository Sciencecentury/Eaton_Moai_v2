<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


// --------------------------------------------------------------------------------------------------
// 入力された文字列の長さが既定の長さ以下かを判定するモデル
// --------------------------------------------------------------------------------------------------
class LengthJudgment extends Model{
    public static function lengthJudg($request){
        // 呼びだしもとに返却するフラグ
        $result = true;

        // 入力された文字列を取得する
        $inputLength = $request;

        // 入力されたのがアルファベットか日本語かを判定する
        if (preg_match('/^[a-zA-Z0-9]+$/',$inputLength)){
            // アルファベットだった場合
            if(strlen($inputLength) <= 12){
                $result = true;
            }else {
                $result = false;
            }
        }else {
            // アルファベットではなかった場合
            if(mb_strlen($inputLength, 'UTF-8') <= 12){
                $result = true;
            }else {
                $result = false;
            }
        }
        return $result;
    }
}
