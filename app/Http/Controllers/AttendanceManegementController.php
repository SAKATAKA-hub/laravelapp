<?php
namespace App\Http\Controllers;

use App\Models\WorkedRecord; //モデルの利用
use App\Http\Controllers\library\DateItems;// 日付クラスの利用

use Illuminate\Http\Request;

class AttendanceManegementController extends Controller
{
    # 日別勤怠管理一覧の表示
    public function date_list()
    {
        $Ymd = date('Y/m/d',time());
        $dob = new DateItems;
        // 今の日付アイテム
        $this_days = $dob->getThisMonth($Ymd );


        $param=[
            //表示中メニュー
            'app_menu_current' => 'date_list',

            'select_items' => $this->getSelectItems($Ymd),

            //表示内容
            'date_text' => '〇月☓日',
            'place' => '○○支店',


            //出勤情報
            'worked_records' => WorkedRecord::limit(10)->get(),
            // 'worked_records' => WorkedRecord::where('date',$date)->get(),
        ];
        return view('attendance_manegement.date_list',$param);
    }

    public function date_list_search(Request $request)
    {
        $param=[
            //表示中メニュー
            'app_menu_current' => 'date_list',
            //表示内容
            'date_text' => '〇月☓日',
            'place' => '○○支店',


            //出勤情報
            'worked_records' => WorkedRecord::limit(10)->get(),
            // 'worked_records' => WorkedRecord::where('date',$date)->get(),
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


    # -------------- 関数 ---------------------
    public function getSelectItems($Ymd)
    {
        $dob = new DateItems;
        // 今の日付アイテム
        $this_days = $dob->getThisMonth(date('Y/m/d',time()));

        // リクエストされた日付のアイテム
        $select_days = $dob->getThisMonth($Ymd);

        # '年月'のセレクトアイテム
        $Ym_items = array([
            'value' => $this_days['Ym'],
            'text' => $this_days['Ym_text'],
            'selected' => false,
        ]);
        for ($m=1; $m < 12; $m++)
        {
            $befor_days = $dob->getBeforMonth($this_days['Ymd'],$m);
            $Ym_items += [
                'value' => $befor_days['Ym'],
                'text' => $befor_days['Ym_text'],
                'selected' => $befor_days['Ym'] == $select_days['Ym']? true: false,
            ];

        }

        return $Ym_items;
    }
}
