<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee; //モデルの利用

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = [
            [ '1', '矢野 詩織', 'やの しおり', '東京支店', '課長', '女性', '1995/01/01', '090-9840-1414', 'yano_shiori@example.com', ],
            [ '2', '近藤 竜也', 'こんどう たつや', '東京支店', '係長', '男性', '1995/02/02', '090- 699-9658', 'konndou_tatsuya@example.com', ],
            [ '3', '小西 美希', 'こにし みき', '東京支店', '主任', '女性', '1995/03/03', '080-2869-8109', 'konishi_miki@example.com', ],
            [ '4', '柳原 了', 'やなぎはら りょう', '東京支店', '一般社員', '男性', '19995/04/04', '090-9689-3478', 'yanagihara_ryou@example.com', ],
            [ '5', '川村 くるみ', 'かわむら くるみ', '東京支店', '一般社員', '女性', '1995/05/05', '090-4894- 885', 'kawamura_kurumi@example.com', ],
            [ '6', '浅利 良介', 'あさり りょうすけ', '神奈川支店', '課長', '男性', '1995/06/06', '080-4490-7351', 'asari_ryousuke@example.com', ],
            [ '7', '坂本 美希', 'さかもと みき', '神奈川支店', '係長', '女性', '1995/07/07', '090-2782-1184', 'sakamoto_miki@example.com', ],
            [ '8', '井口 雄太', 'いぐち ゆうた', '神奈川支店', '主任', '男性', '1995/08/08', '080-4656-4464', 'iguchi_yuuta@example.com', ],
            [ '9', '高梨 由樹', 'たかなし ゆき', '神奈川支店', '一般社員', '女性', '1995/09/09', '090-1192-1480', 'takanashi_yuki@example.com', ],
            [ '10', '今 洋介', 'こん ようすけ', '神奈川支店', '一般社員', '男性', '1995/10/10', '080-7557-5015', 'kon_yousuke@example.com', ],
            [ '11', '多田 優', 'ただ ゆう', '千葉支店', '課長', '女性', '1995/01/02', '080-8587-5786', 'tada_yuu@example.com', ],
            [ '12', '太田 隼士', 'おおた しゅんじ', '千葉支店', '係長', '男性', '1995/02/03', '090-3209-3541', 'oota_shunji@example.com', ],
            [ '13', '野村 昴', 'のむら すばる', '千葉支店', '主任', '女性', '1995/03/04', '090-6673- 19', 'nomura_subaru@example.com', ],
            [ '14', '海音寺 竜次', 'かいおんじ りゅうじ', '千葉支店', '一般社員', '男性', '19995/04/05', '090-4361-3462', 'kaionji_ryuuji@example.com', ],
            [ '15', '金井 薫', 'かない かおる', '千葉支店', '一般社員', '女性', '1995/05/06', '090-2142-7917', 'kanai_kaoru@example.com', ],
            [ '16', '白鳥 明宏', 'しらとり あきひろ', '埼玉支店', '課長', '男性', '1995/06/07', '080-7587-2383', 'shiratori_akihiro@example.com', ],
            [ '17', '大後 寿々花', 'おおご すずか', '埼玉支店', '係長', '女性', '1995/07/08', '080-5280-4129', 'oogo_suzuka@example.com', ],
            [ '18', '宮脇 きみまろ', 'みやわき きみまろ', '埼玉支店', '主任', '男性', '1995/08/09', '080-7686-1382', 'miyawaki_kimimaro@example.com', ],
            [ '19', '金子 詩織', 'かねこ しおり', '埼玉支店', '一般社員', '女性', '1995/09/10', '080-6734-6725', 'kaneko_shiori@example.com', ],
            [ '20', '蛍原 徹', 'ほとはら とおる', '埼玉支店', '一般社員', '男性', '1995/10/11', '090-2463-8688', 'hotohara_tooru@example.com', ],
        ];

        foreach ($employees as $key => $employee)
        {
            $employee = new Employee([
                'id' => $employee[0],
                'name' => $employee[1],
                'kana_name' => $employee[2],
                'department' => $employee[3],
                'position' => $employee[4],
                'gender' => $employee[5],
                'birthday' => $employee[6],
                'tell' => $employee[7],
                'email' => $employee[8],

                'image' => sprintf('e%04d.png',$employee[0]),
                'hire_date' => '2020/04/01',
                'leave_date' => NULL,
                'pass_id' => NULL,
            ]);
            $employee->save();
        }

    // レコード1
    //     $employee = new \App\Models\Employee([
    //         'name' => '鈴木　一郎',
    //         'kana_name' => 'すずき　いちろう',
    //         'department' => '営業一課　世田谷支店',
    //         'position' => '係長',
    //         'gender' => '男性',
    //         'birthday' => '2000-01-01',
    //         'tell' => '090-0001-0001',
    //         'email' => 'ichiro@meil.co.jp',
    //         'image' => 'e0001.png',
    //         'hire_date' => '2020-04-01',
    //         'leave_date' => '',
    //         'pass_id' => '0000-0001',
    //     ]);
    //     $employee->save();
    }
}
