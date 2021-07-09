<?php

namespace App\Http\Controllers;

# モデルの利用
use App\Models\Employee;
use App\Models\Work;
use App\Models\Checkbox;

use App\Http\Controllers\library\DateItems;// 日付クラスの利用
use Illuminate\Http\Request;

// ＊AttendanceManegementController　を継承
class AttendanceManegementAdminController extends AttendanceManegementController
{
    # 勤怠修正一覧
    public function admin()
    {
        $param = AttendanceManegementController::getDateListPalam();
        $param['app_menu_current'] = 'admin';

        return view('attendance_manegement.admin',$param);
    }

    public function admin_search(Request $request)
    {
        $param = AttendanceManegementController::getDateListSeachPalam($request);
        $param['app_menu_current'] = 'admin';

        return view('attendance_manegement.admin',$param);
    }


    # 修正入力
    public function edit(Work $work)
    {
        $Ymd = str_replace('-','/',$work->date);
        $DI = new DateItems;
        $date_item = $DI->getThisMonth($Ymd);


        $param = [
            'date' => $date_item['Ymd_text'],
            // 'date' => $work->date,
            'app_menu_current' => 'admin',
            'work' => $work,
        ];
        return view('attendance_manegement.edit',$param);
    }

    # 修正内容保存
    public function update(Work $work)
    {
        return "
        <h1>Update</h1>
        <p>$work->id<p/>
        ";
    }

    # 削除
    public function destroy(Work $work)
    {
        return "
        <h1>Destroy</h1>
        <p>$work->id<p/>
        ";
    }


}
