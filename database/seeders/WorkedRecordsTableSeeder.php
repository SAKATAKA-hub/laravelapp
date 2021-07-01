<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkedRecord; //モデルの利用

class WorkedRecordsTableSeeder extends Seeder
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
            'a'=>['in'=>'8:00', 'out'=>'17:00', 'breaks'=>'11:00-11:30,13:00-13:30', ],
            'b'=>['in'=>'10:00', 'out'=>'17:00', 'breaks'=>'11:30-12:00,13:30-14:00', ],
            'c'=>['in'=>'17:00', 'out'=>'22:00', 'breaks'=>'20:00-20:30', ],
            'd'=>['in'=>'18:00', 'out'=>'24:00', 'breaks'=>'20:30-21:00', ],
            'e'=>['in'=>'22:00', 'out'=>'0:00', 'breaks'=>'23:00-24:00', ],
            'f'=>['in'=>'0:00', 'out'=>'8:00', 'breaks'=>'4:00-5:00', ],
            'g'=>['in'=>'18:00', 'out'=>'22:00', 'breaks'=>'', ],
        ];

        # 曜日名
        $days = ['sun','mon','tue','wed','thu','fri','sat','hol',];
        $mb_days = ['日','月','火','水','木','金','土','祝日',];


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
        // $nヶ月間の出勤記録
        for ($n=3; $n > 0; $n--)
        {
            // $n =1;

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
                    if(!empty( $works ))
                    {
                        foreach ($works as $work)
                        {
                            $worked_record = new WorkedRecord([
                            'employee_id' => $e,
                            'work_num' => 1,
                            'date' => sprintf('%04d/%02d/%02d', $item['Y'],$item['m'],$d) ,
                            'in'=> $work['in'],
                            'out' => $work['out'],
                            'breaks' => $work['breaks'],
                            'RestrainTime' => NULL,
                            'BreakTime' => NULL,
                            'WorkingTime' => NULL,
                            ]);
                            $worked_record->save();
                        }
                    }
                }
            }


        }


    }

}


# ------------------------------------
# 指定月の日時情報を取得するクラス
# -----------------------------------
class DateItems
{
    # 今月の情報を取得
    public function getThisMonth($day,$month,$year)
    {
        $stamp = empty($month)&&empty($year)? time(): mktime(0,0,0,$month,$day,$year);

        $Ymd = date("Y/m/d",$stamp);
        $Y = date("Y",$stamp);
        $m = date("m",$stamp);

        $stamp = mktime(0,0,0,$m,$day,$Y);

        $next_Y = $m +1 > 12? $Y +1: $Y;
        $next_m = $m +1 > 12? $m +1 -12: $m +1;
        $last_stamp = mktime(0,0,0,$next_m,00,$next_Y);
        $first_stamp = mktime(0,0,0,$m,01,$Y);

        return [
            'Y' => $Y, // 年
            'm' => $m, // 月
            'd' => date('d',$stamp), // 日
            'w' => date('w',$stamp), // 曜日番号
            'first_d' => date('d',$first_stamp), // 月始日
            'first_w' => date('w',$first_stamp), // 月始曜日
            'last_d' => date('d',$last_stamp), // 月末日
            'last_w' => date('w',$last_stamp), // 月末曜日
        ];
    }

    # $nヶ月前の情報を取得
    public function getBeforMonth($day,$n)
    {
        $stamp = time();
        $Ymd = date("Y/m/d",$stamp);
        $Y = date("Y",$stamp);
        $m = date("m",$stamp);

        $nY = floor($n /12);
        $nm = $n %12;
        $befor_Y = $m -$nm > 0? $Y -$nY: $Y -$nY -1;
        $befor_m = $m -$nm > 0? $m -$nm: $m -$nm +12;

        return $this->getThisMonth($day,$befor_m,$befor_Y);
    }

    # $nヶ月後の情報を取得
    public function getAfterMonth($day,$n)
    {
        $stamp = time();
        $Ymd = date("Y/m/d",$stamp);
        $Y = date("Y",$stamp);
        $m = date("m",$stamp);

        $nY = floor($n /12);
        $nm = $n %12;
        $after_Y = $m +$nm > 12? $Y +$nY +1: $Y +$nY;
        $after_m = $m +$nm > 12? $m +$nm -12: $m +$nm;

        return $this->getThisMonth($day,$after_m,$after_Y);
    }

}

