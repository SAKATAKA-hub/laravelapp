<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Headerメニュー
        View::composer('*','App\Http\ViewComposers\HeaderComposer');

        // 従業員管理メニュー
        View::composer('employees_manegement.*','App\Http\ViewComposers\EmployeesManegementComposer');
        // View::composer('employee_list.*','App\Http\ViewComposers\EmployeeListComposer');

        // 勤怠管理メニュー
        View::composer('attendance_manegement.*','App\Http\ViewComposers\AttendanceManegementComposer');
    }
}
