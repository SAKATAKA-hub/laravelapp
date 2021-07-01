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
<div class="month_table_box">
    <h4>検索年月 : 2021年 4月</h4>
    <h4>出勤現場 : 全て</h4>
    <table>
        <thead>
            <tr>
                <th class="td_image"></th> <!-- image -->
                <th class="td_name">ID・従業員名</th>
                <th class="td_item"></th> <!-- button -->
                <th class="td_item">出勤現場</th>
                <th class="td_item">勤務時間</th>
                <th class="td_item">休憩時間</th>
                <th class="td_item">労働時間</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><img class="employee_img" src="../../../public/image/employees/e0001.png" alt="user image"></td>
                <td class="td_name">
                    <p class="id">1111</p>
                    <p>山田　宗一郎</p>
                </td>
                <td>
                    <form action="">
                        <input type="hidden" name="" value="0001">
                        <button class="btn-1" type="submit">詳細</button>
                    </form>
                </td>
                <td>東京支店</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
            </tr>
            <tr>
                <td><img class="employee_img" src="../../../public/image/employees/e0001.png" alt="user image"></td>
                <td class="td_name">
                    <p class="id">1111</p>
                    <p>山田　宗一郎</p>
                </td>
                <td>
                    <form action="">
                        <input type="hidden" name="" value="0001">
                        <button class="btn-1" type="submit">詳細</button>
                    </form>
                </td>
                <td>東京支店</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>00:00</td>
            </tr>
            <tr>
                <td><img class="employee_img" src="../../../public/image/employees/e0001.png" alt="user image"></td>
                <td class="td_name">
                    <p class="id">1111</p>
                    <p>山田　宗一郎</p>
                </td>
                <td>
                    <form action="">
                        <input type="hidden" name="" value="0001">
                        <button class="btn-1" type="submit">詳細</button>
                    </form>
                </td>
                <td>東京支店</td>
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
@endsection


