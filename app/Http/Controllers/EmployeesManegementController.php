<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest; //フォームリクエストの利用
use App\Models\Employee; //モデルの利用
use App\Models\Checkbox; //モデルの利用

use Illuminate\Http\Request;

class EmployeesManegementController extends Controller
{
    #1-1 従業員管理一覧
    public function index(Request $request)
    {
        // パラメーター取得
        $param = $this->get_admin_param($request);
        $param += [
            'app_menu_current' => 'index', //表示中メニュー
        ];
        return view('employees_manegement.index',$param);
    }



    #1-2 従業員詳細
    public function show(Employee $employee)
    {
        $param=[
            //表示中メニュー
            'app_menu_current' => 'index',
            //従業員情報
            'employee' => $employee,
        ];
        return view('employees_manegement.show',$param);
    }



    #2-1 管理者画面
    public function admin(Request $request)
    {
        // パラメーター取得
        $param = $this->get_admin_param($request);
        $param += [
            'app_menu_current' => 'admin', //表示中メニュー
            'mode' => '', //アラートの表示
        ];

        return view('employees_manegement.admin',$param);
    }

    //管理者画面(処理完了アラートの表示)
    public function admin_alert(Request $request,$mode)
    {
        // パラメーター取得
        $param = $this->get_admin_param($request);
        $param += [
            'app_menu_current' => 'admin', //表示中メニュー
            'mode' => $mode, //アラートの表示
        ];

        return view('employees_manegement.admin',$param);
    }




    #2-2 新規登録
    public function create(Request $request)
    {
        $getCheckboxs = Checkbox::getCheckboxs($request,'get');

        $param=[
            //表示中メニュー
            'app_menu_current' => 'admin',
            //最後に登録した'ID'番号の取得
            'employee' => ['id' => Employee::where('id','>=',0)->orderBy('id','desc')->first()->id +1,],
            //チェックボックスの表示内容
            'checkbox_groups' => $getCheckboxs['checkbox_groups'],
        ];
        return view('employees_manegement.create',$param);
    }

    // 新規登録完了
    public function insert(Request $request)
    {
        // 画像のアップロード
        $file_name = $this->uplode_image($request);

        // DBへ保存
        $employee = new Employee; //新規挿入
        $this->employee_upload($employee, $request, $file_name);

        $mode = 'insert';
        return redirect()->route('employees_manegement.admin_alert',$mode);
    }


    #2-3 登録情報編集
    public function edit(Employee $employee,Request $request)
    {
        $getCheckboxs = Checkbox::getCheckboxs($request,'get');

        $param=[
            //表示中メニュー
            'app_menu_current' => 'admin',
            //最後に登録した'ID'番号の取得
            'employee' => $employee,
            //チェックボックスの表示内容
            'checkbox_groups' => $getCheckboxs['checkbox_groups'],
        ];
        return view('employees_manegement.edit',$param);
    }

    // 編集登録完了
    public function update(Request $request)
    {
        // 画像のアップロード
        $file_name = $this->uplode_image($request);

        // DBへ保存
        $employee = Employee::find($request->id); //上書き
        $this->employee_upload($employee, $request, $file_name);

        $mode = 'update';
        return redirect()->route('employees_manegement.admin_alert',$mode);
    }


    #2-4 登録情報削除
    public function destroy(Employee $employee)
    {
        //画像の保存先取得
        $puth = $this->get_path();

        //従業員画像の削除
        $upload_path_name = public_path().sprintf('%s/%s',$puth['upload_path'],$employee->image);

        if(file_exists($upload_path_name)==true)
        {
            unlink($upload_path_name);
        }

        //DBレコードの削除
        $employee->delete();

        $mode = 'delete';
        return redirect()->route('employees_manegement.admin_alert',$mode);
    }


    #2-5 登録確認
    public function confirm(EmployeeRequest $request) //フォームリクエストの利用
    {
        $getCheckboxs = Checkbox::getCheckboxs($request,'get');

        //画像の保存先取得
        $puth = $this->get_path();

        if($file = $request->file('image'))
        {
            $file_name = sprintf('e%04d.%s', $request->id, $file->guessExtension() );
            $target_path = public_path($puth['comfirm_path']);
            $file->move($target_path, $file_name);
        }
        else
        {
            $file_name = '';
        }


        $param=[
            //表示中メニュー
            'app_menu_current' => 'admin',
            //入力内容
            'input' => $request->all(),
            //チェックボックスの表示内容
            'checkbox_groups' => $getCheckboxs['checkbox_groups'],

            //アップロードファイル関係
            'file_name' => $file_name,
            'file_path' => $puth['comfirm_path'],
        ];
        return view('employees_manegement.confirm',$param);
    }


    #--------------------------------------------------------------------------------------------
    # 共通メソッド
    #--------------------------------------------------------------------------------------------
    public function get_path(){
        return[
            'comfirm_path' => '/image/comfirm',
            'upload_path' => '/image/employees',
            'no_image' => 'e8888.png',
        ];
    }

    # 画像のアップロード
    public function uplode_image($request)
    {
        //画像の保存先取得
        $puth = $this->get_path();

        //画像の保存
        if($file_name = $request->file_name)
        {
            $comfirm_path_name = public_path().sprintf('%s/%s',$puth['comfirm_path'],$file_name);
            $upload_path_name = public_path().sprintf('%s/%s',$puth['upload_path'],$file_name);

            if($file = file_get_contents($comfirm_path_name))
            {
                file_put_contents($upload_path_name,$file); //本番ディレクトリに画像を保存
                unlink($comfirm_path_name); //一時保存画像の削除
            }
        }
        elseif($request->old_image)
        {
            $file_name = $request->old_image;
        }
        else
        {
            $file_name = $puth['no_image'];
        }

        return $file_name;

    }

    # DBへアップロード
    public function employee_upload($employee, $request, $file_name)
    {
        $employee->id = $request->id;
        $employee->name = $request->name;
        $employee->kana_name = $request->kana_name;
        $employee->image = $file_name ;

        $employee->department = $request->department;
        $employee->position = $request->position;
        $employee->gender = $request->gender;

        $employee->birthday = $request->birthday;
        $employee->tell = $request->tell;
        $employee->email = $request->email;

        $employee->save();
    }


    #管理者画面へ戻るためのパラメーター取得
    public function get_admin_param($request)
    {
        $getCheckboxs = empty($request)?
        Checkbox::getCheckboxs($request,'get'):
        Checkbox::getCheckboxs($request,'post');

        return [
            //従業員情報
            'employees' => empty($request)? Employee::all(): Employee::seach($request)->get(),

            //検索単語
            'checkbox_groups' => $getCheckboxs['checkbox_groups'],
            'seach_text' => $getCheckboxs['seach_text'],
            'seach_text_all' => $getCheckboxs['seach_text_all'],
        ];
    }

}



