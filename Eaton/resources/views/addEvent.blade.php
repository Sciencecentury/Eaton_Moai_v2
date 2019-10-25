@extends('layout.default')

@section('title', 'カレンダー')

@section('body')


<!--エラー出力-->
@if ($errors -> any())
	<div class= "top_errors_msg">{{$errors -> first('password')}}
		@foreach ($errors -> all() as $error)
			{{$error}}<br>
		@endforeach
	</div>
@endif

<div class = "addEventBackColor">
    <h1 class = "addEventMainTitle">予定の追加</h1>
    <div class = "changeEvent_p">
        <p>追加する予定のタイトル</p>
    </div>
<script>
//Activation();
</script>

<!-- -------------------------------------------------------------------------- -->
<!-- タイトルを入力 -->
<!-- -------------------------------------------------------------------------- -->
    <form action = "{{route('eventAdd')}}" method = "post">
        @csrf
	    <div class = "Event_labels"> 
            <!-- <dbアクセス -->
            @php
                $titles = \DB::table('titles')->get();
	    @endphp

		
           タイトル<font color="red" size="3px">※</font><input list = "testList" class = "Event_add_label_title" name = "title" required autofocus value = "{{old('title')}}">
            <datalist id="testList" autocomplete="off">
                @foreach ($titles as $title)
                    <option value='{{$title->title}}'>{{$title->title}}</option>
                @endforeach
	    </datalist>		 
            <!-- テンプレ追加のボタン -->
            <input type = "button" class = "addPopupButton" value = " + " onClick = "deleteTextSubmit();"><br>

<!-- -------------------------------------------------------------------------- -->
<!-- 組を入力 -->
<!-- --------------------------------------------------------------------------* -->
            <!-- dbアクセス -->
            @php
                $classes = \DB::table('classes')->get();
            @endphp
        
            組<select name="class" class="Event_add_label_class">
                @foreach ($classes as $class)
                    <option value='{{$class->class}}' @if(old('class') == $class->class) selected @endif>{{$class->class}}</option>
                @endforeach
            </select>
            <!-- テンプレ追加のボタン -->
            <input type = "button" class = "addPopupButton" value = " + " onClick = "deleteTextSubmit();"><br>
<!-- -------------------------------------------------------------------------- -->
<!--場所を入力-->
<!-- --------------------------------------------------------------------------* -->
            <!-- dbアクセス -->
            @php
                $places = \DB::table('places')->get();
            @endphp
                <!-- ↑dd（$places）; -->
            場所<select name="place" class="Event_label_place">
                @foreach ($places as $place)
                    <option value='{{$place->place}}' @if(old('place') == $place->place) selected @endif>{{$place->place}}</option>
                @endforeach
            </select>
            <!-- テンプレ追加のボタン -->
            <input type = "button" class = "addPopupButton" value = " + " onClick = "deleteTextSubmit();"><br>
<!-- -------------------------------------------------------------------------- -->
<!-- 日時を入力 -->
<!-- --------------------------------------------------------------------------* -->
            <div>
	            <div>
	                <label>日時</label><br>
	                <span>開始日時：</span>
	                <input type = "date" name = "start_date" id = "startDay" class="Event_startDay" required value = "{{old('start_date')}}">
	                <font color="red" size="3px">←※</font><input type = "time" name = "start_time" id = "starTime" class="Event_startTime">
	            </div>
    	        <div class="Event_end_div">
	                <span>終了日時：</span>
	                <input type = "date" name = "end_date" id = "endDay" class="Event_endDay" required value = "{{old('end_date')}}">
	                <font color="red" size="3px">←※</font><input type = "time" name = "end_time" id = "endTime" class="Event_endTime">
		</div>
	   </div>
<!-- -------------------------------------------------------------------------- -->
<!-- 備考を入力 -->
<!-- --------------------------------------------------------------------------* -->
            備考<br>
                <textarea name="remarks" cols="30" rows="10" maxlength="200"class="Event_remarks">{{old('remarks')}}</textarea><br>
        </div>
        <div class="add_Notes" style="color:red" size="3px" align="right">※は必須項目です。</div>

	<div class="Event_buttons">
            <!-- 追加・キャンセルボタン -->
		<input type ="submit" id="add_button" value="追加" class ="add_ok_button">
		<script type="text/javascript">
		  function changeDisabled(){
 			var obj = document.getElementById("add_button");
		  	if(obj.disabled == true){
			   return obj.disabled = false;  //Enableに設定
			}else{
			   return obj.disabled = true;   //Disableに設定
  			}       
	  	  }
		</script>
	</div>

        @php
            $user = Auth::user() -> name;
        @endphp
        <input type = "hidden" name = "userName" value = "{{$user}}">
    </form>
    
    <form  method = "post" action = {{route ('index') }}>
        @csrf
        <input type = "submit" class = "Event_cancel" value = "キャンセル">
    </form>
</div>

<!-- -------------------------------------------------------------------------- -->
<!-- 各種テンプレ―ト追加のポップアップに関する操作・内容。クリックされるまではcssで隠しておく -->
<!-- --------------------------------------------------------------------------* -->
<!-- タイトル追加のポップアップに関する操作・内容。クリックされるまではcssで隠しておく -->
<div class = "addPopup">
        <h2 class = "addtemp_title">タイトルのテンプレートを追加</h2>
        <form method = "post" action = {{route ('addaddTmp') }}>
            @csrf
            <input type = "text" name = "addTemp" class = "addtemp_text" required><br>
            <input type = "hidden" name = "type" value = "titles">
            <input type = "hidden" name = "cname" value = "title">
            <input type = "hidden" name = "origin" value = "add">
            <input type = "submit" class = "addtemp_button" value = "追加">
        </form>
        <input type = "button" class = "addPopCloseButton" value = "閉じる">
    </div>

<!-- クラス追加のポップアップに関する操作・内容。クリックされるまではcssで隠しておく -->
<div class = "addPopup">
        <h2 class = "addtemp_title">組のテンプレートを追加</h2>
        <form method = "post" action = {{route('addaddTmp')}}>
            @csrf
            <input type = "text" name = "addTemp" class = "addtemp_text" required><br>
            <input type = "hidden" name = "type" value = "classes">
            <input type = "hidden" name = "cname" value = "class">
            <input type = "hidden" name = "origin" value = "add">
            <input type = "submit" class = "addtemp_button" value = "追加">
        </form>
        <input type = "button" class = "addPopCloseButton" value = "閉じる">
    </div>

<!-- 場所追加のポップアップに関する操作・内容。クリックされるまではcssで隠しておく -->
<div class = "addPopup">
        <h2 class = "addtemp_title">場所のテンプレートを追加</h2>
        <form method = "post" action = {{route('addaddTmp')}}>
            @csrf
            <input type = "text" name = "addTemp" class = "addtemp_text" required><br>
            <input type = "hidden" name = "type" value = "places">
            <input type = "hidden" name = "cname" value = "place">
            <input type = "hidden" name = "origin" value = "add">
            <input type = "submit" class = "addtemp_button" value = "追加">
        </form>
        <input type = "button" class = "addPopCloseButton" value = "閉じる">
    </div>
