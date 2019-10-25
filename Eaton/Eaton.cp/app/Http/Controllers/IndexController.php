<?php
//-----------------------------------------------------------------------------------------------------------
//index.php(カレンダーの画面)にアクセスがあったときに動くコントローラー
//-----------------------------------------------------------------------------------------------------------
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
    use App\Models\OneWeek;
    use App\Models\WeeklyMove;
    use App\Models\GetPlans;
    // use App\Models\OneMonth;
    use Carbon\Carbon;
    
//-----------------------------------------------------------------------------------------------------------
//「controllerクラス」を継承するIndexControllerクラス
// トップ画面（カレンダー含む）を表示する
// web.phpの「Route::get('/', 'IndexController@index')->name('index');」によりこのindexメソッドに飛んでくる
//-----------------------------------------------------------------------------------------------------------
    class IndexController extends Controller{

// -----------------------------------------------------------------------------------------------------------
// カレンダーの日付部分を表示する
// -----------------------------------------------------------------------------------------------------------
    public function index(){
        // 現在時刻を取得(carbonは静的メソッドのため、newせずに::で呼び出す)
        $nowTime = Carbon::now();

        // 取得した現在時刻から任意のフォーマットで、年・月など日付情報を取得し、それを＄todayに代入
        $today = $nowTime -> format('Y.m.d');

        // ＄nowTimeから年、月、日の値を個別で持ってくる
        $year = $nowTime -> year;
        $month = $nowTime -> month;
        $day = $nowTime -> day;

        // model（OneWeek.php）にアクセスして、今週一週間の日付が入った配列（＄dates）を受け取る
        $dates = OneWeek::getCalendarDates($year, $month, $day);

        // 受け取った今週一週間の配列から先頭の日付だけを抽出する
        $weekStart = substr($dates[0], 0 ,10);

        // 今週一週間の予定をdbから抽出し、連想配列の状態で渡す
        $headDate = clone $dates[0];
        $tasks = GetPlans::getplans($headDate);
  
        // 現在の月の1ヶ月のカレンダーを、先月のや来月の端が入った状態の配列で渡す
        // $oneMonthCalendar = OneMonth::getOneMonth($year, $month);

        //↓でindex.blade.php(つまりMVCのV)に今日の日付、一週間の配列、今週の初めの日、今週一週間の予定、月カレンダーの表示を投げる
        return view('index', ['today' => $today, 'dates' => $dates, 'weekStart' => $weekStart, 'tasks' => $tasks]);
    }
// -----------------------------------------------------------------------------------------------------------
// カレンダーの週移動
// -----------------------------------------------------------------------------------------------------------
       public function weekMove(Request $request){

            // ＄requestで受け取った値を全て受け取る
            $data = $request -> all();
            
            // hiddenパラメーターから値を取得
            $move = $data['move'];
            $nowDisplay = $data['nowDisplay'];

            // 現在時刻を取得(carbonは静的メソッドのため、newせずに::で呼び出す)
            $nowTime = Carbon::now();
            // ＄nowTimeから年、月、日の値を個別で持ってくる
            $today = $nowTime -> format('Y.m.d');

            //週移動のメソッドを呼び出し、移動後の週を配列で受け取る
            $dates = WeeklyMove::weekMove($move, $nowDisplay);
            
            // 受け取った今週一週間の配列から先頭の日付だけを抽出する
            $weekStart = substr($dates[0], 0 ,10);

            // 今週一週間の予定をdbから抽出し、連想配列の状態で渡す
            $headDate = clone $dates[0];
            $tasks = GetPlans::getplans($headDate);

            return view('index', ['today' => $today, 'dates' => $dates, 'weekStart' => $weekStart, 'tasks' => $tasks]);
        }
}