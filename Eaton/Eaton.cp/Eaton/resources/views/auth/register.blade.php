@extends('layout.default')

@section('title', '新規登録')

@section('body')

<!-- エラーメッセージ
   @if($errors -> any())
	<div class="top_errors_msg">{{$errors -> first('name')}}
		@foreach($errors -> all() as $error)
			{{$error}}<dr>
		@endforeach
	</div>
   @endif
-->
<div class = "loginBackColor">
        <h1 class = "mainTitle">新規登録</h1>

        <!-- Authによっていい感じになるらしい -->
        <form action = "{{ route('register') }}"　name = "registerform" method = "post">
            <!-- 入力値チェックええ感じに検査してくれるらしい -->
            @csrf
            <!-- $errors -> first（'【フィールド名】'）：　入力した後に入力値をチェックする仕組み（＝バリデーション） -->
	<div class="register_labels_and_buttons">
	 <div class = "login_labels">
	
           <font color="red">※</font> <label for = "name">ユーザ名</label>
	    <input type  = "text" name = "name" class = "register_label_name" placeholder="12文字以下で入力してください。" autofocus>		
<div class = "errors_msg">{{$errors -> first('name')}}</div>


            <font color="red">※</font><label for = "password">パスワード</label>
	    <input type = "password" name = "password" class = "register_label_password" placeholder="8文字以上で入力してください。">
	    <div class = "errors_msg">{{$errors -> first('password')}}</font></div>

	    <font color="red">※</font><label for = "password">パスワード(確認用)</label>
	    <input type = "password" name = "password_confirmation" class = "register_label_password_confirmation" placeholder="同じパスワードを入力してください。">
	    <div = "errors_msg">{{$errors -> first('password_confirmation')}}</font></div>
	</div>
<div style="color:red" size="3px" align="right">※は必須項目です。</div>

    <div class="register_buttons"> <!--spanはインライン要素らしい-->
            <input type = "submit" name = "action" class = "Registration_button" value = "登録">
        </form>

        <!-- カレンダー画面へ -->
        <form  method = "post" action = {{route ('index') }}>
            @csrf
            <input type = "submit" class = "register_cancel_button" value = "キャンセル">
        </form>
    </div>
   </div>     
</div>
