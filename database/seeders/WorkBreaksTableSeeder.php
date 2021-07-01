<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkBreak; //モデルの利用

class WorkBreaksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # 勤務時間パターン
        $pattern = [
            'a'=>[
                'in'=>'8:00',
                'out'=>'17:00',
                'breaks'=>[
                    ['in'=>'11:00','out'=>'11:30',],
                    ['in'=>'13:00','out'=>'13:30',],
                ],
                'RestrainTime' => '9:00',
                'BreakTime' => '1:00',
                'WorkingTime' => '8:00',
            ],
            'b'=>[
                'in'=>'10:00',
                'out'=>'17:00',
                'breaks'=>[
                    ['in'=>'11:30','out'=>'12:00',],
                    ['in'=>'13:30','out'=>'14:00',],
                ],
                'RestrainTime' => '7:00',
                'BreakTime' => '1:00',
                'WorkingTime' => '6:00',

            ],
            'c'=>[
                'in'=>'17:00',
                'out'=>'22:00',
                'breaks'=>[
                    ['in'=>'20:00','out'=>'20:30',],
                ],
                'RestrainTime' => '5:00',
                'BreakTime' => '0:30',
                'WorkingTime' => '4:30',

            ],
            'd'=>[
                'in'=>'18:00',
                'out'=>'24:00',
                'breaks'=>[
                    ['in'=>'20:30','out'=>'21:00',],
                ],
                'RestrainTime' => '6:00',
                'BreakTime' => '0:30',
                'WorkingTime' => '5:30',

            ],
            'e'=>[
                'in'=>'22:00',
                'out'=>'0:00',
                'breaks'=>[
                    ['in'=>'23:30','out'=>'24:00',],
                ],
                'RestrainTime' => '2:00',
                'BreakTime' => '0:30',
                'WorkingTime' => '1:30',

            ],
            'f'=>[
                'in'=>'0:00',
                'out'=>'8:00',
                'breaks'=>[
                    ['in'=>'4:00','out'=>'5:00',],
                ],
                'RestrainTime' => '8:00',
                'BreakTime' => '1:00',
                'WorkingTime' => '7:00',

            ],
            'g'=>[
                'in'=>'18:00',
                'out'=>'22:00',
                'breaks'=> null,
                'RestrainTime' => '9:00',
                'BreakTime' => '1:00',
                'WorkingTime' => '8:00',

            ],
        ];

        # 契約出勤日
        $ContractWorkingDays = [
            1 =>[
                1 =>[$pattern['a']],
                2 =>[$pattern['a']],
                3 =>[$pattern['a']],
                4 =>[$pattern['a']],
                5 =>[$pattern['a']],
                6 =>NULL,
                0 =>NULL,
                7 =>NULL,
            ],
            2 =>[
                1 =>[$pattern['b']],
                2 =>[$pattern['b']],
                3 =>[$pattern['b']],
                4 =>[$pattern['b']],
                5 =>[$pattern['b']],
                6 =>NULL,
                0 =>NULL,
                7 =>NULL,
            ],
            3 =>[
                1 =>[$pattern['c']],
                2 =>[$pattern['c']],
                3 =>[$pattern['c']],
                4 =>[$pattern['c']],
                5 =>[$pattern['c']],
                6 =>NULL,
                0 =>NULL,
                7 =>NULL,
            ],
            4 =>[
                1 =>[$pattern['d']],
                2 =>[$pattern['d']],
                3 =>[$pattern['d']],
                4 =>[$pattern['d']],
                5 =>[$pattern['g']],
                6 =>NULL,
                0 =>NULL,
                7 =>NULL,
            ],
            5 =>[
                1 =>[$pattern['e']],
                2 =>[$pattern['f'], $pattern['e']],
                3 =>[$pattern['f'], $pattern['e']],
                4 =>[$pattern['f'], $pattern['e']],
                5 =>NULL,
                6 =>NULL,
                0 =>NULL,
                7 =>NULL,
            ],

        ];

        #出勤記録の保存
        $work_id = 1;

        // $nヶ月間の出勤記録
        for ($n=3; $n > 0; $n--)
        {
            $dateOb = new DateItems;
            $item = $dateOb->getBeforMonth(1,$n); //nヶ月後の情報を取得(d,n)

            // 1日～月末
            for ($d=1; $d <= $item['last_d']; $d++)
            {
                $day = $dateOb->getThisMonth($d,$item['m'],$item['Y']);

                //従業員ID
                for ($e=1; $e <= 5; $e++)
                {
                    $works = $ContractWorkingDays[$e][$day['w']];
                    // 一人が一日複数回出勤する記録の出力
                    if(!empty( $works )){
                        foreach ($works as $work)
                        {
                            $work_id ++;

                            if(!empty( $work['breaks'] )){
                                foreach ($work['breaks'] as $break)
                                {
                                    $work_break = new WorkBreak([
                                        'work_id' => $work_id,
                                        'in'=> $break['in'],
                                        'out' => $break['out'],
                                    ]);
                                    $work_break->save();
                                }
                            }
                        }
                    }
                }
            }


        }

    }
}



