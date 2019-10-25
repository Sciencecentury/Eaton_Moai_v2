<?php

namespace App\Http\Controllers;
use Request;

class ClassDeleteController extends Controller
{
    function deleteClass(){
        $checked = Request::input('checked',[]);
        foreach ((array)$checked as $id) {
             \DB::table('classes')->where("id",$id)->delete();
        }
        // $alert = "<script type='text/javascript'>alert('滅びのバーストストリーム！！！！');</script>";
        // echo $alert;
        // echo "<script type='text/javascript'>window.close();</script>";
        return back();

    }
}
