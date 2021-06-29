<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CheckboxesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['group' => '性別','item' => '女性',],
            ['group' => '性別','item' => '男性',],
            ['group' => '性別','item' => 'その他',],

            ['group' => '役職','item' => '課長',],
            ['group' => '役職','item' => '係長',],
            ['group' => '役職','item' => '主任',],
            ['group' => '役職','item' => '一般社員',],

            ['group' => '所属部署','item' => '東京支店',],
            ['group' => '所属部署','item' => '神奈川支店',],
            ['group' => '所属部署','item' => '千葉支店',],
            ['group' => '所属部署','item' => '埼玉支店',],
        ];

        foreach ($items as $key => $item)
        {
            $data = new \App\Models\Checkbox($item); //モデル名
            $data->save();
        }

    }
}
