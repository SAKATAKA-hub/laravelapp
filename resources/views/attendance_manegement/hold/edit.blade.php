@extends('_common.layout_admin')

{{-- ページタイトル --}}
@section('title','')

{{-- パンクズリスト --}}
@section('breadcrumb_li')
@endsection

{{-- 小見出し --}}
@section('subheading',$app_menus[$app_menu_current]['text'])

{{-- 操作ボタン --}}
@section('oparation_btn')
@endsection

{{-- メインコンテンツ --}}
@section('main_contents')
<div class="edit">
    <table>
        <tr>
            <td colspan="5">
                <h4>
                    <p>従業員：</p>
                    <div class="pason_item">
                        <img class="employee_img" src="{{url('image/employees/'.$work->employee->image)}}" alt="user image">
                        <p class="id">{{sprintf('%04d',$work->employee_id)}}</p>
                        <p>{{$work->employee->name}}</p>
                    </div>
                    <p>勤務日：</p>
                    <p>{{$date}}</p>
                </h4>
            </td>
        </tr>
        <tr>
            <td class="td_size1 title">出勤時間</td>
            <td class="td_size1">IN
                {{-- <input type="text" name="in" value="{{old('in',gmdate('H:i',$work->in) )}}" size="3"> --}}
                <input type="text" name="in" value="{{gmdate('H:i',$work->in)}}" size="3">
            </td>
            <td class="td_size1">OUT
                {{-- <input type="text" name="out" value="{{old('out',gmdate('H:i',$work->out) )}}" size="3"> --}}
                <input type="text" name="out" value="{{gmdate('H:i',$work->out)}}" size="3">
            </td>
            <td class="td_size1">勤務時間</td>
            <td class="td_size1">労働時間</td>
        </tr>
        @foreach ($work->work_breaks as $break)
        <tr>
            @if ($loop->first)
            <td class="td_size1 title" rowspan="{{$loop->count}}">休憩時間</td>
            @endif
            <td class="td_size1">IN
                brake_in{{$break->id}}
                <input type="text" name="brake_in{{$break->id}}" value="{{gmdate('H:i',$break->in)}}" size="3">
            </td>
            <td class="td_size1">OUT
                brake_out{{$break->id}}
                <input type="text" name="brake_out{{$break->id}}" value="{{gmdate('H:i',$break->out)}}" size="3">
            </td>
            <td class="td_size1">時間</td>
            <td class="td_size1"><button class="btn-1">休憩削除</button></td>
        </tr>
        @endforeach

    </table>
    <div class="submit_container">
        <form action="{{route('attendance_manegement.update',$work)}}" method="POST" id="update">
            @method('PATCH')
            @csrf
            <button class="col_btn">修正確定</button>
        </form>
        <form action="{{route('attendance_manegement.destroy',$work)}}" method="POST" id="destroy">
            @method('DELETE')
            @csrf
            <button class="col_btn">勤怠削除</button>
        </form>
    </div>
    <script>
        'use strict';
        // 修正コンフォーム
        document.getElementById('update').addEventListener('submit',e=>{
            e.preventDefault();
            if(!confirm('この内容で上書きします。\nよろしいですか？')){return;}
            e.target.submit();
        });

        // 削除コンフォーム
        document.getElementById('destroy').addEventListener('submit',e=>{
            e.preventDefault();
            if(!confirm('この勤怠記録を削除します。\nよろしいですか？')){return;}
            e.target.submit();
        });
    </script>

</div>





<h1>Edit</h1>
<p>{{$work->id}}</p>
<p class="id">{{sprintf('%04d',$work->employee_id)}}</p>
<p>{{$work->employee->name}}</p>
<p>{{$work->date}}</p>
<p>{{gmdate('H:i',$work->in)}}-{{gmdate('H:i',$work->out)}}</p>
@foreach ($work->work_breaks as $break)
<p>{{gmdate('H:i',$break->in)}} - {{$break->out == NULL? '--:--': gmdate('H:i',$break->out)}}</p>
@endforeach
<p>{{gmdate('H:i',$work->RestrainTime)}}</p>
<p>{{gmdate('H:i',$work->BreakTime)}}</p>
<p>{{gmdate('H:i',$work->WorkingTime)}}</p>

@endsection
