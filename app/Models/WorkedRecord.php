<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkedRecord extends Model
{
    #----------------------------------------------
    # シーダー用設定
    #----------------------------------------------
    use HasFactory;
    public $timestamps = false; //timesatampを利用しない
    protected $fillable = [
        'employee_id',
        'work_num',
        'date',
        'in',
        'out',
        'breaks',
        'RestrainTime',
        'BreakTime',
        'WorkingTime',
        ];


}
