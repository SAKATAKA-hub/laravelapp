<?php
namespace App\Http\Controllers;

# モデルの利用
use App\Models\Employee;
use App\Models\Work;
use App\Models\Checkbox;

use App\Http\Controllers\library\DateItems;// 日付クラスの利用
use Illuminate\Http\Request;
use TCPDF;
use TCPDF_FONTS;

class AttendanceManegementController extends Controller
{
    # 日別勤怠管理一覧 ------------------------------
    public function date_list()
    {
        $Ymd = date('Y/m/d',time()); //今日の日付
        $DI = new DateItems;
        $date_item = $DI->getThisMonth($Ymd);

        //合計勤務時間 等
        $TotalRestrainTime = Work::dateList($Ymd)->sum('RestrainTime');
        $TotalBreakTime = Work::dateList($Ymd)->sum('BreakTime');
        $TotalWorkingTime = Work::dateList($Ymd)->sum('WorkingTime');

        $param=[
            //表示ページ
            'app_menu_current' => 'date_list',
            //セレクト要素
            'select_items' => $this->getSelectItems($Ymd),
            //入力内容
            'input' => '',
            //表示内容の説明
            'display_text' => [
                'date' => $date_item['Ymd_text'],
                'place' => '全て',
            ],
            //出勤レコードの取得
            'worked_records' =>
            Work::dateList($Ymd)->with('employee')->with('work_breaks')->get(),

            // 合計勤務時間 等
            'TotalRestrainTime' => sprintf('%d:%02d',floor($TotalRestrainTime/(60*60) ), floor($TotalRestrainTime%(60*60)/60 ) ),
            'TotalBreakTime' => sprintf('%d:%02d',floor($TotalBreakTime/(60*60) ), floor($TotalBreakTime%(60*60)/60 ) ),
            'TotalWorkingTime' => sprintf('%d:%02d',floor($TotalWorkingTime/(60*60) ), floor($TotalWorkingTime%(60*60)/60 ) ),

            'Ymd' => $Ymd,
        ];
        return view('attendance_manegement.date_list',$param);
    }

    // 検索表示
    public function date_list_search(Request $request)
    {
        $Ymd = $request->y_month.'/'.$request->date; //リクエストされた日付
        $DI = new DateItems;
        $date_item = $DI->getThisMonth($Ymd);

        //合計勤務時間 等
        $TotalRestrainTime = Work::dateList($Ymd)->sum('RestrainTime');
        $TotalBreakTime = Work::dateList($Ymd)->sum('BreakTime');
        $TotalWorkingTime = Work::dateList($Ymd)->sum('WorkingTime');

        $param=[
            //表示ページ
            'app_menu_current' => 'date_list',
            //セレクト要素
            'select_items' => $this->getSelectItems($Ymd),
            //入力内容
            'input' => $request->all(),
            //表示内容の説明
            'display_text' => [
                'date' => $date_item['Ymd_text'],
                'place' => $request->place,
            ],
            //出勤レコードの取得
            'worked_records' => Work::dateList($Ymd)->with('employee')->get(),

            // 合計勤務時間 等
            'TotalRestrainTime' => sprintf('%d:%02d',floor($TotalRestrainTime/(60*60) ), floor($TotalRestrainTime%(60*60)/60 ) ),
            'TotalBreakTime' => sprintf('%d:%02d',floor($TotalBreakTime/(60*60) ), floor($TotalBreakTime%(60*60)/60 ) ),
            'TotalWorkingTime' => sprintf('%d:%02d',floor($TotalWorkingTime/(60*60) ), floor($TotalWorkingTime%(60*60)/60 ) ),

            'Ymd' => $Ymd,
        ];
        return view('attendance_manegement.date_list',$param);
    }


