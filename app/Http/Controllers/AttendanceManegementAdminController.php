<?php

namespace App\Http\Controllers;

#フォームリクエストの利用
use Illuminate\Http\Request;
use App\Http\Requests\AttendanceRequest;

# モデルの利用
use App\Models\Employee;
use App\Models\Work;
use App\Models\WorkBreak;
use App\Models\Checkbox;

// 日付クラスの利用
use App\Http\Controllers\library\DateItems;


// ＊AttendanceManegementController　を継承
class AttendanceManegementAdminController extends AttendanceManegementController
{
    # 勤怠修正一覧
    public function admin()
    {
        $Ymd = date( 'Y/m/d',time() ); //今日の日付
        $place ='';

        $param = AttendanceManegementController::getDateListParam($Ymd, $place);
        $param['app_menu_current'] = 'admin';

        return view('attendance_manegement.admin',$param);
    }

    public function admin_search(Request $request)
    {
        $Ymd = $request->y_month.'/'.$request->date; //リクエストされた日付
        $place = $request->place;

        $param = AttendanceManegementController::getDateListParam($Ymd, $place);
        $param['app_menu_current'] = 'admin';

        return view('attendance_manegement.admin',$param);
    }


    # 修正入力
    public function edit(Work $work)
    {
        $Ymd = str_replace('-','/',$work->date);
        $DI = new DateItems;
        $date_item = $DI->getThisMonth($Ymd);


        $param = [
            'date' => $date_item['Ymd_text'],
            'app_menu_current' => 'admin',
            'work' => $work,
            'places' => Checkbox::where('group','所属部署')->get(),
        ];
        return view('attendance_manegement.edit',$param);
    }


    # 修正内容保存
    public function update(AttendanceRequest $request,Work $work)
    {
        //時間を'秒単位'に変換する関数
        function changeTime($time){
            return !$time? 0: substr( $time, 0,2)*60*60 + substr( $time, 2,2)*60;
        }

        //入力値の加工
        $update_data = [
            'in' => changeTime($request['in']),
            'out' =>empty($request['out'])? NULL: changeTime($request['out']),
        ];

        $break_time = 0;
        for ($i=1; $i <= 4 ; $i++) {
            $update_data['break_id'.$i] = $request['break_id'.$i];

            $update_data['break_in'.$i] = changeTime($request['break_in'.$i]);

            $update_data['break_out'.$i] = empty($request['break_out'.$i])? NULL :changeTime($request['break_out'.$i]);

            $update_data['break_time'.$i] =  empty($request['break_out'.$i])? NULL
            : ceil(  ($update_data['break_out'.$i] -  $update_data['break_in'.$i])/15/60  )*15*60;
            $break_time += $update_data['break_time'.$i] ?? 0;

        }

        //※出勤は15繰上げ、退勤は15分繰り下げて計算する。
        $update_data['RestrainTime'] = empty($request['out'])? NULL
        : ( floor( $update_data['out']/15/60 ) - ceil( $update_data['in']/15/60 ) )*15*60;

        $update_data['BreakTime'] = empty($request['out'])? NULL: $break_time;

        $update_data['WorkingTime'] = empty($request['out'])? NULL
        : $update_data['RestrainTime'] - $update_data['BreakTime'];


        // bleakレコードの保存
        for ($i=1; $i <= 4 ; $i++) {
            if( $request['break_id'.$i] )  //bleakレコードが存在するかどうか
            {
                // 休憩時間の更新
                if( !$request->exists('break_delete'.$i) )  //'break_delete'ボタンが押されているかどうか
                {
                    $break = WorkBreak::find( $request['break_id'.$i] );
                    $break->in = $update_data['break_in'.$i];
                    $break->out = $update_data['break_out'.$i];
                    $break->total_time = $update_data['break_time'.$i];
                    $break->save();
                }
                // 休憩の削除
                else
                {
                    WorkBreak::find( $request['break_id'.$i] )->delete();
                }
            }
            // 休憩の新規挿入
            else
            {
                if( !$request->exists('break_delete'.$i) )
                {
                    $break =  new WorkBreak;
                    $break->work_id = $work->id;
                    $break->in = $update_data['break_in'.$i];
                    $break->out = $update_data['break_out'.$i];
                    $break->total_time = $update_data['break_time'.$i];
                    $break->save();
                }
            }
        }

        // workレコードの保存
        $work->place = $request['place'];
        $work->in = $update_data['in'];
        $work->out = $update_data['out'];

        $work->RestrainTime = $update_data['RestrainTime'];
        $work->BreakTime = $update_data['BreakTime'];
        $work->WorkingTime = $update_data['WorkingTime'];
        $work->save();

        return redirect()->route('attendance_manegement.admin');
    }

    # 削除
    public function destroy(Work $work)
    {
        $work -> delete();
        return redirect()->route('attendance_manegement.admin');
    }











    # 挿入 create (テスト用)
    public function create()
    {
        $work_id = Work::where('id','>=',0)->orderBy('id','desc')->first()->id +1;

        $work = new Work();
        $work->id = $work_id;
        $work->employee_id = 6;
        $work->date = date('Y-m-d',time());
        $work->place = '東京支店';
        $work->in = 8*60*60;
        $work->out = 17*60*60;
        $work->save();

        $work_break = new WorkBreak();
        $work_break->work_id = $work_id;
        $work_break->in = 11*60*60;
        $work_break->out = 11*60*60 + 30*60;
        $work_break->total_time = 30*60;
        $work_break->save();

        $work_break = new WorkBreak();
        $work_break->work_id = $work_id;
        $work_break->in = 14*60*60;
        $work_break->out = 14*60*60 + 30*60;
        $work_break->total_time = 30*60;
        $work_break->save();

        return redirect()->route('attendance_manegement.admin');
    }



}
