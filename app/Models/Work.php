<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    # マイグレーション設定
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'date',
        'in',
        'out',
        'RestrainTime',
        'BreakTime',
        'WorkingTime',
    ];
}
