@extends('_common.layout')

{{-- ページタイトル --}}
@section('title','')

{{-- パンクズリスト --}}
@section('breadcrumb_li')
@endsection

{{-- 小見出し --}}
@section('subheading',$app_menus[$app_menu_current]['text'])

{{-- 操作ボタン --}}
@section('oparation_btn')
    @include('attendance_manegement.parts.oparation_btn')
@endsection

{{-- メインコンテンツ --}}
@section('main_contents')
<div class="date_table_box">
    <h4>
        <p>勤務月 : {{$date}}</p>
        <p>勤務現場 : {{empty($place)? '全て': $place}}</p>　
    </h4>
    <table>
        <thead>
            <tr>
                <th class="td_image"></th> <!-- image -->
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
            @forelse ($worked_records as $record)
            <tr>
                <td><img class="employee_img" src="{{url('image/employees/'.$record->employee->image)}}" alt="user image"></td>
                <td class="td_name">
                    <p class="id">{{sprintf('%04d',$record->employee_id)}}</p>
                    <p>{{$record->employee->name}}</p>
                </td>
                <td>{{$record->place}}</td>
                <td>{{gmdate('H:i',$record->in)}}-{{gmdate('H:i',$record->out)}}</td>
                <td>
                    @foreach ($record->work_breaks as $break)
                    <p>{{gmdate('H:i',$break->in)}} - {{$break->out == NULL? '--:--': gmdate('H:i',$break->out)}}</p>
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
                <td colspan="3"></td>
                <td>{{$TotalRestrainTime}}</td>
                <td>{{$TotalBreakTime}}</td>
                <td>{{$TotalWorkingTime}}</td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection


