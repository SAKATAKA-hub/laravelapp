<?php

namespace App\Http\ViewComposers;
use Illuminate\View\View;


class HeaderComposer
{
    public function compose(View $view)
    {
        $view->with([
            'header_menus' => [
                'employee_list'=>['route'=>'employee_list', 'text'=>'従業員管理', 'current'=>false,],
                'attendance_manegement'=>['route'=>'employee_list', 'text'=>'勤怠管理', 'current'=>false,],
                'schedule'=>['route'=>'employee_list', 'text'=>'スケジュール', 'current'=>false,],
            ],
        ]);
    }

}
