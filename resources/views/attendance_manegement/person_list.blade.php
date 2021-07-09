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
<div class="person_table_box">
    <h4>
        @isset($display_text['employee'])
        <div class="pason_item">
            従業員：
            <img class="employee_img" src="{{url('image/employees/'.$display_text['employee']->image)}}" alt="user image">
            <p class="id">{{sprintf('%04d',$display_text['employee']->id)}}</p>
            <p class="name">{{$display_text['employee']->name}}</p>
        </div>
        @endisset

        <p>勤務月：{{$display_text['date']}}</p>
    </h4>



    @if( ($worked_records==NULL) || ($employee_id=='' ) )
    <h4>従業員名を選択してください。</h4>
    @else
    <table>
        <thead>
            <tr>
                <th class="td_item">出勤日</th>
                <th class="td_item">出勤現場</th>
                <th class="td_long">出勤時間</th>
                <th class="td_long">休憩時間</th>
                <th class="td_item">勤務時間</th>
                <th class="td_item">休憩時間</th>
                <th class="td_item">労働時間</th>
            </tr>
        </thead>
        <tbody>

            @forelse ($worked_records as $record)
            <tr>
                <td>{{$record->getDateText()}}</td>
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
            <tr><td colspan="11">勤務情報がありません。</td></tr>
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
    @endif

</div>
@endsection


