<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
            ['id' => '0','name' => '近藤 竜也','kana_name' => 'こんどう たつや','department' => '神奈川支店','position' => '一般社員','gender' => '男性','birthday' => '1996-12-11','tell' => '090-699-9658','email' => 'konndou_tatsuya@example.com','image' => 'e0000.png','hire_date' => '2020-04-01','leave_date' => '','pass_id' => '',],
            ['id' => '1','name' => '柳原 了','kana_name' => 'やなぎはら りょう','department' => '東京支店','position' => '主任','gender' => '男性','birthday' => '36025','tell' => '090-9689-3478','email' => 'yanagihara_ryou@example.com','image' => 'e0001.png','hire_date' => '2020-04-01','leave_date' => '','pass_id' => '',],
            ['id' => '2','name' => '浅利 良介','kana_name' => 'あさり りょうすけ','department' => '神奈川支店','position' => '係長','gender' => '男性','birthday' => '35810','tell' => '080-4490-7351','email' => 'asari_ryousuke@example.com','image' => 'e0002.png','hire_date' => '2020-04-01','leave_date' => '','pass_id' => '',],
            ['id' => '3','name' => '井口 雄太','kana_name' => 'いぐち ゆうた','department' => '神奈川支店','position' => '一般社員','gender' => '男性','birthday' => '35866','tell' => '080-4656-4464','email' => 'iguchi_yuuta@example.com','image' => 'e0003.png','hire_date' => '2020-04-01','leave_date' => '','pass_id' => '',],
            ['id' => '4','name' => '今 洋介','kana_name' => 'こん ようすけ','department' => '神奈川支店','position' => '一般社員','gender' => '男性','birthday' => '35541','tell' => '080-7557-5015','email' => 'kon_yousuke@example.com','image' => 'e0004.png','hire_date' => '2020-04-01','leave_date' => '','pass_id' => '',],
            ['id' => '5','name' => '太田 隼士','kana_name' => 'おおた しゅんじ','department' => '東京支店','position' => '主任','gender' => '男性','birthday' => '36256','tell' => '090-3209-3541','email' => 'oota_shunji@example.com','image' => 'e0005.png','hire_date' => '2020-04-01','leave_date' => '','pass_id' => '',],
            ['id' => '6','name' => '海音寺 竜次','kana_name' => 'かいおんじ りゅうじ','department' => '神奈川支店','position' => '主任','gender' => '男性','birthday' => '36607','tell' => '090-4361-3462','email' => 'kaionji_ryuuji@example.com','image' => 'e0006.png','hire_date' => '2020-04-01','leave_date' => '','pass_id' => '',],
            ['id' => '7','name' => '白鳥 明宏','kana_name' => 'しらとり あきひろ','department' => '神奈川支店','position' => '一般社員','gender' => '男性','birthday' => '35749','tell' => '080-7587-2383','email' => 'shiratori_akihiro@example.com','image' => 'e0007.png','hire_date' => '2020-04-01','leave_date' => '','pass_id' => '',],
            ['id' => '8','name' => '宮脇 きみまろ','kana_name' => 'みやわき きみまろ','department' => '千葉支店','position' => '係長','gender' => '男性','birthday' => '35448','tell' => '080-7686-1382','email' => 'miyawaki_kimimaro@example.com','image' => 'e0008.png','hire_date' => '2020-04-01','leave_date' => '','pass_id' => '',],
            ['id' => '9','name' => '蛍原 徹','kana_name' => 'ほとはら とおる','department' => '千葉支店','position' => '一般社員','gender' => '男性','birthday' => '35716','tell' => '090-2463-8688','email' => 'hotohara_tooru@example.com','image' => 'e0009.png','hire_date' => '2020-04-01','leave_date' => '','pass_id' => '',],
            ['id' => '10','name' => '矢野 詩織','kana_name' => 'やの しおり	','department' => '神奈川支店','position' => '一般社員','gender' => '女性','birthday' => '34926','tell' => '090-9840-1414','email' => 'yano_shiori@example.com','image' => 'e0010.png','hire_date' => '2020-04-01','leave_date' => '','pass_id' => '',],
            ['id' => '11','name' => '小西 美希','kana_name' => 'こにし みき','department' => '東京支店','position' => '一般社員','gender' => '女性','birthday' => '35563','tell' => '080-2869-8109','email' => 'konishi_miki@example.com','image' => 'e0011.png','hire_date' => '2020-04-01','leave_date' => '','pass_id' => '',],
            ['id' => '12','name' => '川村 くるみ','kana_name' => 'かわむら くるみ','department' => '東京支店','position' => '一般社員','gender' => '女性','birthday' => '35596','tell' => '090-4894- 885','email' => 'kawamura_kurumi@example.com','image' => 'e0012.png','hire_date' => '2020-04-01','leave_date' => '','pass_id' => '',],
            ['id' => '13','name' => '坂本 美希','kana_name' => 'さかもと みき','department' => '東京支店','position' => '一般社員','gender' => '女性','birthday' => '35351','tell' => '090-2782-1184','email' => 'sakamoto_miki@example.com','image' => 'e0013.png','hire_date' => '2020-04-01','leave_date' => '','pass_id' => '',],
            ['id' => '14','name' => '高梨 由樹','kana_name' => 'たかなし ゆき','department' => '千葉支店','position' => '主任','gender' => '女性','birthday' => '35520','tell' => '090-1192-1480','email' => 'takanashi_yuki@example.com','image' => 'e0014.png','hire_date' => '2020-04-01','leave_date' => '','pass_id' => '',],
            ['id' => '15','name' => '多田 優','kana_name' => 'ただ ゆう','department' => '千葉支店','position' => '一般社員','gender' => '女性','birthday' => '36159','tell' => '080-8587-5786','email' => 'tada_yuu@example.com','image' => 'e0015.png','hire_date' => '2020-04-01','leave_date' => '','pass_id' => '',],
            ['id' => '16','name' => '野村 昴','kana_name' => 'のむら すばる','department' => '東京支店','position' => '係長','gender' => '女性','birthday' => '35380','tell' => '090-6673- 19','email' => 'nomura_subaru@example.com','image' => 'e0016.png','hire_date' => '2020-04-01','leave_date' => '','pass_id' => '',],
            ['id' => '17','name' => '金井 薫','kana_name' => 'かない かおる','department' => '東京支店','position' => '一般社員','gender' => '女性','birthday' => '35750','tell' => '090-2142-7917','email' => 'kanai_kaoru@example.com','image' => 'e0017.png','hire_date' => '2020-04-01','leave_date' => '','pass_id' => '',],
            ['id' => '18','name' => '大後 寿々花','kana_name' => 'おおご すずか','department' => '東京支店','position' => '一般社員','gender' => '女性','birthday' => '36776','tell' => '080-5280-4129','email' => 'oogo_suzuka@example.com','image' => 'e0018.png','hire_date' => '2020-04-01','leave_date' => '','pass_id' => '',],
            ['id' => '19','name' => '金子 詩織','kana_name' => 'かねこ しおり','department' => '東京支店','position' => '一般社員','gender' => '女性','birthday' => '36117','tell' => '080-6734-6725','email' => 'kaneko_shiori@example.com','image' => 'e0019.png','hire_date' => '2020-04-01','leave_date' => '','pass_id' => '',],
        ];

        foreach ($employees as $key => $employee)
        {
            $employee = new \App\Models\Employee($employee);
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