    # 月別勤怠管理一覧 ------------------------------
    public function month_list()
    {
        $Ymd = date('Y/m/d',time()); //今日の日付
        $DI = new DateItems;
        $date_item = $DI->getThisMonth($Ymd);

        //合計勤務時間 等
        $TotalRestrainTime =
        Work::monthList($date_item['first_Ymd'], $date_item['last_Ymd'])->sum('RestrainTime');
        $TotalBreakTime =
        Work::monthList($date_item['first_Ymd'], $date_item['last_Ymd'])->sum('BreakTime');
        $TotalWorkingTime =
        Work::monthList($date_item['first_Ymd'], $date_item['last_Ymd'])->sum('WorkingTime');

        $param=[
            //表示ページ
            'app_menu_current' => 'month_list',
            //セレクト要素
            'select_items' => $this->getSelectItems($Ymd),
            //入力内容
            'input' => '',
            //表示内容の説明
            'display_text' => [
                'date' => $date_item['Ym_text'],
                'place' => '全て',
            ],
            //出勤レコードの取得
            'worked_records' =>
            Work::monthList($date_item['first_Ymd'], $date_item['last_Ymd'])
            ->with('employee')->with('work_breaks')->get(),

            // 合計勤務時間 等
            'TotalRestrainTime' => sprintf('%d:%02d',floor($TotalRestrainTime/(60*60) ), floor($TotalRestrainTime%(60*60)/60 ) ),
            'TotalBreakTime' => sprintf('%d:%02d',floor($TotalBreakTime/(60*60) ), floor($TotalBreakTime%(60*60)/60 ) ),
            'TotalWorkingTime' => sprintf('%d:%02d',floor($TotalWorkingTime/(60*60) ), floor($TotalWorkingTime%(60*60)/60 ) ),

            'Ymd' => $Ymd,
        ];
        return view('attendance_manegement.month_list',$param);

    }

    public function month_list_search(Request $request)
    {
        $Ymd = $request->y_month.'/01'; //リクエストされた日付
        $DI = new DateItems;
        $date_item = $DI->getThisMonth($Ymd);

        //合計勤務時間 等
        $TotalRestrainTime =
        Work::monthList($date_item['first_Ymd'], $date_item['last_Ymd'])->sum('RestrainTime');
        $TotalBreakTime =
        Work::monthList($date_item['first_Ymd'], $date_item['last_Ymd'])->sum('BreakTime');
        $TotalWorkingTime =
        Work::monthList($date_item['first_Ymd'], $date_item['last_Ymd'])->sum('WorkingTime');

        $param=[
            //表示ページ
            'app_menu_current' => 'month_list',
            //セレクト要素
            'select_items' => $this->getSelectItems($Ymd),
            //入力内容
            'input' => $request->all(),
            //表示内容の説明
            'display_text' => [
                'date' => $date_item['Ym_text'],
                'place' => $request->place,
            ],
            //出勤レコードの取得
            'worked_records' =>
            Work::monthList($date_item['first_Ymd'], $date_item['last_Ymd'])
            ->with('employee')->with('work_breaks')->get(),

            // 合計勤務時間 等
            'TotalRestrainTime' => sprintf('%d:%02d',floor($TotalRestrainTime/(60*60) ), floor($TotalRestrainTime%(60*60)/60 ) ),
            'TotalBreakTime' => sprintf('%d:%02d',floor($TotalBreakTime/(60*60) ), floor($TotalBreakTime%(60*60)/60 ) ),
            'TotalWorkingTime' => sprintf('%d:%02d',floor($TotalWorkingTime/(60*60) ), floor($TotalWorkingTime%(60*60)/60 ) ),

            'Ymd' => $Ymd,
        ];
        return view('attendance_manegement.month_list',$param);

    }



    # 個人別勤怠管理一覧 ------------------------------
    public function person_list()
    {
        $Ymd = date('Y/m/d',time()); //今日の日付
        $DI = new DateItems;
        $date_item = $DI->getThisMonth($Ymd);

        $param=[
            //表示ページ
            'app_menu_current' => 'person_list',
            //セレクト要素
            'select_items' => $this->getSelectItems($Ymd),
            //入力内容
            'input' => '',
            //表示内容の説明
            'display_text' => [
                'date' => $date_item['Ym_text'],
                'employee' => null,
            ],
            //出勤レコードの取得
            'worked_records' => null,
        ];
        return view('attendance_manegement.person_list',$param);
    }

