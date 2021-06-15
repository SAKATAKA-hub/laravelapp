@extends('employee_list.parts._base')

@section('title','/確認画面')


@section('breadcrumb_li')
<li>確認画面</li>
@endsection


@section('oparation_btn')
<h2>確認画面</h2>
@endsection


@section('main_contents')
@if ($input['mode']=='update')
<h3>下記の内容で編集登録します。よろしいですか？</h3>
@else
<h3>下記の内容で新規登録します。よろしいですか？</h3>
@endif

<form action="{{route('employee_list.admin')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="mode" value="{{$input['mode']}}">
    <div class="employee_container">
        <table class="individual-t">
            <tr>
                <td>
                    <p>ID</p>
                </td>
                <td>
                    <p>{{sprintf('%04d',$input['id'])}}</p>
                    <input type="hidden" name="id" value="{{$input['id']}}">
                </td>
            </tr>
            @php
            $lines = [
                ['text'=>'氏名', 'type'=> 'text', 'name'=> 'name', 'value'=> old('name'), 'require'=> true,],
                ['text'=>'ふりがな', 'type'=> 'text', 'name'=> 'kana_name', 'value'=> old('kana_name'), 'require'=> true,],
            ];
            @endphp
            @foreach($lines as $line)
            <tr>
                <td>
                    <p>{{$line['text']}}</p>
                </td>
                <td>
                    <p>{{$input[$line['name']] ?? '未入力'}}</p>
                    <input type="hidden" name="{{$line['name']}}" value="{{$input[$line['name']]}}">
                </td>
            </tr>
            @endforeach

            <tr>
                <td>
                    <p>従業員画像</p>
                </td>
                <td>
                    @if($file_name) <!--新しい登録画像があるとき-->
                    <img id="preview" class="employee_img" src="{{url($file_path.'/'.$file_name)}}" alt="登録画像">
                    <p>{{$file_path.'/'.$file_name}}</p>
                    <input type="hidden" name="file_name" value="{{$file_name}}">

                    @elseif($input['old_image'])<!--元々の登録画像があるとき-->
                    <img id="preview" class="employee_img" src="{!!url('image/employees/'.$input['old_image'])!!}" alt="登録画像">
                    <p>{{$file_path.'/'.$input['old_image']}}</p>
                    <input type="hidden" name="file_name" value="">

                    @else<!--画像がないとき-->
                    <img id="preview" class="employee_img" src="{{url('image/employees/no_image.png')}}" alt="登録画像">
                    <input type="hidden" name="file_name" value="">
                    @endif
                </td>
            </tr>


            @foreach($checkbox_groups as $checkbox_group)
            <tr>
                <td>
                    <P>{{$checkbox_group['title']}}</P>
                </td>
                <td>
                    <p>{{$input[$checkbox_group['key']]}}</p>
                    <input type="hidden" name="{{$checkbox_group['key']}}" value="{{$input[$checkbox_group['key']]}}">
                </td>
            </tr>

            @endforeach

        </table>

        <table class="individual-t">
            @php
            $lines = [
                ['text'=>'電話番号', 'type'=>'tell', 'name'=>'tell', 'value'=>old('tell'), 'require'=> true,],
                ['text'=>'メール', 'type'=>'email', 'name'=>'email', 'value'=>old('email'), 'require'=> true,],
                ['text'=>'生年月日', 'type'=>'date', 'name'=>'barthday', 'value'=>old('barthday'), 'require'=> false,],
                ['text'=>'入社日', 'type'=>'date', 'name'=>'hire_date', 'value'=>old('hire_date'), 'require'=> false,],
                ['text'=>'退社日', 'type'=>'date', 'name'=>'leave_date', 'value'=>old('leave_date'), 'require'=> false,],
            ];
            @endphp

            @foreach($lines as $line)
            <tr>
                <td>
                    <p>{{$line['text']}}</p>
                </td>
                <td>
                    <p>{{$input[$line['name']] ?? '未入力'}}</p>
                    <input type="hidden" name="{{$line['name']}}" value="{{$input[$line['name']]}}">
                </td>
            </tr>
            @endforeach
        </table>

    <div class="submit_container">
        <button class="color" type="submit">登録</button>
        <div onclick="history.back()">戻る</div>
    </div>

</form>

@endsection


