<?php

namespace App\Http\ViewComposers;
use Illuminate\View\View;


class EmployeeListComposer
{
    public function compose(View $view)
    {
        $view->with([
            'app_name' => 'employee_list',
            'app_menus' => [
                'index'=>['route'=>'employee_list', 'text'=>'一覧照会画面', 'current'=>false,],
                'admin'=>['route'=>'employee_list.admin', 'text'=>'管理者画面', 'current'=>false,],
            ],
        ]);
    }

}
