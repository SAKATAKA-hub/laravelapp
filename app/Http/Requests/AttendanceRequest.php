<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    //リクエストの利用が可能なパス
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */


    # 検証ルール
    public function rules()
    {
        //入力内容の取得
        $input_data = $this->all();

        //基本バリデートルール
        $rules = [
            'in' => [
                'regex:/^(\d{2}\d{2})$|^()$/' , //0000の型
                'lte:'.$input_data['out'] , //out以下の時間
            ],
            'out' => [
                'regex:/^(\d{2}\d{2})$|^()$/' , //0000の型
                'gte:'.$input_data['in'] , //in以上の時間
            ],

        ];

        //'break_delete'にチェックがなければ、ルールを追加
        for ($i=1; $i <= 4; $i++)
        {
            if( !isset($input_data['break_delete'.$i]) )
            {
                $rules['break_in'.$i] = [
                    'regex:/^(\d{2}\d{2})$|^()$/',
                    $i==1? 'gte:'.$input_data['in']: 'gte:'.$input_data['break_out'.($i-1)], //前のbreak_out以上の時間
                    'lte:'.$input_data['break_out'.$i], //break_out以下の時間
                ];
                $rules['break_out'.$i] = [
                    'regex:/^(\d{2}\d{2})$|^()$/',
                    'gte:'.$input_data['break_in'.$i], //break_in以上の時間
                    'lte:'.$input_data['out'], //out以下の時間
                ];
            }
        }


        return $rules;
    }


    # エラーメッセージ
    public function messages()
    {
        return[
            'regex' => '時間の入力は"半角数字4ケタ"で入力してください。',
            'gte' => '前の時間より大きい時間を入力してください。',
            'lte' => '後の時間より小さい時間を入力してください。',
        ];
    }
}
