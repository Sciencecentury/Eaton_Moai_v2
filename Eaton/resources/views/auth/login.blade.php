@extends('layout.default')

@section('title', 'ログイン')

@section('body')
    <div class = "loginBackColor">
        <h1 class = "mainTitle">ログイン</h1>
        @isset($message)
            <p style = "color : red">{{$message}}</p>
        @endisset
        <!-- Authによっていい感じになるらしい -->
        <form action = "{{ route('login') }}"　name = "loginform" method = "post">
            <!-- 入力値チェックええ感じにしてくれるらしい -->
            @csrf
            <div class="login_labels">
                <label for = "name">ユーザ名</label>
                <input type  = "text" name = "name" value = "{{old('name')}}"  class="login_label_name" autofocus> 
		<div class = "errors_msg">{{$errors -> first('name')}}</div>
                <label for = "password">パスワード</label>

		<input type = "password" name = "password" class="login_label_password">
		<div class= "errors_msg">{{$errors -> first('password')}}</div>
            </div>

            <div class="login_all_button"> <!--spanはインライン要素らしい-->
                <div class = "login_buttons"><!--buttonの囲い -->
                    <input type = "submit" name = "action"  class="ok_button" value = "ログイン">
		</div>
        </form>
        
        <!-- カレンダー画面へ -->
        <form  method = "post" action = {{route ('index') }}>
            @csrf
            <input type = "submit" class = "cancel_button" value = "キャンセル">
        </form>

        <!-- 新規登録画面へ -->
<!--      <li><a class = "link_button" href = "{{ route('register') }}">新規登>録</a></li>
--> <div class="link_button_div"><a class = "link_button" href = "{{ route('register') }}">新規登録</a></div>

            </div>
    </div>
@endsection 
