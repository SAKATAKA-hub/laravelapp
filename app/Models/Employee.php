<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    # 従業員リスト絞り込み検索用スコープ
    public function scopeSeach($query, $request)
    {
        //検索条件の抽出
        $ns = [
            'keyword' => $request->keywords,
            'department' => $request->department,
            'position' => $request->position,
            'gender' => $request->gender,
        ];

        //ユーザー入力の検索キーワード処理
        if(!empty($ns['keyword']))
        {
            $n = str_replace("　"," ",$ns['keyword']);
            $keywords = explode(" ",$n);
            foreach ($keywords as $keyword)
            {
                $query->where(function($query) use ($keyword)
                {
                    $query->where('name','like','%'.$keyword.'%')
                    ->orWhere('kana_name','like','%'.$keyword.'%')
                    ->orWhere('id','like','%'.$keyword.'%');
                });
            }
        }

        //その他の検索条件
        foreach ($ns as $seach_key => $seach_vals)
        {
            if($seach_key == 'keyword'){continue;}; //スキップ

            //一つのチェックボックスの処理
            if(!empty($seach_vals)){
            $query->where(function($query) use ($seach_key, $seach_vals){
            foreach ($seach_vals as $seach_val)
            {
                $query->orWhere($seach_key,'=',$seach_val);
            }
            });
            }
        }

        return $query;

    }




    # シーダー用設定
    use HasFactory;
    public $timestamps = false; //timesatampを利用しない
    protected $fillable = [
        'id',
        'name',
        'kana_name',
        'department',
        'position',
        'gender',
        'birthday',
        'tell',
        'email',
        'image',
        'hire_date',
        'leave_date',
        'pass_id',
    ];

}
