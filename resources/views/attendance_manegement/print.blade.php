<!doctype html>
<html>
<head>
<meta charset="utf-8">
<style type="text/css">
    table{
        border-collapse: collapse;/*隣り合うセルの境界線を重ねて表示*/
        border-spacing: 0;/*境界線の感覚を無くす*/
        border: solid 1px #bbb;
    }
    th{
        text-align: center;
        height: 26px;
        line-height: 20px;
    }
    td{
        text-align: center;
        height: 26px;
        line-height: 20px;
        border-top: solid 1px #bbb;
    }
</style>
</head>
{{--
    コメント　
    要素内の改行は、要素を増やさずに<br> を使う。
--}}

<body>
    <h3>日別勤怠一覧</h3>
    <div class="date_table_box">
        <h4>2021年 4月 4日(日)  勤務現場 : 東京支店</h4>
        <table>
            <thead>
                <tr>
                    <th class="td_long td_name">ID・従業員名</th>
                    <th class="td_long">出勤現場</th>
                    <th class="td_long">出勤時間</th>
                    <th class="td_long">休憩開始</th>
                    <th >勤務時間</th>
                    <th >休憩時間</th>
                    <th >労働時間</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="td_name">
                        1111
                        <br>山田　宗一郎
                    </td>
                    <td>東京支店</td>
                    <td>00:00 - 00:00</td>
                    <td>
                        00:00 - 00:00
                        <br>00:00 - 00:00
                        <br>00:00 - 00:00
                    </td>
                    <td>00:00</td>
                    <td>00:00</td>
                    <td>00:00</td>

                </tr>
                <tr>
                    <td class="td_name">
                        1111
                        <br>山田　宗一郎
                    </td>
                    <td>東京支店</td>
                    <td>00:00 - 00:00</td>
                    <td><br>00:00 - 00:00</td>
                    <td>00:00</td>
                    <td>00:00</td>
                    <td>00:00</td>

                </tr>
                <tr>
                    <td class="td_name">
                        1111
                        <br>山田　宗一郎
                    </td>
                    <td>東京支店</td>
                    <td>00:00 - 00:00</td>
                    <td>00:00 - 00:00</td>
                    <td>00:00</td>
                    <td>00:00</td>
                    <td>00:00</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">合計時間</td>
                    <td colspan="2"></td>
                    <td>00:00</td>
                    <td>00:00</td>
                    <td>00:00</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
