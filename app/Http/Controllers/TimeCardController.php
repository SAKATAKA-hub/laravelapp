<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\carbon;

# モデルの利用
use App\Models\Employee;
use App\Models\Work;
use App\Models\WorkBreak;
// use App\Models\Checkbox;


class TimeCardController extends Controller
{


    # == タイムカードへのアクセス ===========================================
    # タイムカードトップ
    public function index($input,$place,$employee)
    {
        // 現在の出勤状態、直近の出勤・休憩記録の取得
        list($work_status, $work) = TimeCardMethod::getWorkStatus($employee);


        // アラートに表示するメッセージ内容
        $message = TimeCardMethod::getAlertMessage($input);

        //-- View the blade template --
        return view('time_card.index')
        ->with(compact('message','place','employee','work_status','work'));
    }


    #従業員の変更(change_employee)
    public function change_employee(Request $request)
    {
        // -- Redirect to 'index' --
        return redirect()->route('time_card.index',[
            'input' => 'no_input',
            'place' => Employee::find($request->employee)->department,
            'employee' => $request->employee,
        ]);
    }


    #出勤現場の変更(change_place)
    public function change_place(Request $request)
    {
        //-- Redirect to 'index' --
        return redirect()->route('time_card.index',[
            'input' => 'no_input',
            'place' => $request->place,
            'employee' => $request->employee,
        ]);
    }




    # == タイムカードの入力処理 ===========================================

    # 勤務開始(work_in) --------------------------------------
    public function work_in($place,$employee)
    {
        # 設定
        $time = TimeCardMethod::getNowSeconds(); //打刻時間
        $today = Carbon::parse('today')->format('Y-m-d'); //今日の日付
        $input = 'work_in'; //打刻内容
        $befor_input = 'out'; //打刻前の出勤状態

        # 打刻中に外部から別のアクセスがあったとき、元の画面に戻ってエラー表示を行う
        if( !TimeCardMethod::checkWorkStatusError($befor_input,$place,$employee) )
        {
            $input = 'work_error';
            return redirect()->route('time_card.index',  compact('place','employee','input') );
        }

        # 勤務開始の登録
        $work = TimeCardMethod::WorkIN($place,$employee,$today,$time);


        #-- Redirect to 'index' --
        return redirect()->route('time_card.index', compact('place','employee','input') );
    }



    # 休憩開始(work_break_in)  --------------------------------------
    public function work_break_in($place, $employee, Work $work)
    {
        # 設定
        $time = TimeCardMethod::getNowSeconds(); //打刻時間
        $today = Carbon::parse('today')->format('Y-m-d'); //今日の日付
        $input = 'work_break_in'; //打刻内容
        $befor_input = 'in'; //打刻前の出勤状態

        # 打刻中に外部から別のアクセスがあったとき、元の画面に戻ってエラー表示を行う
        if( !TimeCardMethod::checkWorkStatusError($befor_input,$place,$employee) )
        {
            $input = 'work_error';
            return redirect()->route('time_card.index',  compact('place','employee','input') );
        }

        #　出勤記録が日を跨いでいる時の処理（入力された打刻以前の処理）
        if($work->date !== $today)
        {
            $text="";
            //出勤日と入力日の日付差
            $diff = carbon::parse($work->date)->diffInDays( carbon::parse($today) );
            for ($i = $diff; $i >= 0 ; $i--)
            {
                # 出勤日の処理
                if($i == $diff)
                {
                    TimeCardMethod::WorkOut($work,24*60*60); // 勤務終了登録
                }
                # 今日の処理
                elseif($i == 0)
                {
                    $today = Carbon::parse('today')->format('Y-m-d'); //今日の日付
                    $work = TimeCardMethod::WorkIN($place,$employee,$today,0); //勤務開始登録
                }
                # 間日の処理
                else{
                    $befor_date = Carbon::parse('today')->subday($i)->format('Y-m-d'); //($i)日前の日付
                    $work = TimeCardMethod::WorkIN($place,$employee,$befor_date,0); //勤務開始登録
                    TimeCardMethod::WorkOut($work,24*60*60);//勤務終了登録

                }
            } //endfor

        } //endif


        # 本日の休憩開始登録
        TimeCardMethod::WorkBreakIN($work,$time);


        #-- Redirect to 'index' --
        return redirect()->route('time_card.index', compact('place','employee','input') );
    }



