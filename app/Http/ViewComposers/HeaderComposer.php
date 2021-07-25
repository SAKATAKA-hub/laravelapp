<?php

namespace App\Http\ViewComposers;
use Illuminate\View\View;


class HeaderComposer
{
    public function compose(View $view)
    {
        $view->with([
            'header_menus' => [

                //勤怠管理
                'attendance'=>
                ['route'=>'attendance.index', 'text'=>'勤怠管理(＊修正中)', 'current'=>false,],

                // 従業員管理
                'employees_manegement'=>
                ['route'=>'employees_manegement.index', 'text'=>'従業員管理', 'current'=>false,],

                // 勤怠管理
                'attendance_manegement'=>
                ['route'=>'attendance_manegement.date_list', 'text'=>'勤怠管理', 'current'=>false,],

                // スケジュール
                'schedule'=>['route'=>'/', 'text'=>'スケジュール', 'current'=>false,],
            ],
        ]);
    }

}
