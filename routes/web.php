<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HelloController;//練習用
use App\Http\Controllers\TestController;//テスト用

use App\Http\Controllers\EmployeesManegementController;

use App\Http\Controllers\TimeCardController;

use App\Http\Controllers\AttendanceManegementController;
use App\Http\Controllers\AttendanceManegementPrintController;
use App\Http\Controllers\AttendanceManegementAdminController;


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
| Time Card Routes (タイムカード)
|--------------------------------------------------------------------------
*/
# タイムカードへのアクセス
Route::get('/time_card/index/{input}/{place}/{employee}',
[TimeCardController::class,'index'])->name('time_card.index');

#従業員の変更(change_employee)
Route::post('/time_card/change_employee/',
[TimeCardController::class,'change_employee'])->name('time_card.change_employee');


#出勤現場の変更(change_place)
Route::post('/time_card/change_place/',
[TimeCardController::class,'change_place'])->name('time_card.change_place');


# -- タイムカードの入力処理 --
# 勤務開始(work_in)
Route::post('/time_card/work_in/{place}/{employee}',
[TimeCardController::class,'work_in'])->name('time_card.work_in');

# 休憩開始(work_break_in)
Route::patch('/time_card/work_break_in/{place}/{employee}/{work}',
[TimeCardController::class,'work_break_in'])->name('time_card.work_break_in');

# 休憩終了(work_break_out)
Route::patch('/time_card/work_break_out/{place}/{employee}/{work}',
[TimeCardController::class,'work_break_out'])->name('time_card.work_break_out');

# 勤務終了(work_out)
Route::patch('/time_card/work_out/{place}/{employee}/{work}',
[TimeCardController::class,'work_out'])->name('time_card.work_out');





/*
|--------------------------------------------------------------------------
| Attendance Manegement Routes (勤怠管理)
|--------------------------------------------------------------------------
*/
# 日別勤怠管理一覧 date_list
Route::get('attendance_manegement/date_list',[AttendanceManegementController::class,'date_list'])
->name('attendance_manegement.date_list');
Route::post('attendance_manegement/date_list_search',[AttendanceManegementController::class,'date_list_search'])
->name('attendance_manegement.date_list_search');

# 月別勤怠管理一覧 month_list
Route::get('attendance_manegement/month_list',[AttendanceManegementController::class,'month_list'])
->name('attendance_manegement.month_list');
Route::post('attendance_manegement/month_list_search',[AttendanceManegementController::class,'month_list_search'])
->name('attendance_manegement.month_list_search');

# 個人別勤怠管理一覧 person_list
Route::get('attendance_manegement/person_list',[AttendanceManegementController::class,'person_list'])
->name('attendance_manegement.person_list');
Route::post('attendance_manegement/person_list_search',[AttendanceManegementController::class,'person_list_search'])
->name('attendance_manegement.person_list_search');



# 日別勤怠管理印刷 print_date_list
Route::post('attendance_manegement/print_date_list/',[AttendanceManegementPrintController::class,'print_date_list'])
->name('attendance_manegement.print_date_list');

# 月別勤怠管理印刷 print_month_list
Route::post('attendance_manegement/print_month_list/',[AttendanceManegementPrintController::class,'print_month_list'])
->name('attendance_manegement.print_month_list');

# 個人別勤怠管理印刷 print_person_list
Route::post('attendance_manegement/print_person_list/',[AttendanceManegementPrintController::class,'print_person_list'])
->name('attendance_manegement.print_person_list');



# 勤怠修正一覧 admin
Route::get('attendance_manegement/admin',[AttendanceManegementAdminController::class,'admin'])
->name('attendance_manegement.admin');
Route::post('attendance_manegement/admin_search',[AttendanceManegementAdminController::class,'admin_search'])
->name('attendance_manegement.admin_search');

# 修正入力 edit
Route::get('attendance_manegement/{work}/edit',[AttendanceManegementAdminController::class,'edit'])
->name('attendance_manegement.edit');

# 修正内容保存 update
Route::patch('attendance_manegement/{work}/update',[AttendanceManegementAdminController::class,'update'])
->name('attendance_manegement.update');

# 削除 destroy
Route::delete('attendance_manegement/{work}/destroy',[AttendanceManegementAdminController::class,'destroy'])
->name('attendance_manegement.destroy');


# 挿入 create (テスト用)
Route::get('attendance_manegement/create',[AttendanceManegementAdminController::class,'create'])
->name('attendance_manegement.create');




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
| テスト用ルーティング作成
|--------------------------------------------------------------------------
*/
#テストページ
Route::get('test',[TestController::class,'test']);

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
