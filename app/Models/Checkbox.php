<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkbox extends Model
{

    public function scopeGetCheckboxs($query)
    {
        //チェックボックスの情報
        $CheckGroups = [];

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
            $CheckGroups[$key]['key'] = $key;
            $CheckGroups[$key]['title'] = $group_text;
            $CheckGroups[$key]['all'] = [
                'name' => $key.'_all',
                'item' => '全て選択',
                'checked' => true,
            ];

            foreach ($data as $line){
                if($line->group == $group_text)
                {
                    $CheckGroups[$key]['checks'][] = [
                        'name' => $key.'[]',
                        'item' => $line['item'],
                        'checked' => true,
                    ];
                }
            }
        }

        return $CheckGroups;

        // $CheckGroups = [
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
