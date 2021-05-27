<?php

namespace App\Http\Controllers;
use App\Models\Employee; //モデルの利用
use Illuminate\Http\Request;

class TestController extends Controller
{
    # testページの表示
    //ページの表示
    public function test(){
        $data = [];
        return view('test.test',$data);
    }

    //ポストのうけとり
    public function post(Request $request){
        $true = "<div>「 $request->post 」を受け取りました。</div>";
        $error ="<p>受取りデータはありません</p> ";

        $html = empty($request->post) ? $error : $true;

        return $html;
    }

    # 従業員一覧ページの表示
    //一覧ページの表示
    public function list(){
        $items = Employee::all(); //DB情報の取得
        $data=['items' => $items];
        $view = view('test.list',$data);
        return $view;
    }

    //絞り込み一覧ページの表示
    public function seachList(Request $request){
        // $items = Employee::seach($request->seach)->get(); //DB情報の取得
        // $data=['items' => $items];
        // $view = view('test.list',$data);

        $seachs_array =[
            'keyword' => $request->keyword,
            'department' => $request->department,
            'position' => $request->position,
            'gender' => $request->gender,
        ];
        $items = Employee::seach($seachs_array)->get(); //DB情報の取得

        $data=['items' => $items];
        $view = view('test.list',$data);
        return $view;
    }

    //詳細ページの表示
    public function detail(Request $request){
        $item = Employee::find($request->id);
        $parm=['item' => $item];
        $view = view('test.detail',$parm);
        return $view;
    }


}