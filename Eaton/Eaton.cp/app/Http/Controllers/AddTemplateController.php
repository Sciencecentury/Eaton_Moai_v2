<?php
/*--------------------------------------------------------------------------
// 送られてきたテンプレートをdbに追加する
--------------------------------------------------------------------------*/
namespace App\Http\Controllers;
// use Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Validator;

class AddTemplateController extends Controller{
    function addTemplate(Request $request){
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

		//遷移元の画面の判定(予定追加か予定編集か)
		if($origin == "add"){
			return back();
		}else{
		//	$changeTask = $request -> changeTask;
			return back();
		//	$origin = "temp";
        //	return view('changeEvent',['changeTask' => $changeTask, 'origin' => $origin]);
	 	}
	}
}
