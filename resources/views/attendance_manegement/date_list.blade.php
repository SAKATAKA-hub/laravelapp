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
        <p>検索日付 : </p>
        <p>勤務現場 : 東京支店</p>　
    </h4>
    <table>
        <thead>
            <tr>
                <th class="td_image"></th> <!-- image -->
                <th class="td_name">ID・従業員名</th>
                <th class="">出勤現場</th>
                <th class="point_td">出勤時間</th>
                <th class="point_td">退勤時間</th>
                <th class="point_td">休憩開始</th>
                <th class="point_td">休憩終了</th>
                <th>勤務時間</th>
                <th>休憩時間</th>
                <th>労働時間</th>
            </tr>
        </thead>
        <tbody>
            {{-- @forelse ($worked_records as $record)
            <tr>
                <td><img class="employee_img" src="../../../public/image/employees/e0001.png" alt="user image"></td>
                <td class="td_name">
                    <p class="id">{{sprintf('%04d',$record->employee_id)}}</p>
                    <p>{{$record->date}}</p>
                </td>
                <td>○○支店</td>
                <td class="point_td">{{$record->in}}</td>
                <td class="point_td">{{$record->out}}</td>
                <td class="point_td">00:00</td>
                <td class="point_td">00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
            </tr>
            @empty
            <tr><td colspan="10">勤務情報がありません。</td></tr>
            @endforelse --}}

        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">合計時間</td>
                <td colspan="5"></td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
            </tr>
        </tfoot>
    </table>
</div>

@endsection


