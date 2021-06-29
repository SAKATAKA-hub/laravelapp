<?php

namespace App\Http\ViewComposers;
use Illuminate\View\View;


class EmployeesManegementComposer
{
    public function compose(View $view)
    {
        $view->with([
            'app_name' => 'employees_manegement',

            'app_style' => 'css/employees_manegement.css',

            'app_menus' => [
                'index'=>[
                    'route'=>'employees_manegement.index',
                    'text'=>'従業員一覧',
                    'current'=>false,
                ],
                'admin'=>[
                    'route'=>'employees_manegement.admin',
                    'text'=>'管理者画面',
                    'current'=>false,
                ],
            ],
        ]);
    }

}
