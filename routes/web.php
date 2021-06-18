<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HelloController;//練習用
use App\Http\Controllers\TestController;//テスト用

use App\Http\Controllers\EmployeeListController;
use App\Http\Controllers\AttendanceManegementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Employee List Routes (従業員管理)
|--------------------------------------------------------------------------
*/

# 一覧照会画面
Route::get('employee_list',[EmployeeListController::class,'index'])
->name('employee_list');
Route::post('employee_list',[EmployeeListController::class,'search']);

// 従業員詳細
Route::post('employee_list/detail',[EmployeeListController::class,'detail'])
->name('employee_list.detail');



# 管理者画面
Route::get('employee_list/admin',[EmployeeListController::class,'admin'])
->name('employee_list.admin');

Route::post('employee_list/admin',[EmployeeListController::class,'admin_post']);


// 新規登録画面
Route::get('employee_list/admin/insert',[EmployeeListController::class,'insert'])
->name('employee_list.admin.insert');

// 編集画面
Route::get('employee_list/admin/update',[EmployeeListController::class,'update'])
->name('employee_list.admin.update');

// 登録確認画面
Route::post('employee_list/admin/confirm',[EmployeeListController::class,'confirm'])
->name('employee_list.admin.confirm');

/*
|--------------------------------------------------------------------------
| Attendance Manegement Routes (勤怠管理)
|--------------------------------------------------------------------------
*/
 # 勤怠管理一覧TOPの表示
Route::get('attendance_manegement',[AttendanceManegementController::class,'index'])
->name('employee_list.admin');

# 日別勤怠管理一覧の表示 date_list
Route::get('attendance_manegement/date_list',[AttendanceManegementController::class,'date_list'])
->name('attendance_manegement.date_list');


# 月別勤怠管理一覧の表示 month_list
Route::get('attendance_manegement/month_list',[AttendanceManegementController::class,'month_list'])
->name('employee_list.admin.month_list');


# 個人別勤怠管理一覧の表示 person_list
Route::get('attendance_manegement/person_list',[AttendanceManegementController::class,'person_list'])
->name('employee_list.admin.person_list');


/*
|--------------------------------------------------------------------------
| テスト用ルーティング作成
|--------------------------------------------------------------------------
*/
#テストページ
Route::get('test/test',[TestController::class,'test']);
Route::post('test/test',[TestController::class,'post']);

#リストページ
Route::get('test/list',[TestController::class,'list'])
->name('test.list');
Route::post('test/list',[TestController::class,'seachList']);

#詳細ページ
Route::get('test/detail',[TestController::class,'detail'])
->name('test.detail');

//テンプレートの読み込み
Route::get('test/base',[TestController::class,'base']);


/*
|--------------------------------------------------------------------------
| 練習用ルーティング作成
|--------------------------------------------------------------------------
*/
//HTMLの出力
Route::get('hello', function () {
    return '<html><body><h1>Hello!</h1></body></html>';
});

//フォームの利用
Route::get('form','HelloController@form');


Route::get('/sample', function () {
    return view('sample');
});
