<!doctype html>
<html>
<head>
<meta charset="utf-8">
<style type="text/css">
    table{
        border-collapse: collapse;/*隣り合うセルの境界線を重ねて表示*/
        border-spacing: 0;/*境界線の感覚を無くす*/
        /* border: solid 1px #bbb; */
        border-left: solid 1px #bbb;
        border-right: solid 1px #bbb;
    }
    th{
        text-align: center;
        height: 26px;
        line-height: 20px;
        border-top: solid 1px #bbb;
        border-bottom: solid 1px #bbb;
    }
    td{
        text-align: center;
        height: 26px;
        line-height: 20px;
        border-top: solid 1px #bbb;
        border-bottom: solid 1px #bbb;
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
        <h4>勤務日 : {{$date}}  勤務現場 : {{$place}}</h4>
        <table>
            <thead>
                <tr>
                    <th>ID・従業員名</th>
                    <th>出勤現場</th>
                    <th>出勤時間</th>
                    <th>休憩開始</th>
                    <th>勤務時間</th>
                    <th>休憩時間</th>
                    <th>労働時間</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($worked_records as $record)
                <tr>
                    <td class="td_name">
                        {{sprintf('%04d',$record->employee_id)}}<br>
                        {{$record->employee->name}}
                    </td>
                    <td>{{$record->place}}</td>
                    <td>{{gmdate('H:i',$record->in)}}-{{gmdate('H:i',$record->out)}}</td>
                    <td>
                        @foreach ($record->work_breaks as $break)
                        @if ($loop->last)
                        {{gmdate('H:i',$break->in)}} - {{$break->out == NULL? '--:--': gmdate('H:i',$break->out)}}
                        @else
                        {{gmdate('H:i',$break->in)}} - {{$break->out == NULL? '--:--': gmdate('H:i',$break->out)}}<br>
                        @endif
                        @endforeach
                    </td>
                    <td>{{gmdate('H:i',$record->RestrainTime)}}</td>
                    <td>{{gmdate('H:i',$record->BreakTime)}}</td>
                    <td>{{gmdate('H:i',$record->WorkingTime)}}</td>

                </tr>


                @empty
                <tr><td colspan="10">勤務情報がありません。</td></tr>
                @endforelse


            </tbody>

            <tfoot>
                <tr>
                    <td colspan="2">合計時間</td>
                    <td colspan="2"></td>
                    <td>{{$TotalRestrainTime}}</td>
                    <td>{{$TotalBreakTime}}</td>
                    <td>{{$TotalWorkingTime}}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
