@extends('employee_list.parts._base')


@section('title','')


@section('breadcrumb_li')
@endsection


@section('oparation_btn')
    @include('employee_list.parts.oparation_btn')
@endsection


@section('main_contents')
<table class="all_list">
    <thead>
        <tr>
            <td>ID</td>
            <td></td> <!-- image -->
            <td class="long">氏名</td>
            <td class="long">ふりがな</td>
            <td class="long">役職</td>
            <td class="long">所属部署</td>
            <td></td> <!-- button -->
            <td></td> <!-- button -->

        </tr>
    </thead>
    <tbody>
        @forelse($employees as $employee)
        <tr>
            <td>{{sprintf("%04d",$employee->id)}}</td>
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
                <form action="{{route('employee_list.admin.update')}}" method="get">
                    @csrf
                    <input type="hidden" name="id" value="{{$employee->id}}">
                    <button type="submit" class="btn-1">編集</button>
                </form>
            </td>
            <td>
                <form action="{{route('employee_list.admin')}}" method="post" onSubmit="return deleteConfirm()">
                    @csrf
                    <input type="hidden" name="mode" value="delete">
                    <input type="hidden" value="{{$employee->id}}" name="id">
                    <button type="submit" class="btn-1">削除</button>
                </form>
            </td>

        </tr>
        @empty
        <tr><td colspan="7">検索内容に一致する情報がありません</td></tr>
        @endforelse

    </tbody>

</table>
{{-- アラート表示 --}}
@switch($mode)
    @case('insert')
        <script type="text/javascript">
            window.onload = function(){alert('従業員情報を追加しました。');}
        </script>
        @break

    @case('update')
        <script type="text/javascript">
            window.onload = function(){alert('従業員情報を修正しました。');}
        </script>
        @break

    @case('delete')
        <script type="text/javascript">
            window.onload = function(){alert('従業員情報を一件削除しました。');}
        </script>
        @break
@endswitch


@endsection

