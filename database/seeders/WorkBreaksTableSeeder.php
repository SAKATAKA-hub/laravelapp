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
                'in'=>8*60*60,
                'out'=>17*60*60
                ,
                'breaks'=>[
                    ['in'=>11*60*60, 'out'=>11*60*60 + 30*60,],
                    ['in'=>13*60*60, 'out'=>13*60*60 + 30*60,],
                ],
                'RestrainTime' => 9*60*60,
                'BreakTime' => 1*60*60,
                'WorkingTime' => 8*60*60,
            ],
            'b'=>[
                'in'=>10*60*60,
                'out'=>17*60*60
                ,
                'breaks'=>[
                    ['in'=>11*60*60 + 30*60, 'out'=>12*60*60,],
                    ['in'=>13*60*60 + 30*60,'out'=>14*60*60,],
                ],
                'RestrainTime' => 7*60*60,
                'BreakTime' => 1*60*60,
                'WorkingTime' => 6*60*60,

            ],
            'c'=>[
                'in'=>17*60*60
                ,
                'out'=>22*60*60,
                'breaks'=>[
                    ['in'=>20*60*60,'out'=>20*60*60 + 30*60,],
                ],
                'RestrainTime' => 5*60*60,
                'BreakTime' => 30*60,
                'WorkingTime' => 4*60*60 + 30*60,

            ],
            'd'=>[
                'in'=>18*60*60,
                'out'=>24*60*60,
                'breaks'=>[
                    ['in'=>20*60*60 + 30*60,'out'=>21*60*60,],
                ],
                'RestrainTime' => 6*60*60,
                'BreakTime' => 30*60,
                'WorkingTime' => 5*60*60 + 30*60,

            ],
            'e'=>[
                'in'=>22*60*60,
                'out'=>24*60*60,
                'breaks'=>[
                    ['in'=>23*60*60 + 30*60,'out'=>24*60*60,],
                ],
                'RestrainTime' => 2*60*60,
                'BreakTime' => 30*60,
                'WorkingTime' => 1*60*60 + 30*60,

            ],
            'f'=>[
                'in'=>0*60*60,
                'out'=>8*60*60,
                'breaks'=>[
                    ['in'=>4*60*60,'out'=>5*60*60,],
                ],
                'RestrainTime' => 8*60*60,
                'BreakTime' => 1*60*60,
                'WorkingTime' => 7*60*60,

            ],
            'g'=>[
                'in'=>18*60*60,
                'out'=>22*60*60,
                'breaks'=>[],
                'RestrainTime' => 9*60*60,
                'BreakTime' => 1*60*60,
                'WorkingTime' => 8*60*60,

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
        for ($n=3; $n >= 0; $n--)
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

                            $work_id ++;
                        }
                    }
                }
            }


        }

    }
}



