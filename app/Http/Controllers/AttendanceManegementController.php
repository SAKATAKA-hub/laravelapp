<?php
namespace App\Http\Controllers;

# モデルの利用
use App\Models\Employee;
use App\Models\Work;
use App\Models\Checkbox;

use App\Http\Controllers\library\DateItems;// 日付クラスの利用
use Illuminate\Http\Request;

class AttendanceManegementController extends Controller
{
    # 日別勤怠管理一覧 ------------------------------
    public function date_list()
    {
        $Ymd = date( 'Y/m/d',time() ); //今日の日付
        $place ='';
        $param = $this->getDateListParam($Ymd, $place);


        return view('attendance_manegement.date_list',$param);
    }

    // 検索表示
    public function date_list_search(Request $request)
    {
        $Ymd = $request->y_month.'/'.$request->date; //リクエストされた日付
        $place = $request->place;
        $param = $this->getDateListParam($Ymd, $place);

        return view('attendance_manegement.date_list',$param);
    }

        //paramの取得
        public function getDateListParam($Ymd, $place)
        {
            $DI = new DateItems;
            $date_item = $DI->getThisMonth($Ymd);

            //合計勤務時間 等
            $TotalRestrainTime = Work::dateList($Ymd,$place)->sum('RestrainTime');
            $TotalBreakTime = Work::dateList($Ymd,$place)->sum('BreakTime');
            $TotalWorkingTime = Work::dateList($Ymd,$place)->sum('WorkingTime');

            return [
                //表示ページ
                'app_menu_current' => 'date_list',

                //セレクト要素
                'select_items' => $this->getSelectItems($Ymd),

                //表示レコード内容
                'date' => $date_item['Ym_text'],
                'place' => $place,

                //出勤レコードの取得
                'worked_records' =>
                Work::dateList($Ymd,$place)->with('employee')->with('work_breaks')->get(),

                // 合計勤務時間 等
                'TotalRestrainTime' => sprintf('%d:%02d',floor($TotalRestrainTime/(60*60) ), floor($TotalRestrainTime%(60*60)/60 ) ),
                'TotalBreakTime' => sprintf('%d:%02d',floor($TotalBreakTime/(60*60) ), floor($TotalBreakTime%(60*60)/60 ) ),
                'TotalWorkingTime' => sprintf('%d:%02d',floor($TotalWorkingTime/(60*60) ), floor($TotalWorkingTime%(60*60)/60 ) ),

                'Ymd' => $Ymd,
            ];
        }



    # 月別勤怠管理一覧 ------------------------------
    public function month_list()
    {
        $Ymd = date('Y/m/d',time()); //今日の日付
        $place = '';
        $param = $this->getMonthListParam($Ymd, $place);

        return view('attendance_manegement.month_list',$param);
    }

    // 検索表示
    public function month_list_search(Request $request)
    {
        $Ymd = $request->y_month.'/01'; //リクエストされた日付
        $place = $request->place;
        $param = $this->getMonthListParam($Ymd, $place);

        return view('attendance_manegement.month_list',$param);
    }

        //paramの取得
        public function getMonthListParam($Ymd, $place)
        {
            $DI = new DateItems;
            $date_item = $DI->getThisMonth($Ymd);

            //合計勤務時間 等
            $TotalRestrainTime =
            Work::monthList($date_item['first_Ymd'], $date_item['last_Ymd'], $place)->sum('RestrainTime');
            $TotalBreakTime =
            Work::monthList($date_item['first_Ymd'], $date_item['last_Ymd'], $place)->sum('BreakTime');
            $TotalWorkingTime =
            Work::monthList($date_item['first_Ymd'], $date_item['last_Ymd'], $place)->sum('WorkingTime');

            return [
                //表示ページ
                'app_menu_current' => 'month_list',

                //セレクト要素
                'select_items' => $this->getSelectItems($Ymd),

                //表示レコード内容
                'date' => $date_item['Ym_text'],
                'place' => $place,

                //出勤レコードの取得
                'worked_records' =>
                Work::monthList($date_item['first_Ymd'], $date_item['last_Ymd'], $place)
                ->with('employee')->with('work_breaks')->get(),

                // 合計勤務時間 等
                'TotalRestrainTime' => sprintf('%d:%02d',floor($TotalRestrainTime/(60*60) ), floor($TotalRestrainTime%(60*60)/60 ) ),
                'TotalBreakTime' => sprintf('%d:%02d',floor($TotalBreakTime/(60*60) ), floor($TotalBreakTime%(60*60)/60 ) ),
                'TotalWorkingTime' => sprintf('%d:%02d',floor($TotalWorkingTime/(60*60) ), floor($TotalWorkingTime%(60*60)/60 ) ),

                'Ymd' => $Ymd,
            ];
        }



    # 個人別勤怠管理一覧 ------------------------------
    public function person_list()
    {
        $Ymd = date('Y/m/d',time()); //今日の日付
        $employee_id = '';
        $param = $this->getPersonListParam($Ymd, $employee_id);

        return view('attendance_manegement.person_list',$param);
    }

    //検索表示
    public function person_list_search(Request $request)
    {
        $Ymd = $request->y_month.'/01'; //リクエストされた日付
        $employee_id = $request->employee_id;
        $param = $this->getPersonListParam($Ymd, $employee_id);

        return view('attendance_manegement.person_list',$param);
    }

        //paramの取得
        public function getPersonListParam($Ymd, $employee_id)
        {
            $DI = new DateItems;
            $date_item = $DI->getThisMonth($Ymd);

            //合計勤務時間 等
            $TotalRestrainTime =
            Work::personList($employee_id, $date_item['first_Ymd'], $date_item['last_Ymd'])->sum('RestrainTime');
            $TotalBreakTime =
            Work::personList($employee_id, $date_item['first_Ymd'], $date_item['last_Ymd'])->sum('BreakTime');
            $TotalWorkingTime =
            Work::personList($employee_id, $date_item['first_Ymd'], $date_item['last_Ymd'])->sum('WorkingTime');

            return [
                //表示ページ
                'app_menu_current' => 'person_list',

                //従業員ID
                'employee_id' => $employee_id,

                //セレクト要素
                'select_items' => $this->getSelectItems($Ymd),

                //表示レコード内容
                'date' => $date_item['Ym_text'],
                'employee' => Employee::find($employee_id),

                //出勤レコードの取得
                'worked_records' =>
                Work::personList($employee_id, $date_item['first_Ymd'], $date_item['last_Ymd'])
                ->with('employee')->with('work_breaks')->get(),

                // 合計勤務時間 等
                'TotalRestrainTime' => sprintf('%d:%02d',floor($TotalRestrainTime/(60*60) ), floor($TotalRestrainTime%(60*60)/60 ) ),
                'TotalBreakTime' => sprintf('%d:%02d',floor($TotalBreakTime/(60*60) ), floor($TotalBreakTime%(60*60)/60 ) ),
                'TotalWorkingTime' => sprintf('%d:%02d',floor($TotalWorkingTime/(60*60) ), floor($TotalWorkingTime%(60*60)/60 ) ),

                'Ymd' => $Ymd,
            ];
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
