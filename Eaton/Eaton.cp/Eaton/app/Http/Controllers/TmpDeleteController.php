<?php

namespace App\Http\Controllers;
use Illminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\AddSchedule;
use Request;

class TmpDeleteController extends Controller
{
    function deleteTmp(Request $request){
        $checked = Request::input('checked',[]);
        $tableName = Request::input('tableType');
        // dd($tableName);
        foreach ((array)$checked as $id) {
             \DB::table($tableName)->where("id",$id)->delete();
        }
        // $alert = "<script type='text/javascript'>alert('滅びのバーストストリーム！！！！');</script>";
        // echo $alert;
        // echo "<script type='text/javascript'>window.close();</script>";
        return back();
    }
    
}
