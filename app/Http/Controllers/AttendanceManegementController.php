<?php

namespace App\Http\Controllers;
use App\Models\Employee; //モデルの利用

use Illuminate\Http\Request;

class AttendanceManegementController extends Controller
{
    # 勤怠管理一覧TOPの表示
    public function index()
    {
        $param=[
            //表示中メニュー
            'app_menu_current' => 'date_list',
        ];
        return view('attendance_manegement.date_list',$param);
    }

    # 日別勤怠管理一覧の表示
    public function date_list(Request $request)
    {
        $param=[
            //表示中メニュー
            'app_menu_current' => 'date_list',
        ];
        return view('attendance_manegement.date_list',$param);
    }


    # 月別勤怠管理一覧の表示
    public function month_list(Request $request)
    {
        $param=[
            //表示中メニュー
            'app_menu_current' => 'month_list',
        ];
        return view('attendance_manegement.month_list',$param);
    }


    # 個人別勤怠管理一覧の表示
    public function person_list(Request $request)
    {
        $param=[
            //表示中メニュー
            'app_menu_current' => 'person_list',
        ];
        return view('attendance_manegement.person_list',$param);
    }



}
