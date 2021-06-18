<?php

namespace App\Http\ViewComposers;
use Illuminate\View\View;


class AttendanceManegementComposer
{
    public function compose(View $view)
    {
        $view->with([
            'app_name' => 'attendance_manegement',
            'app_menus' => [
                'date_list'=>['route'=>'attendance_manegement.date_list', 'text'=>'日別勤怠一覧', 'current'=>false,],
                'month_list'=>['route'=>'attendance_manegement.month_list', 'text'=>'月別勤怠一覧', 'current'=>false,],
                'person_list'=>['route'=>'attendance_manegement.person_list', 'text'=>'個人別勤怠一覧', 'current'=>false,],
            ],
        ]);
    }

}
