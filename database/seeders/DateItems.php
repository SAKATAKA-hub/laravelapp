<?php
namespace Database\Seeders;

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
