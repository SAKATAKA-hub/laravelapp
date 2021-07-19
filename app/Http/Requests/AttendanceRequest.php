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
                'required',
                'regex:/^(([0-1]\d|2[0-3])([0-5]\d)|2400)$/' , //0000~2400
                'lte:'.$input_data['out'] , //out以下の時間
            ],
            'out' => [
                'regex:/^(([0-1]\d|2[0-3])([0-5]\d)|2400|())$/' , //0000~2400又は空文字
                // 'gte:'.$input_data['in'] , //in以上の時間
            ],

        ];

        //'break_delete'にチェックがなければ、ルールを追加
        for ($i=1; $i <= 4; $i++){
            if( !isset($input_data['break_delete'.$i]) )
            {
                $rules['break_in'.$i] = [
                    'required',
                    'regex:/^(([0-1]\d|2[0-3])([0-5]\d)|2400)$/' , //0000~2400
                    $i==1? 'gte:'.$input_data['in']: 'gte:'.$input_data['break_out'.($i-1)], //前のbreak_out以上の時間
                    'lte:'.$input_data['break_out'.$i], //break_out以下の時間
                ];
                $rules['break_out'.$i] = [
                    'required',
                    'regex:/^(([0-1]\d|2[0-3])([0-5]\d)|2400)$/' , //0000~2400
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
        //基本バリデートメッセージ
        $messages = [
            'regex' => 'エラー：時間の入力は半角数字4桁で、2400以内の時間で入力してください。',
            'in.required'=> 'エラー：出勤時間が未入力です',
            'in.lte' => 'エラー：出勤時間を退勤時間の前になるように入力してください。',
            // 'out.gte' => 'エラー：退勤時間を出勤時間の後になるように入力してください。',
        ];
        //'break_delete'にチェックがなければ、ルールを追加
        for ($i=1; $i <= 4; $i++){
            if( !isset($input_data['break_delete'.$i]) )
            {
                $messages['break_in'.$i.'.required'] = "エラー：休憩開始時間".$i."が未入力です。";
                $messages['break_in'.$i.'.gte'] = 'エラー：休憩開始時間を前の時間と重ならないように入力してください。';
                $messages['break_in'.$i.'.lte'] = 'エラー：休憩開始時間が休憩終了時間の前になるように入力してください。';
                $messages['break_out'.$i.'.required'] = "エラー：休憩終了時間".$i."が未入力です。";
                $messages['break_out'.$i.'.gte'] = 'エラー：休憩終了時間が、休憩開始時間の後になるように入力してください。';
                $messages['break_out'.$i.'.lte'] = 'エラー：休憩終了時間を退勤時間の前になるようにに入力してください。';
            }
        }


        return $messages;
    }
}
