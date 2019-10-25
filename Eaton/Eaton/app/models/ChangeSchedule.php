<?php

namespace App\Models;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ChangeSchedule extends Model
{
    public static function changeStore(Request $request)
    {
        $getId = $request -> id;
        $intId = intval($getId);
		  	$user = Auth::user();

      //if(strcmp($request->title, "[ |　]+ ")){
        //    $reTitle = "（タイトルなし）";
     // }else{
       //     $reTitle = $request->title;
    //  }

        \DB::table('tasks')
            ->where('id',$request->id)            
            ->update([
                'userName' => $request->userName,
                'title' => $request->title,
                'class' => $request->class,
                'place' => $request->place,
                'start_date' => $request->start_date,
                'start_time' => $request->start_time,
                'end_date' => $request->end_date,
                'end_time' => $request->end_time,
		'remarks' => $request->remarks,
		'last_editor' => $user -> name,
                ]);

            }
}
