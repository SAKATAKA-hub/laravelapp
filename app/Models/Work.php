<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    # '日付'を指定してレコードの抽出
    public function scopeDateList($query,$date,$place)
    {
        return $query->where('date',$date)
        ->where('place','like',$place.'%')
        ->orderBy('in','asc');
    }


    # '月'を指定してレコードの抽出
    public function scopeMonthList($query, $f_date, $l_date ,$place)
    {
        return $query->where('date','>=',$f_date)
        ->where('date','<=',$l_date)
        ->where('place','like',$place.'%')
        ->orderBy('date','asc')
        ->orderBy('in','asc');
    }

    # '従業員'を指定してレコードの抽出
    public function scopePersonList($query, $employee, $f_date, $l_date)
    {
        return $query->where('employee_id',$employee)
        ->where('date','>=',$f_date)
        ->where('date','<=',$l_date)
        ->orderBy('date','asc')
        ->orderBy('in','asc');
    }


    # 日付の表示変換
    public function getDateText()
    {
        list($Y, $m, $d) = explode('-',$this->date);
        $w = date('w',mktime(0,0,0,$m, $d, $Y));
        $weeks = ['(日)','(月)','(火)','(水)','(木)','(金)','(土)',];

        return sprintf('%02d日',$d).$weeks[$w];
    }




    # 他テーブルとのリレーション
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function work_breaks()
    {
        return $this->hasMany(WorkBreak::class);
    }




    # マイグレーション設定
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'date',
        'place',
        'in',
        'out',
        'RestrainTime',
        'BreakTime',
        'WorkingTime',
    ];
}
