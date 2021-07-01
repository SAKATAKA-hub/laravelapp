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
    {{-- @include('employees_manegement.parts.oparation_btn') --}}
@endsection

{{-- メインコンテンツ --}}
@section('main_contents')
<div class="person_table_box">
    <h4>検索従業員名 :</h4>
    <div class="pason_item">
        <img class="employee_img" src="../../../public/image/employees/e0001.png" alt="user image">
        <p class="id">0000</p>
        <p class="name">山田　宗一郎</p>
    </div>

    <table>
        <thead>
            <tr>
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
            <tr>
                <td>東京支店</td>
                <td class="point_td">00:00</td>
                <td class="point_td">00:00</td>
                <td class="point_td">00:00</td>
                <td class="point_td">00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>

            </tr>
            <tr>
                <td>東京支店</td>
                <td class="point_td">00:00</td>
                <td class="point_td">00:00</td>
                <td class="point_td">00:00</td>
                <td class="point_td">00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>

            </tr>
            <tr>
                <td>東京支店</td>
                <td class="point_td">00:00</td>
                <td class="point_td">00:00</td>
                <td class="point_td">00:00</td>
                <td class="point_td">00:00</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>

            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">合計時間</td>
                <td colspan="3"></td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection


