<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Work;
use App\Models\Checkbox;

use App\Http\Controllers\library\DateItems;// 日付クラスの利用
use Illuminate\Http\Request;
use TCPDF;
use TCPDF_FONTS;


class AttendanceManegementPrintController extends Controller
{
    # 日別勤怠管理印刷
    public function print_date_list(Request $request)
    {
        //日付アイテムの作成
        $Ymd = $request->Ymd; //＊リクエストされた日付
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


        // PDF設定
        $pdf = $this->getTCPDF($Ymd);

        // PDF プロパティ設定
        $pdf->SetTitle('日別勤怠一覧印刷');  // PDFドキュメントのタイトルを設定
        $pdf->SetSubject('日別勤怠一覧印刷');  // PDFドキュメントのサブジェクト(表題)を設定

        // HTMLを描画、viewの指定と変数代入 - pdf_test.blade.php
        $pdf->writeHTML(
            view('attendance_manegement.print_date_list', $param)
        ->render());

        // 出力指定 ファイル名、拡張子、D(ダウンロード)
        $pdf->output('test' . '.pdf', 'I');
        return;
    }

    # 月別勤怠管理印刷
    public function print_month_list(Request $request)
    {
        //日付アイテムの作成
        $Ymd = $request->Ymd; //＊リクエストされた日付
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


        // PDF設定
        $pdf = $this->getTCPDF($Ymd);

        // PDF プロパティ設定
        $pdf->SetTitle('月別勤怠一覧印刷');  // PDFドキュメントのタイトルを設定
        $pdf->SetSubject('月別勤怠一覧印刷');  // PDFドキュメントのサブジェクト(表題)を設定

        // HTMLを描画、viewの指定と変数代入 - pdf_test.blade.php
        $pdf->writeHTML(
            view('attendance_manegement.print_date_list', $param)
        ->render());

        // 出力指定 ファイル名、拡張子、D(ダウンロード)
        $pdf->output('test' . '.pdf', 'I');
        return;
    }

    # 個人別勤怠管理印刷
    public function print_person_list(Request $request)
    {
        //日付アイテムの作成
        $Ymd = $request->Ymd; //＊リクエストされた日付
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

            //従業員ID
            'employee_id' => $request->employee_id,

            //セレクト要素
            'select_items' => $this->getSelectItems($Ymd),

            //表示内容の説明
            'display_text' => [
                'date' => $date_item['Ym_text'],
                'employee' => Employee::find($request->employee_id),
            ],

            //出勤レコードの取得
            'worked_records' =>
            Work::personList($request->employee_id, $date_item['first_Ymd'], $date_item['last_Ymd'])
            ->with('employee')->with('work_breaks')->get(),

            // 合計勤務時間 等
            'TotalRestrainTime' => sprintf('%d:%02d',floor($TotalRestrainTime/(60*60) ), floor($TotalRestrainTime%(60*60)/60 ) ),
            'TotalBreakTime' => sprintf('%d:%02d',floor($TotalBreakTime/(60*60) ), floor($TotalBreakTime%(60*60)/60 ) ),
            'TotalWorkingTime' => sprintf('%d:%02d',floor($TotalWorkingTime/(60*60) ), floor($TotalWorkingTime%(60*60)/60 ) ),

            'Ymd' => $Ymd,
        ];

        // PDF設定
        $pdf = $this->getTCPDF($Ymd);

        // PDF プロパティ設定
        $pdf->SetTitle('個人別勤怠一覧印刷');  // PDFドキュメントのタイトルを設定
        $pdf->SetSubject('個人別勤怠一覧印刷');  // PDFドキュメントのサブジェクト(表題)を設定

        // HTMLを描画、viewの指定と変数代入 - pdf_test.blade.php
        $pdf->writeHTML(
            view('attendance_manegement.print_person_list', $param)
        ->render());

        // 出力指定 ファイル名、拡張子、D(ダウンロード)
        $pdf->output('test' . '.pdf', 'I');
        return;

    }


    # -------------- methods ---------------------

    # TCPDFの設定
    public function getTCPDF()
    {
        // PDF 生成メイン　－　A4 縦に設定
        $pdf = new TCPDF("P", "mm", "A4", true, "UTF-8" );
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // 日本語フォント設定
        $pdf->setFont('kozminproregular','',10);

        // ページ追加
        $pdf->addPage();

        return $pdf;
    }



    # セレクト要素取得
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
