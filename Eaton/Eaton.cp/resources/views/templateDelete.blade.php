@extends('layout.default')

@section('title', 'テンプレート削除 ')

@section('body')

<!-------------------------------------------------------------------------------------------------->
<!-- テンプレートの削除ページにずっとあるやつ -->
<!-------------------------------------------------------------------------------------------------->
	<div class="all_temp_block">
		<div class="temp_select_box_frame">
			<h1 class="temp_maintitle">テンプレートの削除</h1>
			<select class="temp_select_box">
			   <option value="temp_select">削除したい要素の種類を選択してください</option>
			   <option value="event">イベントタイトル</option>
			   <option value="class">組</option>
			   <option value="place">場所</option>
			</select>
		</div>
<!-------------------------------------------------------------------------------------------------->
<!-- タイトルの削除に関するsection -->
<!-------------------------------------------------------------------------------------------------->	
    	<section id="event"class="eve_del_title">
        <form class="temp_block" action = "{{ route('tmpDelete') }}" method="post">
            @csrf
            <h2 class="temp_title">タイトルの削除</h2>
            @php
                $titles = \DB::table('titles')->get();
            @endphp
   			<div class="temp_content">
	            @foreach ($titles as $title)
	                <input type="checkbox"  value='{{$title->id}}' name='checked[]'>{{$title->title}}<br/>
	            @endforeach
            </div>
            <!-- どのテーブルから要素を削除するのかを判定するためのパラメタ -->
            <input type = "hidden" name = "tableType" value = "titles">
            <input type="submit" class="delete_button" value="削除">
        </form>
        </section>

<!-------------------------------------------------------------------------------------------------->
<!-- 組の削除に関するsection -->
<!-------------------------------------------------------------------------------------------------->	        		
        <section id="class"　class="eve_del_class">
        <form class="temp_block" action="{{ route('tmpDelete') }}" method="post">
            @csrf
            <h2 class="temp_class">組の削除</h2>
            @php
                $classes = \DB::table('classes')->get();
            @endphp
	            <div class="temp_content">
	            @foreach ($classes as $class)
	                <input type="checkbox"  value='{{$class->id}}' name='checked[]'>{{$class->class}}<br/>
	            @endforeach
	            </div>
            <!-- どのテーブルから要素を削除するのかを判定するためのパラメタ -->
            <input type = "hidden" name = "tableType" value = "classes">
            <input type="submit" class="delete_button" value="削除">
        </form>
        </section>

<!-------------------------------------------------------------------------------------------------->
<!-- 場所の削除に関するsection -->
<!-------------------------------------------------------------------------------------------------->	
        <section id="place"　class="eve_del_place">
        <form class="temp_block" action="{{ route('tmpDelete') }}" method="post">
            @csrf
            <h2 class="temp_place">場所の削除</h2>
            @php
                $places = \DB::table('places')->get();
            @endphp
	            <div class="temp_content">
	            @foreach ($places as $place)
	                <input type="checkbox"  value='{{$place->id}}' name='checked[]'>{{$place->place}}<br/>
	            @endforeach
                </div>
            <!-- どのテーブルから要素を削除するのかを判定するためのパラメタ -->
            <input type = "hidden" name = "tableType" value = "places">
            <input type="submit" class="delete_button" value="削除">
        </form>
        </section>     			
    </div>
