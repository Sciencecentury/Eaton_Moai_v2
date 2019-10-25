@extends('layout.default')

@section('title', '予定変更 ')

@section('body')

<!-- エラー出力 -->
@if ($errors -> any())
   <div class= "top_errors_msg">{{$errors -> first('password')}}
      @foreach ($errors -> all() as $error)
         {{$error}}<br>
      @endforeach
    </div>
@endif

<div class = "addEventBackColor">
<h1 class = "addEventMainTitle">予定の編集</h1>

<div class="changeEvent_p">
    <p>編集する予定のタイトル</p>
</div>
			@if ($origin == "index")
       @php
            $titles = \DB::table('titles')->get();
            $classes = \DB::table('classes')->get();
            $places = \DB::table('places')->get();
				
            	$userName = $changeTask[0] -> userName;
            	$title = $changeTask[0] -> title;
            	$id = $changeTask[0] -> id;
           		$class = $changeTask[0] -> class;
            	$place = $changeTask[0] -> place;
					$start_date = $changeTask[0] -> start_date;
					$start_time = $changeTask[0] -> start_time;
					$end_date = $changeTask[0] -> end_date;
					$end_time = $changeTask[0] -> end_time;
					$remarks = $changeTask[0] -> remarks;
		@endphp				
			@endif
<form action = "{{route('eventChange')}}" method = "post">
   @csrf
   <div class="Event_labels">

       <!--テンプレートを表示するためにdbからタイトルのテンプレ一覧を取得する-->
       <!--編集しよとしているタスクのタイトルを取得する-->

	 <input type = "hidden" name = "userName" value = "{{$userName}}">
    <input type = "hidden" name = "id" value = "{{$id}}">
	<!-- タイトル設定部分 -->
           タイトル<input list = 'testList'  class = 'Event_label_title' name = 'title' required placeholder = '変更前：{{$title}}'>
           <datalist id='testList'>
           @foreach ($titles as $val)
					@if ($val -> title == $title)
            		<option value='{{$val->title}}' selected>{{$val->title}}</option>
           		@else
               	<option value='{{$val->title}}'>{{$val->title}}</option>
           		@endif
           @endforeach
           </datalist>
   			<br> 
            <!-- テンプレ追加のボタン -->
            <!--<input type = "button" class = "addPopupButton" value = " + " onClick = "deleteTextSubmit();"><br>-->

<!-- 組設定部分 -->
          組<select name='class' class='Event_label_class'>
          	@foreach ($classes as $val)
            	@if ($val -> class == $class)
               	<option value='{{$val->class}}' selected>{{$val->class}}</option>
            	@else
               	<option value='{{$val->class}}'>{{$val->class}}</option>
					@endif
				@endforeach
            </select>
   			<br> 
            <!-- テンプレ追加のボタン -->
            <!--<input type = "button" class = "addPopupButton" value = " + " onClick = "deleteTextSubmit();"><br>-->

<!-- 場所設定部分 -->
          場所<select name='place' class='Event_label_place'>
           	@foreach ($places as $val)
            	@if ($val -> place == $place)
               	<option value='{{$val->place}}' selected>{{$val->place}}</option>
            	@else
               	<option value='{{$val->place}}'>{{$val->place}}</option>
					@endif
				@endforeach
            </select>
    
   			<br> 
            <!-- テンプレ追加のボタン -->
            <!--<input type = "button" class = "addPopupButton" value = " + " onClick = "deleteTextSubmit();"><br>-->

<!-- 時間設定部分 -->              
        <div>
            <div>
					<label>日時</label><br>
               <span>開始日時：</span>
               <input type = "date" name = "start_date" id = "startDay" class="Event_startDay"  value = "{{$start_date}}" required>
               <input type = "time" name = "start_time" id = "starTime" class="Event_startTime" value = "{{$start_time}}">
            </div>
            <div class="Event_end_div">
                <span>終了日時：</span>
                <input type = "date" name = "end_date" id = "endDay" class="Event_endDay" value = "{{$end_date}}" required>
                <input type = "time" name = "end_time" id = "endTime" class="Event_endTime" value = "{{$end_time}}">
            </div>
        </div>

<!-- 備考設定部分 -->
        備考<br>
        <textarea name="remarks" cols="30" rows="10" maxlength="200" class="Event_remarks">{{$remarks}}</textarea><br>
   </div>

    <div class="Event_buttons">
       <!-- 追加・キャンセルボタン -->
       <input type = "submit" value = "変更" class="add_ok_button">
    </div>
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
        <form method = "post" action = {{route('changeaddTmp')}}>
            @csrf
            <input type = "text" name = "addTemp" class = "addtemp_text" required><br>
            <input type = "hidden" name = "type" value = "titles">
            <input type = "hidden" name = "cname" value = "title">
            <input type = "hidden" name = "dbData" value = "{{$changeTask}}">
            <input type = "hidden" name = "origin" value = {{$id}}>
            <input type = "submit" class = "addtemp_button" value = "追加">
        </form>
        <input type = "button" class = "addPopCloseButton" value = "閉じる">
    </div>

<!-- クラス追加のポップアップに関する操作・内容。クリックされるまではcssで隠しておく -->
<div class = "addPopup">
        <h2 class = "addtemp_title">組のテンプレートを追加</h2>
        <form method = "post" action = {{route('changeaddTmp')}}>
            @csrf
            <input type = "text" name = "addTemp" class = "addtemp_text" required><br>
            <input type = "hidden" name = "type" value = "classes">
            <input type = "hidden" name = "cname" value = "class">
            <input type = "hidden" name = "dbData" value = "{{$changeTask}}">
            <input type = "hidden" name = "origin" value = {{$id}}>
            <input type = "submit" class = "addtemp_button" value = "追加">
        </form>
        <input type = "button" class = "addPopCloseButton" value = "閉じる">
    </div>

<!-- 場所追加のポップアップに関する操作・内容。クリックされるまではcssで隠しておく -->
<div class = "addPopup">
        <h2 class = "addtemp_title">場所のテンプレートを追加</h2>
        <form method = "post" action = {{route('changeaddTmp')}}>
            @csrf
            <input type = "text" name = "addTemp" class = "addtemp_text" required><br>
            <input type = "hidden" name = "type" value = "places">
            <input type = "hidden" name = "cname" value = "place">
            <input type = "hidden" name = "origin" value = {{$id}}>
            <input type = "hidden" name = "dbData" value = "{{$changeTask}}">
            <input type = "submit" class = "addtemp_button" value = "追加">
        </form>
        <input type = "button" class = "addPopCloseButton" value = "閉じる">
    </div>
   
