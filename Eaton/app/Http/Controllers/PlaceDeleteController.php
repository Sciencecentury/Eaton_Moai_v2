<?php

namespace App\Http\Controllers;

use Request;

class PlaceDeleteController extends Controller
{
    function deletePlace(){
        $checked = Request::input('checked',[]);
        foreach ((array)$checked as $id) {
             \DB::table('places')->where("id",$id)->delete();
        }
        $alert = "<script type='text/javascript'>alert('滅びのバーストストリーム！！！！');</script>";
        echo $alert;
        echo "<script type='text/javascript'>window.close();</script>";
    }
}