    //検索表示
    public function person_list_search(Request $request)
    {
        $Ymd = $request->y_month.'/01'; //リクエストされた日付
        $DI = new DateItems;
        $date_item = $DI->getThisMonth($Ymd);

        //合計勤務時間 等
        $TotalRestrainTime =
        Work::personList($request->employee_id, $date_item['first_Ymd'], $date_item['last_Ymd'])->sum('RestrainTime');
        $TotalBreakTime =
        Work::personList($request->employee_id, $date_item['first_Ymd'], $date_item['last_Ymd'])->sum('BreakTime');
        $TotalWorkingTime =
        Work::personList($request->employee_id, $date_item['first_Ymd'], $date_item['last_Ymd'])->sum('WorkingTime');

        $param=[
            //表示ページ
            'app_menu_current' => 'person_list',
            //セレクト要素
            'select_items' => $this->getSelectItems($Ymd),
            //入力内容
            'input' => $request->all(),
            //表示内容の説明
            'display_text' => [
                'date' => $date_item['Ym_text'],
                'employee' => Employee::find($request->employee),
            ],
            //出勤レコードの取得
            'worked_records' =>
            Work::personList($request->employee, $date_item['first_Ymd'], $date_item['last_Ymd'])
            ->with('employee')->with('work_breaks')->get(),

            // 合計勤務時間 等
            'TotalRestrainTime' => sprintf('%d:%02d',floor($TotalRestrainTime/(60*60) ), floor($TotalRestrainTime%(60*60)/60 ) ),
            'TotalBreakTime' => sprintf('%d:%02d',floor($TotalBreakTime/(60*60) ), floor($TotalBreakTime%(60*60)/60 ) ),
            'TotalWorkingTime' => sprintf('%d:%02d',floor($TotalWorkingTime/(60*60) ), floor($TotalWorkingTime%(60*60)/60 ) ),

        ];
        return view('attendance_manegement.person_list',$param);
    }



    # 印刷PDF  ------------------------------
    public function print(Request $request)
    {
        // ダミーデータ設定
        $param = [];

        // PDF 生成メイン　－　A4 縦に設定
        $pdf = new TCPDF("P", "mm", "A4", true, "UTF-8" );
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // PDF プロパティ設定
        $pdf->SetTitle('Title aiueo あいうえお');  // PDFドキュメントのタイトルを設定
        $pdf->SetAuthor('Author aiueo あいうえお');  // PDFドキュメントの著者名を設定
        $pdf->SetSubject('Subject aiueo あいうえお');  // PDFドキュメントのサブジェクト(表題)を設定
        $pdf->SetKeywords('KEY1 KEY2 KEY3 あいうえお'); // PDFドキュメントのキーワードを設定
        $pdf->SetCreator('Creator aiueo あいうえお');  // PDFドキュメントの製作者名を設定

        // 日本語フォント設定
        $pdf->setFont('kozminproregular','',10);

        // ページ追加
        $pdf->addPage();

        // HTMLを描画、viewの指定と変数代入 - pdf_test.blade.php
        $pdf->writeHTML(
            view('attendance_manegement.print', $param
        )->render());

        // 出力指定 ファイル名、拡張子、D(ダウンロード)
        $pdf->output('test' . '.pdf', 'I');
        return;
    }




    # -------------- methods ---------------------

    # セレクト要素取得メソッド
    public function getSelectItems($Ymd)
    {
        # 日付アイテムの取得
        $dob = new DateItems;
        // 今の日付アイテム
        $this_days = $dob->getThisMonth(date('Y/m/d',time()));
        // リクエストされた日付のアイテム
        $select_days = $dob->getThisMonth($Ymd);


        # '年月'のセレクトアイテム
        $Ym_items = array([
            'value' => $this_days['Ym'],
            'text' => $this_days['Ym_text'],
            'selected' => $this_days['Ym'] == $select_days['Ym']? true: false,
        ]);
        for ($m=1; $m < 12; $m++)
        {
            $befor_days = $dob->getBeforMonth($this_days['Ymd'],$m);
            $item = [
                'value' => $befor_days['Ym'],
                'text' => $befor_days['Ym_text'],
                'selected' => $befor_days['Ym'] == $select_days['Ym']? true: false,
            ];
            array_push($Ym_items,$item);

        }


        # '日付'のセレクトアイテム
        $d_items = [];
        for ($d=1; $d <= $select_days['last_d']; $d++) {
            $item = [
                'value' => $d,
                'text' =>  $d.'日',
                'selected' =>  $d == $select_days['d']? true: false,
            ];
            array_push($d_items,$item);
        }


        return [
            'y_month' => $Ym_items, //'年月'
            'date' => $d_items, //'日付'
            'place' => Checkbox::where('group','所属部署')->get(), //'勤務地'
            'employee' => Employee::all(), //`従業員`
        ];
    }
}
