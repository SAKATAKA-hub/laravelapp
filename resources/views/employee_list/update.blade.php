@extends('employee_list.parts._base')

@section('title','/編集画面')


@section('breadcrumb_li')
<li>編集画面</li>
@endsection

@section('oparation_btn')
<h2>編集画面</h2>
@endsection


@section('main_contents')
<form action="{{route('employee_list.admin.confirm')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="mode" value="update">

    <div class="employee_container">
        <h3>従業員情報を編集してください。</h3>
        <table class="individual-t">
            <!-- 名前入力 -->
            <tr>
                <td>ID</td>
                <td>
                    <p>{{sprintf('%04d',$employee['id'])}}</p>
                    <input type="hidden" name="id" value="{{$employee['id']}}">
                </td>
            </tr>
            @php
            $lines = [
                ['text'=>'氏名', 'type'=> 'text', 'name'=> 'name', 'require'=> true,],
                ['text'=>'ふりがな', 'type'=> 'text', 'name'=> 'kana_name', 'require'=> true,],
            ];
            @endphp

            @foreach ($lines as $line)
            <tr>
                <td>
                    @if($line['require'])
                    <P>{{$line['text']}}</P>
                    <p style="color:red"> 必須</p>
                    @else
                    <P>{{$line['text']}}</P>
                    @endif
                </td>
                <td>
                    <input type="{{$line['type']}}" name="{{$line['name']}}" value="{{old($line['name']) ?? $employee[$line['name']]}}">
                    <p class="ellor" style="color:red">{{implode(' ',$errors->get($line['name']))}}</p>
                </td>
            </tr>
            @endforeach

            <!-- 画像入力 -->
            <tr>
                <td>従業員画像</td>
                <td>
                    <input type="file" name="image" id="myImage" accept="image/*" onchange="setImage(this);" onclick="this.value = '';">
                    @isset($employee->image)
                    <img id="preview" class="employee_img" src="{!!url('image/employees/'.$employee->image)!!}" alt="{{$employee->name}}さんの画像">
                    <input type="hidden" name="old_image" value = {{$employee->image}}">
                    @else
                    <img id="preview" class="employee_img" src="{{url('image/employees/no_image.png')}}" alt="未登録の画像">
                    @endisset

                    <p class="ellor" style="color:red">{{implode(' ',$errors->get('image'))}}</p>
                    @if ($errors->all())
                    <p class="ellor" style="color:red">画像ファイルを入れ直してください。</p>
                    @endif

                </td>
            </tr>
            <!-- セレクトボックス -->
            @foreach ($checkbox_groups as $checkbox_group)
            <tr>
                <td>
                    <P>{{$checkbox_group['title']}}</P>
                    <p style="color:red"> 必須</p>
                </td>

                @if(old($checkbox_group['key'])!=null)
                <td>
                    <select name="{{$checkbox_group['key']}}">
                        @foreach($checkbox_group['checks'] as $checkbox)
                        @if ($checkbox['item'] == old($checkbox_group['key']))
                        <option value="{{$checkbox['item']}}" selected>{{$checkbox['item']}}</option>
                        @else
                        <option value="{{$checkbox['item']}}">{{$checkbox['item']}}</option>
                        @endif
                        @endforeach
                    </select>
                </td>
                @else
                <td>
                    <select name="{{$checkbox_group['key']}}">
                        @foreach($checkbox_group['checks'] as $checkbox)
                        @if ($checkbox['item'] == $employee[$checkbox_group['key']])
                        <option value="{{$checkbox['item']}}" selected>{{$checkbox['item']}}</option>
                        @else
                        <option value="{{$checkbox['item']}}">{{$checkbox['item']}}</option>
                        @endif
                        @endforeach
                    </select>
                </td>
                @endif

                </tr>
            @endforeach
        </table>

        <table class="work-t">
            <tr><td colspan="8">契約曜日</td></tr>
            <tr><td>月</td><td>火</td><td>水</td><td>木</td><td>金</td><td>土</td><td>日</td><td>祝日</td></tr>
            <tr>
                <td><input type="text" name="working_day1" value="{{old('working_day1')}}" size="5"></td>
                <td><input type="text" name="working_day2" value="{{old('working_day2')}}" size="5"></td>
                <td><input type="text" name="working_day3" value="{{old('working_day3')}}" size="5"></td>
                <td><input type="text" name="working_day4" value="{{old('working_day4')}}" size="5"></td>
                <td><input type="text" name="working_day5" value="{{old('working_day5')}}" size="5"></td>
                <td><input type="text" name="working_day6" value="{{old('working_day6')}}" size="5"></td>
                <td><input type="text" name="working_day7" value="{{old('working_day7')}}" size="5"></td>
                <td><input type="text" name="working_day8" value="{{old('working_day8')}}" size="5"></td>
            </tr>
        </table>

        <table class="individual-t">
            @php
            $lines = [
                ['text'=>'電話番号', 'type'=>'tell', 'name'=>'tell', 'require'=> true,],
                ['text'=>'メール', 'type'=>'email', 'name'=>'email', 'require'=> true,],
                ['text'=>'生年月日', 'type'=>'date', 'name'=>'barthday', 'require'=> false,],
                ['text'=>'入社日', 'type'=>'date', 'name'=>'hire_date', 'require'=> false,],
                ['text'=>'退社日', 'type'=>'date', 'name'=>'leave_date', 'require'=> false,],
            ];
            @endphp
            @foreach ($lines as $line)
            <tr>
                <td>
                    @if($line['require'])
                    <P>{{$line['text']}}</P>
                    <p style="color:red"> 必須</p>
                    @else
                    <P>{{$line['text']}}</P>
                    @endif
                </td>
                <td>
                    <input type="{{$line['type']}}" name="{{$line['name']}}" value="{{old($line['name']) ?? $employee[$line['name']]}}">
                    <p class="ellor" style="color:red">{{implode(' ',$errors->get($line['name']))}}</p>
                </td>
            </tr>
            @endforeach
        </table>

    </div>

    @include('employee_list.parts.submit_container',['btn_text'=>'確認画面'])

</form>
@endsection


