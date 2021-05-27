<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HelloController;//練習用
use App\Http\Controllers\TestController;//テスト用

use App\Http\Controllers\EmployeeListController;

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
| Employee List Routes (従業員一覧)
|--------------------------------------------------------------------------
*/

# 従業員一覧ページ
Route::get('employee_list',[EmployeeListController::class,'index'])
->name('employee_list');
Route::post('employee_list',[EmployeeListController::class,'search']);

// 従業員詳細ページ
Route::post('employee_list/detail',[EmployeeListController::class,'detail'])
->name('employee_list.detail');

# 従業員一覧 / 管理者画面ページ
Route::get('employee_list/admin','EmployeeListController@admin')
->name('employee_list.admin');

# 従業員一覧 / 管理者画面 /　新規登録ページ
Route::get('employee_list/admin/insert','EmployeeListController@insert');

# 従業員一覧 / 管理者画面 /　新規登録ページ
Route::get('employee_list/admin/update','EmployeeListController@update');



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


/*
|--------------------------------------------------------------------------
| 練習用ルーティング作成
|--------------------------------------------------------------------------
*/

//HTMLの出力
Route::get('hello', function () {
    return '<html><body><h1>Hello!</h1></body></html>';
});

//テンプレートの読み込み
Route::get('base', function () {
    return view('base');
});


//フォームの利用
Route::get('form','HelloController@form');
