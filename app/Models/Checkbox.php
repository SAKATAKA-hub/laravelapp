<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkbox extends Model
{
    public function scopeGetCheckboxs($query,$request,$route) //---------------------
    {
        # チェックボックス配列の作成
        //チェックボックスの情報
        $checkbox_groups = [];

        //取得する項目
        $groups = [
            'department' => '所属部署',
            'position' => '役職',
            'gender' => '性別',
        ];


        // データの取得
        foreach ($groups as $key => $group_text)
        {
            $query->orWhere('group',$group_text);
        }
        $data = $query->get();

        // データの加工
        foreach ($groups as $key => $group_text)
        {
            $checkbox_groups[$key]['key'] = $key;
            $checkbox_groups[$key]['title'] = $group_text;
            $checkbox_groups[$key]['all'] = [
                'name' => $key.'_all',
                'item' => '全て選択',
                'checked' =>
                ($route == "get")
                || ($route == "post")&&($request[$key.'_all'])
                || ($route == "post")&&($request[$key] == NULL)
                ? true : false,

            ];

            foreach ($data as $line){
                if($line->group == $group_text)
                {
                    $checkbox_groups[$key]['checks'][] = [
                        'name' => $key.'[]',
                        'item' => $line['item'],
                        'checked' => true,
                        'checked' => ($route == "post")&&($request[$key] != NULL)&&(!in_array($line['item'],$request[$key]))? false :true,
                    ];
                }
            }
        }


        # 検索条件テキストの抽出
        $checks =[
            ['all'=> $request->department_all, 'vals'=> $request->department],
            ['all'=> $request->position_all, 'vals'=> $request->position],
            ['all'=> $request->gender_all, 'vals'=> $request->gender],
        ];

        $seach_text = $request->keywords;
        $text = $request->keywords.' ';
        foreach($checks as $check)
        {
            if(($route == "post")&& !empty($check['vals']) && !$check['all'])
            {
                $text .= implode(' ',$check['vals']).' ';
            }
        }

        $seach_text_all = trim($text) == '' ? '検索条件はありません。':$text;



        return [
            "checkbox_groups" => $checkbox_groups,
            "seach_text" => $seach_text,
            "seach_text_all" => $seach_text_all,
        ];

        // $checkbox_groups = [
        //     'department' => [
        //         'key' => 'department',
        //         'title' => '所属部署',
        //         'all' => ['name' => $key.'_all', 'item' => '全て選択', 'checked' => true,],
        //         'checks' => [
        //             0 => ['name' => $key.'[]', 'item' => $line['item'], 'checked' => true,],
        //             1 => ['name' => $key.'[]', 'item' => $line['item'], 'checked' => true,],
        //         ] ,,
        //     ] ,
        //     'position' => [
        //         'key' => 'department',
        //         'title' => '役職',
        //         'all' => ['name' => $key.'_all', 'item' => '全て選択', 'checked' => true,],
        //         'checks' => [
        //             0 => ['name' => $key.'[]', 'item' => $line['item'], 'checked' => true,],
        //             1 => ['name' => $key.'[]', 'item' => $line['item'], 'checked' => true,],
        //         ] ,,
        //     ] ,
        //     'gender' => [
        //         'key' => 'department',
        //         'title' => '性別',
        //         'all' => ['name' => $key.'_all', 'item' => '全て選択', 'checked' => true,],
        //         'checks' => [
        //             0 => ['name' => $key.'[]', 'item' => $line['item'], 'checked' => true,],
        //             1 => ['name' => $key.'[]', 'item' => $line['item'], 'checked' => true,],
        //         ] ,,
        //     ] ,
        // ];

    }


    # シーダー用設定
    use HasFactory;
    public $timestamps = false; //timesatampを利用しない
    protected $fillable = ['group','item',];

}
