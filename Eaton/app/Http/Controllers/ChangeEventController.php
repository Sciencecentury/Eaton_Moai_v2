<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ChangeSchedule;
use Illminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Validator;
/*--------------------------------------------------------------------------
予定の編集に関するコントローラ
--------------------------------------------------------------------------*/
class ChangeEventController extends Controller
{
/*--------------------------------------------------------------------------*/
// 予定変更の画面を表示するメソッド
/*--------------------------------------------------------------------------*/
    public function changeWindow (Request $request) {
        // 持ってきたタスクのidを変数に保存
		  $origin = $request -> origin;
        $taskId = $request->taskId;
        $intId = intval($taskId);
        // dbからidに関連する情報を持ってくる
        $changeTask = \DB::table('tasks') -> select('*') -> where('id', '=', $intId) -> get();      
		 // dd($intId);
        return view('changeEvent',['changeTask' => $changeTask, 'origin' => $origin]);
    }

/*--------------------------------------------------------------------------*/
// 予定変更の画面を表示するメソッド
/*--------------------------------------------------------------------------*/
    public function changeWindow2 ($jumpId) {
        // 持ってきたタスクのidを変数に保存
        $taskId = $jumpId;
		  $origin = $jumpId;
        $intId = intval($taskId);
        // dbからidに関連する情報を持ってくる
        $changeTask = \DB::table('tasks') -> select('*') -> where('id', '=', $intId) -> get();      

        $id = $changeTask[0]->id;
        $title = $changeTask[0]->title;
        $userName = $changeTask[0]->userName;
        $class = $changeTask[0]->class;
        $place = $changeTask[0]->place ;
        $start_date = $changeTask[0]->start_date;
        $start_time = $changeTask[0]->start_time;
        $end_date = $changeTask[0]->end_date;
        $end_time = $changeTask[0]->end_time;
        $remarks = $changeTask[0]->remarks;
	//	dd($title);
        return view('changeEvent',['id' => $id, 'title' => $title, 'userName' => $userName, 'class' => $class, 'place' => $place, 'start_date' => $start_date, 'start_time' => $start_time, 'end_date' => $end_date, 'end_time' => $end_time, 'remarks' => $remarks, 'origin' => $origin]);
 
//return view('changeEvent',compact('changeTask'));		

   
    //return view('changeEvent',['changeTask' => $changeTask]);
    }
/*-------------------------------------------------------------------------*/
// 編集ボタンを押下した後の処理
/*--------------------------------------------------------------------------*/
	public function changeStore(Request $request){

        $request -> validate ([
                'title' => 'max : 12',
        ]);
	
        $request -> validate ([
                'remarks' => 'max : 200',
        ]);

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

	//	持ってきたタスクのidを取得する
      $taskId = $request->id;
      $intId = intval($taskId);

     // dbからidに関連する情報を持ってくる
      $changeTask = \DB::table('tasks') -> select('*') -> where('id', '=', $intId) -> get();      
		ChangeSchedule::changeStore($request);
      return redirect('');            
   }
/*--------------------------------------------------------------------------*/
/*テンプレートが追加されたときの処理*/
/*--------------------------------------------------------------------------*/
    public function addTemplate(Request $request){
      // newTemp：今回新たに追加したいテンプレート
      $newTemp = $request -> get('addTemp');
      $origin = $request -> get('origin');
		$changeTask = $request -> get('dbData');

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
            //return redirect()->action('ChangeEventController@changeWindow', ['' => $origin]);

   	//予定編集画面に戻る
		$jumpId = $request -> origin;
		//dd($jumpId);
		$this-> changeWindow2($jumpId);
      //$called = app()->make('ChangeEventController');
        return view('changeEvent',['changeTask' => $changeTask, 'origin' => "ndex"]);
     // $called->changeWindow($jumpId);
   }
}

