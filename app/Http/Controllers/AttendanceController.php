<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\carbon;


class AttendanceController extends Controller
{
    # method-------------------------------------------------------------
    //従業員指定がない時の従業員番号（後にログイン者の番号に変更）
    public static function getStanderdEmployee(){ return 1;}

    # end method---------------------------------------------------------


    # 勤怠管理へのアクセス
    public function index()
    {
        $month = Carbon::parse('today')->format('Y-m');
        $day = Carbon::parse('today')->day;
        $employee = self::getStanderdEmployee();

        //'date_list'へredirect
        return redirect()->route('attendance.date_list',compact('month','day','employee'));
        // return 'attendance'.$employee;
    }

    # 表示内容の変更(change)
    public function change()
    {
        return 'change';
    }

    // --- 一覧ページの表示 ---------------------------
    # 日別勤怠管理一覧(date_list)
    public function date_list($month,$day,$employee)
    {
        return view('attendance.date_list',compact('month','day','employee'));

    }

    # 月別勤怠管理一覧(month_list)
    # 個人別勤怠管理一覧(person_list)

    # 日別勤怠管理印刷(print_date_list)
    # 月別勤怠管理印刷(print_month_list)
    # 個人別勤怠管理印刷(print_person_list)

    # 勤怠修正一覧(admin)
    # 修正入力(edit)
    # 修正内容保存(update)
    # 削除(delete)
    # 新規挿入(insert)
}
