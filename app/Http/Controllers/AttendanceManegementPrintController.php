<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Work;
use App\Models\Checkbox;

use App\Http\Controllers\library\DateItems;// 日付クラスの利用
use Illuminate\Http\Request;
use TCPDF;
use TCPDF_FONTS;

// ＊AttendanceManegementController　を継承
class AttendanceManegementPrintController extends AttendanceManegementController
{
    # 日別勤怠管理印刷
    public function print_date_list(Request $request)
    {
        $Ymd = $request->Ymd; //＊リクエストされた日付
        $place = $request->place;
        $param = AttendanceManegementController::getDateListParam($Ymd, $place);

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
        $Ymd = $request->Ymd; //＊リクエストされた日付
        $place = $request->place;
        $param = AttendanceManegementController::getMonthListParam($Ymd, $place);

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
        $Ymd = $request->Ymd; //＊リクエストされた日付
        $employee_id = $request->employee_id;
        $param = AttendanceManegementController::getPersonListParam($Ymd, $employee_id);

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





}
