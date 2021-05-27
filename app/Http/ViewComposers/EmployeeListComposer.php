<?php

namespace App\Http\ViewComposers;
use Illuminate\View\View;


class EmployeeListComposer
{
    public function compose(View $view)
    {
        $app_menus = array(
            ['title'=>'一般画面','url'=>''],
            ['title'=>'編集画面','url'=>''],
        );

        $view->with([
            'app_name' => 'employee_list',
            'app_menus' => $app_menus,
        ]);
    }

}