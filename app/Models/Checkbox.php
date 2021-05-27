<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkbox extends Model
{
    # シーダー用設定
    use HasFactory;
    public $timestamps = false; //timesatampを利用しない
    protected $fillable = ['group','item',];

}
