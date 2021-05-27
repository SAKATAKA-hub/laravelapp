<?php

namespace App\Http\Controllers;
use App\Models\Employee; //モデルの利用
use App\Models\Checkbox; //モデルの利用
use Illuminate\Http\Request;

class EmployeeListController extends Controller
{
    # 従業員一覧ページの表示
    //一覧ページの表示
    public function index()
    {
        $data=[
            //従業員情報
            'employees' => Employee::all(),
            //検索単語
            'seach_woord' => '',
            //チェックボックスの表示内容
            'check_departments' => Checkbox::where('group','所属部署')->get(),
            'check_positions' => Checkbox::where('group','役職')->get(),
            'check_genders' => Checkbox::where('group','性別')->get(),
        ];
        return view('employee_list.index',$data);
    }

    # 従業員一覧ページ(検索)の表示
    public function search(Request $request)
    {
        //検索キーワード
        $seachs_array = [
            'keyword' => $request->keywords,
            'department' => $request->departments,
            'position' => $request->positions,
            'gender' => $request->genders,
        ];

        $data=[
            //従業員情報
            'employees' => Employee::seach($seachs_array)->get(),
            //検索単語
            'seach_woord' => $request->keywords,
            //チェックボックスの表示内容
            'check_departments' => Checkbox::where('group','所属部署')->get(),
            'check_positions' => Checkbox::where('group','役職')->get(),
            'check_genders' => Checkbox::where('group','性別')->get(),
        ];
        return view('employee_list.index',$data);

    }

    // 従業員詳細ページ
    public function detail(Request $request)
    {
        $employee = Employee::find($request->id); //DB情報の取得
        $data=['employee' => $employee,];
        return view('employee_list.detail',$data);
    }





    # 従業員一覧 / 管理者画面ページ
    public function admin(){
        return view('employee_list.admin');
    }

    # 従業員一覧 / 管理者画面 /　新規登録ページ
    public function insert(){
        return view('employee_list.insert');
    }

    # 従業員一覧 / 管理者画面 /　新規登録ページ
    public function update(){
        return view('employee_list.update');
    }


}
