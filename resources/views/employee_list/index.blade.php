@extends('employee_list.parts._base')

@section('title','')

@section('breadcrumb_li')
@endsection


@section('oparation_btn')
    @include('employee_list.parts.oparation_btn',['insert_btn'=>'display:none'])
@endsection


@section('main_contents')

<!-- --------------------------------------------
<div>
@php
var_dump($seachs);
@endphp
</div>

@if(
    !isset($seachs["keyword"]) &&
    !isset($seachs["department"]) &&
    !isset($seachs["position"]) &&
    !isset($seachs["gender"])
)
<h3>検索条件はありません</h3>
@else
<h3>検索条件があります</h3>
@endif
-------------------------------------------- -->
<table class="all_list">
    <thead>
        <tr>
            <td>ID</td>
            <td></td> <!-- image -->
            <td class="long">氏名</td>
            <td class="long">ふりがな</td>
            <td class="long">役職</td>
            <td class="long">所属部署</td>
            <td class="long"></td> <!-- button -->
        </tr>
    </thead>
    <tbody>
        @forelse($employees as $employee)
        <tr>
            <td>{{sprintf("%04d",$employee->id)}}</td>
            {{-- <td><img class="employee_img" src="image/employees/{{$employee->image}}" alt="{{$employee->name}}さんの画像"></td> --}}
            @isset($employee->image)
            <td><img class="employee_img" src="{!!url('image/employees/'.$employee->image)!!}" alt="{{$employee->name}}さんの画像"></td>
            @else
            <td><img class="employee_img" src="{!!url('image/employees/e8888.png')!!}" alt="{{$employee->name}}さんの画像"></td>
            @endisset
            <td>{{$employee->name}}</td>
            <td>{{$employee->kana_name}}</td>
            <td>{{$employee->position}}</td>
            <td>{{$employee->department}}</td>
            <td>
                <form action="{{route('employee_list.detail')}}" method="post">
                    @csrf
                    <input type="hidden" value="{{$employee->id}}" name="id">
                    <button type="submit" class="btn-1">詳細</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="7">検索内容に一致する情報がありません</td></tr>
        @endforelse

    </tbody>
</table>


@endsection
