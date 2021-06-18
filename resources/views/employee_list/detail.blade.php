@extends('employee_list.parts._base')

@section('title','/従業員詳細画面')

@section('breadcrumb_li')
<li>従業員詳細画面</li>
@endsection


@section('oparation_btn')
<h2>従業員詳細画面</h2>
@endsection


@section('main_contents')
<div class="employee_container">
    <table class="job-t">
        <tr>
            <td>
                <img class="employee_img" src="{!!url('image/employees/'.$employee->image)!!}" alt="{{$employee->name}}さんの画像">
            </td>
            <td colspan="2">
                <p>{{sprintf("%04d",$employee->id)}}</p>
                <p>{{$employee->kana_name}}</p>
                <h2>{{$employee->name}}</h2>
            </td>
        </tr>
        <tr>
            <td>役職：{{$employee->position}}</td>
            <td>所属部署：{{$employee->department}}</td>
            <td>性別：{{$employee->gender}}</td>
        </tr>
    </table>

    <table class="work-t">
        <tr><td colspan="8">契約曜日</td></tr>
        <tr><td>月</td><td>火</td><td>水</td><td>木</td><td>金</td><td>土</td><td>日</td><td>祝日</td></tr>
        <tr><td>0-00</td><td>0-00</td><td>0-00</td><td>0-00</td><td>0-00</td><td>0-00</td><td>0-00</td><td>0-00</td></tr>
    </table>

    <table class="individual-t">
        <tr><td>電話番号</td><td>{{$employee->tell}}</td></tr>
        <tr><td>メール</td><td>{{$employee->email}}</td></tr>
        <tr><td>生年月日</td><td>{{$employee->birthday}}</td></tr>
        <tr><td>入社日</td><td>{{$employee->hire_date}}</td></tr>
        <tr><td>退社日</td><td>-</td></tr>
    </table>

</div>

@include('employee_list.parts.submit_container',['btn_text'=>''])

@endsection
