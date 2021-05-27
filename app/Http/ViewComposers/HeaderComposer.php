<?php

namespace App\Http\ViewComposers;
use Illuminate\View\View;


class HeaderComposer
{
    public function compose(View $view)
    {
        $header_menus = array(
            'employee_list'=>['title'=>'従業員一覧','url'=>'employee_list',],
            'attendance_manegement'=>['title'=>'勤怠管理','url'=>'attendance_manegement',],
            'schedule'=>['title'=>'スケジュール','url'=>'schedule',],
        );

        $view->with([
            'header_menus' => $header_menus,
        ]);
    }

}