<?php

namespace App\Http\Controllers;
use App\Http\Requests\EmployeeRequest; //フォームリクエストの利用
use App\Models\Employee; //モデルの利用
use App\Models\Checkbox; //モデルの利用
use Illuminate\Http\Request;


class EmployeeListController extends Controller
{
    #--------------------------------------------------------------------------------------------
    #アクション内で利用する関数
    #--------------------------------------------------------------------------------------------
    //DBのアップロード
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

    //検索条件の抽出
    public function seachs_array($request)
    {
        return[
            'keyword' => $request->keywords,
            'department' => $request->department,
            'position' => $request->position,
            'gender' => $request->gender,
        ];
    }
    //検索条件テキストの抽出
    public function seach_text($request)
    {
        $checks =[
            ['all'=> $request->department_all, 'vals'=> $request->department],
            ['all'=> $request->position_all, 'vals'=> $request->position],
            ['all'=> $request->gender_all, 'vals'=> $request->gender],
        ];

        $text = $request->keywords.' ';
        foreach($checks as $check)
        {
            if(!empty($check['vals']) && !$check['all'])
            {
                $text .= implode(' ',$check['vals']).' ';
            }
        }

        return trim($text) == '' ? '検索条件はありません。':$text;
    }





    #--------------------------------------------------------------------------------------------
    # 一覧照会画面の表示
    #--------------------------------------------------------------------------------------------

    # 一覧照会画面の表示
    public function index(Request $request)
    {
        $param=[
            //表示中メニュー
            'app_menu_current' => 'index',
            //従業員情報
            'employees' => Employee::all(),

            //検索単語
            'seach_text' => $this->seach_text($request),
            'checkbox_groups' => Checkbox::getCheckboxs(),

            //テスト
            'seachs' => $this->seachs_array($request),
            'seach_text' => $this->seach_text($request),

        ];
        return view('employee_list.index',$param);
    }



    # 一覧照会画面(検索)の表示
    public function search(Request $request)
    {
        $param=[
            //表示中メニュー
            'app_menu_current' => 'index',
            //従業員情報
            'employees' => Employee::seach($this->seachs_array($request))->get(),
            //検索単語
            'seach_text' => $this->seach_text($request),
            //チェックボックスの表示内容
            'checkbox_groups' => Checkbox::getCheckboxs(),

            //テスト
            'seachs' => $this->seachs_array($request),
            'seach_text' => $this->seach_text($request),

        ];
        return view('employee_list.index',$param);

    }



    # 従業員詳細ページ
    public function detail(Request $request)
    {
        $param=[
            //表示中メニュー
            'app_menu_current' => 'index',
            'employee' => Employee::find($request->id), //DB情報の取得
        ];
        return view('employee_list.detail',$param);
    }



    #--------------------------------------------------------------------------------------------
    # 管理者画面
    #--------------------------------------------------------------------------------------------
    # 管理者画面TOPの表示
    public function admin()
    {
        $param=[
            //表示中メニュー
            'app_menu_current' => 'admin',
            //従業員情報
            'employees' => Employee::all(),
            //モード処理
            'mode_text' => '',
            //検索単語
            'seach_text' => '検索条件はありません。',
            'checkbox_groups' => Checkbox::getCheckboxs(),

        ];

        return view('employee_list.admin',$param);
    }


    # 管理者画面TOP(POST)の表示
    public function admin_post(Request $request) //リクエストの利用
    {
        # モード処理 ---------  --------- ---------
        $mode_text = '';

        //画像の保存先
        $comfirm_path = '/image/comfirm';
        $upload_path = '/image/employees';
        $no_image = 'e8888.png';


        // 1.従業員情報の新規登録・2.従業員情報の更新
        if( ($request->mode == 'insert')||($request->mode == 'update') )
        {
            //画像の保存
            if($file_name = $request->file_name)
            {
                $comfirm_path_name = public_path().sprintf('%s/%s',$comfirm_path,$file_name);
                $upload_path_name = public_path().sprintf('%s/%s',$upload_path,$file_name);

                if($file = file_get_contents($comfirm_path_name))
                {
                    file_put_contents($upload_path_name,$file); //本番ディレクトリに画像を保存
                    unlink($comfirm_path_name); //一時保存画像の削除
                }
            }
            if($request->old_image)
            {
                $file_name = $request->old_image;
            }
            else
            {
                $file_name = $no_image;
            }

            //DBへ保存
            if($request->mode == 'insert')
            {
                $employee = new Employee; //新規挿入
                $this->employee_upload($employee, $request, $file_name);
                $mode_text = '新規追加しました。';
            }
            else
            {
                $employee = Employee::find($request->id); //上書き
                $this->employee_upload($employee, $request, $file_name);
                $mode_text = '情報を修正しました。';
            }
        }

        // 3.従業員情報の削除
        elseif($request->mode == 'delite')
        {
            //従業員画像の削除
            $delete_rec = Employee::where('id',$request->id)->first();
            $upload_path_name = public_path().sprintf('%s/%s',$upload_path,$delete_rec['image']);
            if(file_exists($upload_path_name))
            {
                unlink($upload_path_name);
            }
            //DBレコードの削除
            Employee::find($request->id)->delete();
            $mode_text = '情報を一件削除しました。';

        }
        //--------- end mode処理 --------- ---------

        $employees = isset($request->mode) ? Employee::all() : Employee::seach($this->seachs_array($request))->get();
        $seach_text = isset($request->mode) ? '' : $this->seach_text($request);

        $param=[
            //表示中メニュー
            'app_menu_current' => 'admin',
            //従業員情報
            'employees' => $employees,
            //モード処理
            'mode_text' => $mode_text,
            // 'delete_rec' => $delete_rec['image'],

            //検索単語
            'seach_text' => $seach_text,
            //チェックボックスの表示内容
            'checkbox_groups' => Checkbox::getCheckboxs(),
        ];
        return view('employee_list.admin',$param);

    }


    # 新規登録ページ
    public function insert(Request $request)
    {
        $param=[
            //表示中メニュー
            'app_menu_current' => 'admin',
            //最後に登録した'ID'番号の取得
            'employee' => Employee::where('id','>=',0)->orderBy('id','desc')->first(),
            //チェックボックスの表示内容
            'checkbox_groups' => Checkbox::getCheckboxs(),
        ];
        return view('employee_list.insert',$param);
    }

    # 編集ページ
    public function update(Request $request)
    {
        $employee = Employee::find($request->id); //DB情報の取得
        $param=[
            //表示中メニュー
            'app_menu_current' => 'admin',

            'employee' => $employee,
            //チェックボックスの表示内容
            'checkbox_groups' => Checkbox::getCheckboxs(),
        ];
        return view('employee_list.update',$param);
    }

    # 登録確認ページ
    public function confirm(EmployeeRequest $request) //フォームリクエストの利用
    {

        //画像の保存
        $comfirm_path = '/image/comfirm';
        $upload_path = '/image/employee';

        if($file = $request->file('image'))
        {
            $file_name = sprintf('e%04d.%s', $request->id, $file->guessExtension() );
            $target_path = public_path($comfirm_path);
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
            'checkbox_groups' => Checkbox::getCheckboxs(),
            //アップロードファイル関係
            'file_name' => $file_name,
            'file_path' => $comfirm_path,
        ];
        return view('employee_list.confirm',$param);
    }



}
