<?php

namespace App\Http\ViewComposers;
use Illuminate\View\View;


class HeaderComposer
{
    public function compose(View $view)
    {
        $view->with([
            'header_menus' => [
                'employees_manegement'=>['route'=>'employees_manegement.index', 'text'=>'従業員管理', 'current'=>false,],
                'attendance_manegement'=>['route'=>'attendance_manegement.date_list', 'text'=>'勤怠管理', 'current'=>false,],
                'schedule'=>['route'=>'/', 'text'=>'スケジュール', 'current'=>false,],
            ],
        ]);
    }

}
