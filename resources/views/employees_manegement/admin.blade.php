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
    @include('employees_manegement.parts.oparation_btn')
@endsection

{{-- メインコンテンツ --}}
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
            <td class=""></td> <!-- button -->
            <td class=""></td> <!-- button -->

        </tr>
    </thead>
    <tbody>
        @forelse($employees as $employee)
        <tr>
            <td>{{sprintf("%04d",$employee->id)}}</td>
            @if( empty($employee->image) )
            <td><img class="employee_img" src="{{url('image/employees/e8888.png')}}" alt=""></td>
            @else
            <td><img class="employee_img" src="{{url('image/employees/'.$employee->image)}}" alt=""></td>
            @endif
            <td>{{$employee->name}}</td>
            <td>{{$employee->kana_name}}</td>
            <td>{{$employee->position}}</td>
            <td>{{$employee->department}}</td>
            <td>
                {{-- 編集ボタン --}}
                <a href="{{route('employees_manegement.edit',$employee)}}">
                    <button class="btn-1">編集</button>
                </a>
                {{-- 削除ボタン --}}
            </td>
            <td>
                <form action="{{route('employees_manegement.destroy',$employee)}}" method="post" onSubmit="return deleteConfirm()">
                    @method('DELETE')
                    @csrf
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
