<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\AddSchedule;


class DeleteTaskController extends Controller{
    public function deleteTask(Request $request){
        // $intId = intval($taskId);
        
        $deletval = intval($request->taskId);
        // dd($test);
        \DB::table('tasks')->where('id', '=', $deletval)->delete();
        return redirect('');
    }
}
