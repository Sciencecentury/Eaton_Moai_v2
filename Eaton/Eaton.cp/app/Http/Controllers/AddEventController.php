<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\AddSchedule;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\Schema;
/*--------------------------------------------------------------------------*/
/*addEvent.php(カレンダーの画面)にアクセスがあったときに動くコントローラー*/
/*--------------------------------------------------------------------------*/
class AddEventController extends Controller
{
/*--------------------------------------------------------------------------*/
// 予定追加画面への遷移
/*--------------------------------------------------------------------------*/
    public function addEvent(){
        return view('addEvent');
    }
/*--------------------------------------------------------------------------*/
/*予定が追加されたときの処理*/
/*--------------------------------------------------------------------------*/
    public function addStore(Request $request){
        // 予定の文字数の判定をするクラス。上限は12文字なので、12文字以下かどうかを判定する
		$request -> validate ([
			'title' => 'max : 12',
		]);

   	// 日付の判定をするクラス。論理的に正しければdbに保存する
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

		$request -> validate ([
			'remarks' => 'max : 200',
		]);

   	//インスタンスを生成
      $task = new AddSchedule;
      $task -> addStore($request);
      	return redirect('');            
    }
/*--------------------------------------------------------------------------*/
/*テンプレートが追加されたときの処理*/
/*--------------------------------------------------------------------------*/
	 public function addTemplate(Request $request){
      // newTemp：今回新たに追加したいテンプレート
      $newTemp = $request -> get('addTemp');
      $origin = $request -> get('origin');

      // 空白判定。入力された値が空白なら処理を終了する
      $request -> validate ([
          'addTemp' => 'nullable',
      ]);

      //上限は12文字なので、12文字以下かどうかを判定する
      $request -> validate ([
         'addTemp' => 'max : 12',
      ]);

        // 入力されたテンプレートが既に存在する値だった場合も追加しない
        // tableName：新しいテンプレートを追加したいテーブル
        $tableName = $request -> get('type');
        $cname = $request -> get('cname');
        // dbから既存のテンプレートを取得
        $tableContents = \DB::table($tableName) -> select('*')->get();
        // dbの中身がnullなら同値判定をしない
        if(!empty($tableContents)){
            foreach($tableContents as $value){
                $valueOnly = $value->$cname;
               //同じ値ならエラー
                Validator::make(['valueOnly' => $valueOnly, 'newTemp' => $newTemp], [
                  'valueOnly' => 'different:newTemp',
               ])->validate();
            }
        }

      // 空白でもなく存在もしなかった場合追加
      //組追加処理
      if($tableName =="classes"){
         \DB::table($tableName)->insert([
            'class' => $newTemp
          ]);
      }
      //場所追加
      if($tableName =="places"){
          \DB::table($tableName)->insert([
            'place' => $newTemp
           ]);
      }
      //タイトル追加
      if($tableName =="titles"){
          \DB::table($tableName)->insert([
            'title' => $newTemp
           ]);
      }
	//予定追加画面に戻る
   return back();
   }
}

