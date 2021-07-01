<?php
namespace App\Http\Controllers\library;

# ------------------------------------
# 指定月の日時情報を取得するクラス
# -----------------------------------
class DateItems
{
    # 今月の情報を取得
    public function getThisMonth($Ymd) //$Ymd = 'Y/m/d'
    {
        list($Y, $m, $d) = explode('/',$Ymd);
        $next_Y = $m +1 > 12? $Y +1: $Y;
        $next_m = $m +1 > 12? $m +1 -12: $m +1;

        $stamp =  mktime(0,0,0,$m, $d ,$Y);
        $first_stamp = mktime(0,0,0,$m,01,$Y);
        $last_stamp = mktime(0,0,0,$next_m,00,$next_Y);

        $w = date('w',$stamp);
        $first_w = date('w',$first_stamp);
        $last_w = date('w',$last_stamp);

        $jp_weeks = ['(日)','(月)','(火)','(水)','(木)','(金)','(土)',];

        return [
            'Y' => $Y, // 年
            'm' => $m, // 月
            'd' => date('d',$stamp), // 日
            'w' => date('w',$stamp), // 曜日番号
            'jpw' => $jp_weeks[$w], // 日本語曜日

            'Ymd' => date('Y/m/d',$stamp),
            'Ymd_text' => date('Y年m月d日',$stamp).$jp_weeks[$w],
            'Ym' => date('Y/m',$stamp),
            'Ym_text' => date('Y年m月',$stamp),


            'first_d' => date('d',$first_stamp), // 月始日
            'first_w' => date('w',$first_stamp), // 月始曜日
            'last_d' => date('d',$last_stamp), // 月末日
            'last_w' => date('w',$last_stamp), // 月末曜日
        ];
    }

    # $nヶ月前の情報を取得
    public function getBeforMonth($Ymd,$n)
    {
        list($Y, $m, $d) = explode('/',$Ymd);

        $nY = floor($n /12);
        $nm = $n %12;
        $befor_Y = $m -$nm > 0? $Y -$nY: $Y -$nY -1;
        $befor_m = $m -$nm > 0? $m -$nm: $m -$nm +12;
        $befor_Ymd = sprintf('%s/%s/%s',$befor_Y, $befor_m, $d);

        return $this->getThisMonth($befor_Ymd);
    }

    # $nヶ月後の情報を取得
    public function getAfterMonth($Ymd,$n)
    {
        list($Y, $m, $d) = explode('/',$Ymd);

        $nY = floor($n /12);
        $nm = $n %12;
        $after_Y = $m +$nm > 12? $Y +$nY +1: $Y +$nY;
        $after_m = $m +$nm > 12? $m +$nm -12: $m +$nm;
        $after_Ymd = sprintf('%s/%s/%s',$after_Y, $after_m, $d);

        return $this->getThisMonth($after_Ymd);
    }

}


// $dob = new DateItems;
// $n=1;
// $Ymd = '2021/7/1';
// $d_items = $dob->getThisMonth($Ymd);
// $d_items = $dob->getBeforMonth($Ymd,$n);
// $d_items = $dob->getAfterMonth($Ymd,$n);

// foreach ($d_items as $key => $item) {
//     echo sprintf('%s=>%s',$key, $item).'<br>';
// }
