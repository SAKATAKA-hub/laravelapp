<?php

namespace App\Http\Controllers;
use App\Models\Employee; //モデルの利用
use App\Models\Checkbox; //モデルの利用
use Illuminate\Http\Request;

use Carbon\carbon;

class TestController extends Controller
{
    # testページの表示
    public function test(){
        $date = Carbon::parse('now');

        $date_format = $date->format('Y年m月d日');
        return "<h1>$date_format</h1>";
        // $data = [];
        // return view('test.test',$data);
    }






    //ポストのうけとり
    public function post(Request $request)
    {
        if($file = $request->file('image'))
        {
            $file_name = $file->getClientOriginalName();
            $target_path = public_path('/image/test');
            $file->move($target_path, $file_name);


            $html = "<div>".$file_name."ファイルを受け取りました。</div>";
        }
        else
        {
            $html = "<p>受取りデータはありません</p> ";
        }


        return $html;
    }






    # 従業員一覧ページの表示
    //一覧ページの表示
    public function list(){
        $items = Employee::all(); //DB情報の取得

        $data=[
            'items' => $items,
            'CheckGroups' =>  Checkbox::getCheckboxs(),
        ];
        return view('test.list',$data);
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

    //テンプレートの読み込み
    public function base(){
        $data=[
            'current' => '1',
        ];

        return view('employee_list.base',$data);
    }




}
