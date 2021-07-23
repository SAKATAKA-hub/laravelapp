<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use Carbon\carbon;

# モデルの利用
use App\Models\Employee;
use App\Models\Work;
use App\Models\WorkBreak;


class TimeCardMethod //extends Controller
{

    #　n分区切りで勤務時間を計算(n = 15)
    public static function getCutTime()
    {
        return 15*60; //(秒)
    }




    # 現在の打刻時間を取得するメソッド
    public static function getNowSeconds()
    {
        $time = date("H:i",time());
        list($H,$i) = explode(':',$time);
        return $H*60*60 + $i*60;
    }



    # 現在の出勤状況を取得するメソッド
    public static function getWorkStatus($employee)
    {
        // 直近の出勤記録
        $work = Work::where('employee_id',$employee)->orderBy('id','desc')->first(); //出勤記録
        $work = isset($work) ? $work : 'NoWork';
        $work_break = ($work !== 'NoWork')? $work->work_breaks()->orderBy('id','desc')->first() :'NoBreak';
        $work_break = isset($work_break) ? $work_break : 'NoBreak';

        //現在の出勤状況
        if( ($work_break !== 'NoBreak') && empty($work_break->out) )
        {
            $work_status = 'break';
        }
        else if( ($work !== 'NoWork') && empty($work->out) )
        {
            $work_status = 'in';
        }
        else
        {
            $work_status = 'out';
        }

        return [$work_status, $work];
    }



    # 打刻中に外部から別のアクセスがあったとき、エラー表示を行うメソッド
    public static function checkWorkStatusError($befor_input,$place,$employee)
    {
        list($work_status,$work_id) = self::getWorkStatus($employee);
        if($work_status === $befor_input)
        {
            return true;
        }
        else
        {
            return false;
        }
    }




    # 勤務開始の登録メソッド
    public static function WorkIN($place,$employee,$date,$time)
    {
        $work = new Work();
        $work->employee_id = $employee;
        $work->date = $date;
        $work->place = $place;
        $work->in = $time;
        $work->save();

        return $work;
    }




    #休憩開始の登録メソッド
    public static function WorkBreakIN($work,$time)
    {
        $work_break = new WorkBreak();
        $work_break->work_id = $work->id;
        $work_break->in = $time;
        $work_break->save();
    }




    #休憩終了の登録メソッド
    public static function WorkBreakOut($work,$time)
    {
        // $cut_time分区切りで時間計算
        $cut_time = self::getCutTime();

        // 直近の休憩記録の取得
        $work_break = $work->work_breaks()->orderBy('id','desc')->first(); //休憩記録

        $work_break->out = $time;
        $work_break->total_time = ceil( ($work_break->out - $work_break->in)/$cut_time )*$cut_time;
        $work_break->save();
    }




    #勤務終了の登録メソッド
    public static function WorkOut($work,$time)
    {
        // $cut_time分区切りで時間計算
        $cut_time = self::getCutTime();

        // 直近の休憩記録の取得(休憩が無ければ'NoBreak')
        $work_break = $work->work_breaks()->orderBy('id','desc')->first(); //休憩記録
        $work_break = isset($work_break) ? $work_break : 'NoBreak';


        $work->out = $time;
        $work_out = floor($work->out/$cut_time)*$cut_time;
        $work_in = ceil($work->in/$cut_time)*$cut_time;

        $work->RestrainTime = $work_out - $work_in;
        $work->BreakTime = $work_break!='NoBreak' ? $work->work_breaks()->sum('total_time') : 0;
        $work->WorkingTime = $work->RestrainTime - $work->BreakTime;
        $work->save();
    }




    # "アラートに表示するメッセージ内容"を取得するメソッド
    public static function getAlertMessage($input)
    {
        switch ($input) {
            case 'work_in': $message = '勤務開始を確認しました。\n『おはようございます。』'; break;

            case 'work_break_in': $message = '休憩開始を確認しました。\n『いってらっしゃいませ。』'; break;

            case 'work_break_out': $message = '休憩終了を確認しました。\n『おかえりなさいませ』'; break;

            case 'work_out': $message = '勤務終了を確認しました。\n『おつかれさまでした。』'; break;

            case 'work_error': $message = 'エラー：打刻時に外部からのアクセスが実行されたため、打刻入力がキャンセルされました。'; break;

            default: $message = ''; break;
        }

        return $message;
    }
}
