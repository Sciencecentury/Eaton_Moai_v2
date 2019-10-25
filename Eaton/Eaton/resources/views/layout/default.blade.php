<!-- --------------------------------------------------------------------------
このファイルは、laravelファイルの中ですべてのファイルと共通した部分を記述している。
このテンプレを使用したいファイルにこのファイルをimportして使う
＠yieldここに差分を記述する。埋めなかったらnull値になる
-------------------------------------------------------------------------- -->
<!DOCTYPE html>
<html lang = "ja">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
    <!-- <meta http-equiv = "X-UA-Compatible" content = "ie=edge"> -->

    <!-- タイトル -->
    <title>@yield('title')</title>

    <!-- javascript -->
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <script src = "{{ asset('js/all.js') }}" defer></script>

    <!-- フォント -->
    <link href = "https://fonts.googleapis.com/css?family=Kosugi+Maru&display=swap" rel = "stylesheet" type = "text/css">

    <link href = "{{ asset('css/all.css') }}" rel = "stylesheet">
</head>
<body>
<!-------------------------------------------------------------------------------------------------->
<!-- にょきっとばー -->
<!-- ログイン状態に応じてにょきっとばーの項目の表示が変わる -->
<!-------------------------------------------------------------------------------------------------->
    <!-- ログイン済みかどうかを判断 -->
    @if(Auth::check())
        <!-- ログイン後の表示 -->
           <a class = "drawrOpenBtn"></a>
            <div class = "drawrMenu">
                <div class = "menuHead">Menu</div>
                <ul class = "drawerList">
                        <hr class = "bar">
                    <li><a  class = "authLink" href = "{{ route('logout') }}">ログアウト</a></li>
                        <hr class = "bar">
                    <li><a  class = "authLink" href = "{{ route ('addEvent')}}">予定追加</a></li>
                        <hr class = "bar">
                    <li><a  class = "authLink" href = "{{ route('index')}}">トップページ</a></li>
                        <hr class = "bar">
                    <li><a  class = "authLink" href = "{{ route('templateDelete')}}">テンプレート削除</a></li>
                        <hr class = "bar">
                    </ul>
            </div>
        <!-- ログインしているユーザの名まえを表示 -->
            <div class = "uname">{{\Auth::user() -> name}}さん</div><br>
    @else
        <!-- ログイン前の表示 -->
            <a class = "drawrOpenBtn"></a>
            <!-- ドロワーの中身 -->
            <div class = "drawrMenu">
                <div class = "menuHead">Menu</div>
                <ul class = "drawerList">
                        <hr class = "bar">
                    <li><a  class = "authLink" href = "{{ route('register') }}">新規登録</a></li>
                        <hr class = "bar">     
                    <li><a  class = "authLink" href = "{{ route('login') }}">ログイン</a></li>
                        <hr class = "bar">
                    <li><a  class = "authLink" href = "{{ route('index') }}">トップページ</a></li>
                        <hr class = "bar">
                </ul>
            </div>
        <!-- ログインしていないため、ゲストさんと表示   -->
            <span class = "uname">ゲストさん</span><br>
    @endif

    @yield('body')
</body>
</html>