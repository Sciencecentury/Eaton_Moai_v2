<?php
/*--------------------------------------------------------------------------
login.php(カレンダーの画面)にアクセスがあったときに動くコントローラー
--------------------------------------------------------------------------*/
    // namespace：ファイルの居場所を表す
    namespace App\Http\Controllers;

    // use：中で使うクラスを宣言する
    //  ・名前空間などのエイリアス（別名）を作成
    //  ・名前空間の全て、または一部をインポート
    //  ・クラスをインポート
    //  ・関数をインポート
    //  ・定数をインポート
    // などができる
    use Illuminate\Http\Request;

/*--------------------------------------------------------------------------
「controllerクラス」を継承するLoginControllerクラス
--------------------------------------------------------------------------*/
class LoginController extends Controller{
    // ログイン画面を表示する
    // web.phpの「Route::get('/', 'LoginController@login')->name('login');」によりこのloginxメソッドに飛んでくる
        public function login(){
        //   ↓でlogin.blade.php(つまりMVCのV)にアクセスする
          return view('auth/login');
        }
    // ログイン処理をする
    public function loginCheck(){

    }
}