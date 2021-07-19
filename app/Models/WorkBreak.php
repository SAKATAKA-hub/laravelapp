<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkBreak extends Model
{
    # マイグレーション設定
    use HasFactory;
    protected $fillable = [
        'work_id',
        'in',
        'out',
        'total_time',
    ];
}
