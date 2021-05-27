<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;

class HelloController extends Controller
{
    public function list(){
        $items = Employee::all(); //DB情報の取得
        $parm=['items' => $items];
        $view = view('test.list',$parm);
        return $view;
    }
    public function detail(Request $request){
        $item = Employee::find($request->id);
        $parm=['item' => $item];
        $view = view('test.detail',$parm);
        return $view;
    }


    #フォームの利用
    public function form(Request $request){
        $msg = $request->msg ?? '入力してください';

        if($request->msg == '送信')
        {
            return '送信しました';
        }
        else
        {
            $data = [
                'msg' => $msg,
            ];
            $view = view('test.form',$data);
            return $view;
        }
    }

}