    # 休憩終了(work_break_out)  --------------------------------------
    public function work_break_out($place, $employee, Work $work)
    {
        # 設定
        $time = TimeCardMethod::getNowSeconds(); //打刻時間
        $today = Carbon::parse('today')->format('Y-m-d'); //今日の日付
        $input = 'work_break_out'; //打刻内容
        $befor_input = 'break'; //打刻前の出勤状態

        # 打刻中に外部から別のアクセスがあったとき、元の画面に戻ってエラー表示を行う
        if( !TimeCardMethod::checkWorkStatusError($befor_input,$place,$employee) )
        {
            $input = 'work_error';
            return redirect()->route('time_card.index',  compact('place','employee','input') );
        }

        #　出勤記録が日を跨いでいる時の処理（入力された打刻以前の処理）
        if($work->date !== $today)
        {
            $text="";
            //出勤日と入力日の日付差
            $diff = carbon::parse($work->date)->diffInDays( carbon::parse($today) );
            for ($i = $diff; $i >= 0 ; $i--)
            {
                # 出勤日の処理
                if($i == $diff)
                {
                    TimeCardMethod::WorkBreakOut($work,24*60*60);//休憩終了登録
                    TimeCardMethod::WorkOut($work,24*60*60); // 勤務終了登録
                }
                # 今日の処理
                elseif($i == 0)
                {
                    $today = Carbon::parse('today')->format('Y-m-d'); //今日の日付
                    $work = TimeCardMethod::WorkIN($place,$employee,$today,0); //勤務開始登録
                    TimeCardMethod::WorkBreakIN($work,0);//休憩開始登録
                }
                # 間日の処理
                else{
                    $befor_date = Carbon::parse('today')->subday($i)->format('Y-m-d'); //($i)日前の日付
                    $work = TimeCardMethod::WorkIN($place,$employee,$befor_date,0); //勤務開始登録
                    TimeCardMethod::WorkBreakIN($work,0);//休憩開始登録
                    TimeCardMethod::WorkBreakOut($work,24*60*60);//休憩終了登録
                    TimeCardMethod::WorkOut($work,24*60*60);//勤務終了登録
                }
            } //endfor

        } //endif


        # 本日の休憩終了登録
        TimeCardMethod::WorkBreakOut($work,$time);

        //-- Redirect to 'index' --
        return redirect()->route('time_card.index', compact('place','employee','input') );
    }



    # 勤務終了(work_out)  --------------------------------------
    public function work_out($place, $employee, Work $work)
    {
        # 設定
        $time = TimeCardMethod::getNowSeconds(); //打刻時間
        $today = Carbon::parse('today')->format('Y-m-d'); //今日の日付
        $input = 'work_out'; //打刻内容
        $befor_input = 'in'; //打刻前の出勤状態

        # 打刻中に外部から別のアクセスがあったとき、元の画面に戻ってエラー表示を行う
        if( !TimeCardMethod::checkWorkStatusError($befor_input,$place,$employee) )
        {
            $input = 'work_error';
            return redirect()->route('time_card.index',  compact('place','employee','input') );
        }

        #　出勤記録が日を跨いでいる時の処理（入力された打刻以前の処理）
        if($work->date !== $today)
        {
            $text="";
            //出勤日と入力日の日付差
            $diff = carbon::parse($work->date)->diffInDays( carbon::parse($today) );
            for ($i = $diff; $i >= 0 ; $i--)
            {
                # 出勤日の処理
                if($i == $diff)
                {
                    TimeCardMethod::WorkOut($work,24*60*60); // 勤務終了登録
                }
                # 今日の処理
                elseif($i == 0)
                {
                    $today = Carbon::parse('today')->format('Y-m-d'); //今日の日付
                    $work = TimeCardMethod::WorkIN($place,$employee,$today,0); //勤務開始登録
                }
                # 間日の処理
                else{
                    $befor_date = Carbon::parse('today')->subday($i)->format('Y-m-d'); //($i)日前の日付
                    $work = TimeCardMethod::WorkIN($place,$employee,$befor_date,0); //勤務開始登録
                    TimeCardMethod::WorkOut($work,24*60*60);//勤務終了登録

                }
            } //endfor

        } //endif


        # 本日の勤務終了登録
        TimeCardMethod::WorkOut($work,$time);


        //-- Redirect to 'index' --
        return redirect()->route('time_card.index', compact('place','employee','input') );
    }




}
