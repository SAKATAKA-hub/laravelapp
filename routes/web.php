<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HelloController;//練習用
use App\Http\Controllers\TestController;//テスト用

use App\Http\Controllers\EmployeesManegementController;

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
})->name('/');

/*
|--------------------------------------------------------------------------
| Employees Manegement Routes (従業員管理)
|--------------------------------------------------------------------------
*/
 # 従業員管理一覧
 Route::get('/employees_manegement',[EmployeesManegementController::class,'index'])
 ->name('employees_manegement.index');
 Route::post('/employees_manegement',[EmployeesManegementController::class,'index'])
 ->name('employees_manegement.index');

// 従業員詳細
Route::get('/employees_manegement/{employee}/show',[EmployeesManegementController::class,'show'])
->name('employees_manegement.show');

# 管理者画面
Route::get('/employees_manegement/admin',[EmployeesManegementController::class,'admin'])
->name('employees_manegement.admin');
Route::post('/employees_manegement/admin',[EmployeesManegementController::class,'admin'])
->name('employees_manegement.admin');
Route::get('/employees_manegement/{mode}/admin_alert',[EmployeesManegementController::class,'admin_alert'])
->name('employees_manegement.admin_alert');


// 新規登録
Route::get('/employees_manegement/create',[EmployeesManegementController::class,'create'])
->name('employees_manegement.create');
Route::post('/employees_manegement/insert',[EmployeesManegementController::class,'insert'])
->name('employees_manegement.insert');
// Route::get('/employees_manegement/{mode}/done_insert',[EmployeesManegementController::class,'done_insert'])
// ->name('employees_manegement.done_insert');


// 登録情報編集
Route::get('/employees_manegement/{employee}/edit',[EmployeesManegementController::class,'edit'])
->name('employees_manegement.edit');
Route::patch('/employees_manegement/update',[EmployeesManegementController::class,'update'])
->name('employees_manegement.update');
// Route::get('/employees_manegement/done_update',[EmployeesManegementController::class,'done_update'])
// ->name('employees_manegement.done_update');


// 登録情報削除
Route::delete('/employees_manegement/{employee}/destroy',[EmployeesManegementController::class,'destroy'])
->name('employees_manegement.destroy');
// Route::get('/employees_manegement/done_destroy',[EmployeesManegementController::class,'done_destroy'])
// ->name('employees_manegement.done_destroy');

// 登録確認画面
Route::post('/employees_manegement/confirm',[EmployeesManegementController::class,'confirm'])
->name('employees_manegement.confirm');


/*
|--------------------------------------------------------------------------
| Attendance Manegement Routes (勤怠管理)
|--------------------------------------------------------------------------
*/
# 日別勤怠管理一覧の表示 date_list
Route::get('attendance_manegement/date_list',[AttendanceManegementController::class,'date_list'])
->name('attendance_manegement.date_list');
Route::post('attendance_manegement/date_list_search',[AttendanceManegementController::class,'date_list_search'])
->name('attendance_manegement.date_list_search');


# 月別勤怠管理一覧の表示 month_list
Route::get('attendance_manegement/month_list',[AttendanceManegementController::class,'month_list'])
->name('attendance_manegement.month_list');


# 個人別勤怠管理一覧の表示 person_list
Route::get('attendance_manegement/person_list',[AttendanceManegementController::class,'person_list'])
->name('attendance_manegement.person_list');


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
