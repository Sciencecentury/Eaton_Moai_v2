@extends('layout.default')

@section('title', 'カレンダー')

@section('body')
<!-------------------------------------------------------------------------------------------------->
<!-- 今日の日付を取得・表示 -->
<!-------------------------------------------------------------------------------------------------->
  <div class = "today">{{$today}}</div><br>

<!-------------------------------------------------------------------------------------------------->
<!-- 一週間カレンダーの週移動矢印-->
<!-------------------------------------------------------------------------------------------------->
<span class = "leftButton">
  <form  method = "post" action = {{route ('indexWeekMove') }}>
    @csrf
    <input type = "hidden" name = "move" value = "back">
    <input type = "hidden" name = "nowDisplay" value = "{{$weekStart}}">
    <input type = "image" src = "img/left.png">
  </form>
</span>

<!-- 一週間カレンダーに表示されている日付の月 -->
<span class = "displayMonth">
  {{$dates[0] -> year}}年
  {{$dates[0] -> month}}月
</span>

<!-- 次の週へ進む -->
<span class = "rightButton">    
    <form  method = "post" action = {{route ('indexWeekMove') }}>
      @csrf
        <input type = "hidden" name = "move" value = "forward">
        <input type = "hidden" name = "nowDisplay" value = "{{$weekStart}}">
        <input type = "image" src = "img/right.png">
    </form>
  </span>

<!-- 現在の週に戻る -->
<span class = "nowWeekBack">
  <form  method = "post" action = {{route ('index') }}>
    @csrf
      <!-- <input type = "hidden" name = "move" value = "forward"> -->
      <!-- <input type = "hidden" name = "nowDisplay" value = "{{$weekStart}}"> -->
      <input type = "submit" class = "nowWeekBackButton" value = "現在の週に戻る">
  </form>
</span>

<!-------------------------------------------------------------------------------------------------->
<!-- 一週間カレンダー・曜日表示 -->
<!-------------------------------------------------------------------------------------------------->
<span>
<table class = "calendarTable">
　<!-- <thead>：テーブルのヘッダ行 -->
  <thead>
    <tr class = "oneWeek">
        <!-- 曜日を出力 -->
      @foreach (['日', '月', '火', '水', '木', '金', '土'] as $dayOfWeek)
        @php
          if($dayOfWeek == "日"){
        @endphp
            <th style = "color : red;">{{ $dayOfWeek }}</th>
        @php
          }else if($dayOfWeek == "土"){
        @endphp
            <th style = "color : blue;">{{ $dayOfWeek }}</th>
        @php
          }else{
        @endphp
            <th style = "color : black;">{{ $dayOfWeek }}</th>
        @php
          }
        @endphp
        @endforeach
    </tr>
  </thead>
<!-------------------------------------------------------------------------------------------------->
<!-- 一週間カレンダー・日付表示 -->
<!-------------------------------------------------------------------------------------------------->
  <!-- <tbody>：テーブルのデータ部分 -->
  <tbody>
    @foreach ($dates as $date)
        @if ($date -> dayOfWeek == 0)
            <tr>
        @endif
        <!-- 現在選択されている日付が今月のものでなければ背景を暗くする -->
      <td class = "oneWeekDay"
        @if ($date -> month != date('m'))
            class = "bg-secondary"
        @endif
      >
        {{ $date->day }}
      </td>
        <!-- 一週間分表示したら終了 -->
         @if ($date->dayOfWeek == 7)
           </tr>
        @endif
    @endforeach
<!-------------------------------------------------------------------------------------------------->
<!-- 一週間カレンダー・予定表示 -->
<!-------------------------------------------------------------------------------------------------->
<tr>
    <!-- 今週の日数分（要は7回）回す -->
      @for($roopCountWeek = 0; $roopCountWeek < 7; ++$roopCountWeek)
        <td class = "taskList">
        <!-- 配列に入っているタスクの数だけループさせる -->
        @foreach($tasks as $key => $val)
          <!-- 現在、指し示している日付と、taskの日付が同じならタイトルを表示する -->  
          @if($dates[$roopCountWeek] == $key." 00:00:00")
            @foreach($val as $dayTask)

            <!-- 予定のタイトルを表示、クリックで詳細ポップアップを表示する -->
              <span><input type = "button" class = "taskDetailPopupButton" value = "{{$dayTask -> title}}"></span><br>

              <!-- ポップアップに関する操作・内容。クリックされるまではcssで隠しておく -->
              <div class = "taskDetailPopup">
                <!-- ポップアップの内容 -->
                <span class = "taskTitle">
                  {{$dayTask -> title}}
                </span>
                <span class = "author">
		  【作成者 ： {{$dayTask -> userName}}】
                  【最終編集者： {{$dayTask -> last_editor}}】  
                </span>
                <span class = "taskDetail">
		  <table class = "taskDetail">
                    <tr><td class = "taskColumn">組</td><td class = "taskData">{{$dayTask -> class}}</td></tr>
                    <tr><td class = "taskColumn">場所</td><td class = "taskData">{{$dayTask -> place}}</td></tr>
                    <tr><td class = "taskColumn">開始日付</td><td class = "taskData">{{$dayTask -> start_date}}</td></tr>
                    <tr><td class = "taskColumn">開始時刻</td><td class = "taskData">{{$dayTask -> start_time}}</td></tr>
                    <tr><td class = "taskColumn">終了日時</td><td class = "taskData">{{$dayTask -> end_date}}</td></tr>
                    <tr><td class = "taskColumn">終了時刻</td><td class = "taskData">{{$dayTask -> end_time}}</td></tr>
                  </table>
                </span>
                <span>
                  <div class = "taskRemarksTitle">備考</div>
                  <div class = "taskRemarksBack"><div class = "taskRemarks">{{$dayTask -> remarks}}</div></div>
                </span> 

                <!-- 削除ボタン -->
                @if(Auth::check())
                  <form  method = "post" action = {{route ('deleteTask') }}>
                    @csrf
                    <!-- このタスクのidをhiddenで送る -->
                    <input type = "hidden" name = "taskId" value = "{{$dayTask -> id }}">
                    <input type = "submit" class = "deleteButton" value = "削除">
                  </form>
                @endif
            
                <!-- 閉じるボタン -->
                <input type = "button" class = "closeButton" value = "閉じる"><br>
          
                @if(Auth::check())
                  <!-- 予定編集ボタン -->
                   <form  method = "post" action = {{route ('changeEvent') }}>
                    @csrf
                    <!-- このタスクのidをhiddenで送る -->
                    <input type = "hidden" name = "taskId" value = "{{$dayTask -> id }}">
                    <input type = "hidden" name = "origin" value = "index">
                    <input type = "submit" class = "editButton" value = "編集">
                  </form>
                @endif
              </div>

            @endforeach
          @endif
        @endforeach
      </td>
      @endfor
    </tr>
</tbody>
</table>
</span>
