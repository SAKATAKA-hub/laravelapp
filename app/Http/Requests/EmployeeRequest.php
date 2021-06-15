<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    //リクエストの利用が可能なパス
    public function authorize()
    {
        // if( $this->puth() == 'employee_list.admin'){ return true;}
        // else{return false;}
        return true;
    }

    //検証ルール
    public function rules()
    {
        return [
            'name' => 'required',
            'kana_name' => ['required','regex:/^[ あ-ん　]+$/'],

            'department' => 'required',
            'position' => 'required',
            'gender' => 'required',

            'tell' => 'regex:/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{2,4}$/',
            'email' => 'email',
            'image' => 'file',
        ];
    }

    //エラーメッセージ
    public function messages()
    {
        return[
            'required' => '入力必須。',
            'kana_name.regex' => 'ひらがなで入力してください。',
            'tell.regex' => '半角数字と"-"記号を使て入力してください。',
            'numeric' => '半角数字のみで入力してください。',
            'email' => 'メールアドレスの形式で入力してください。',
            'image.file' => 'ファイル形式で保存してください。',
        ];
    }

}
