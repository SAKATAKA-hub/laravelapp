@extends('employee_list.parts._base')

@section('title','/新規入力画面')

@section('breadcrumb_li')
<li><a href="{{route('employee_list.admin.insert')}}">新規入力画面</a></li>
@endsection


@section('oparation_btn')
<h2>新規入力画面</h2>
@endsection


@section('main_contents')
<form action="{{route('employee_list.admin.confirm')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="mode" value="insert">

    <div class="employee_container">
        <h3>従業員情報を入力してください。</h3>
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
            @each('employee_list.parts.table_text', $lines,'line')
            <!-- 画像入力 -->
            <tr>
                <td>従業員画像</td>
                <td>
                    <input type="file" name="image" id="myImage" accept="image/*" onchange="setImage(this);" onclick="this.value = '';" value="value="{{old('image')}}">
                    <img id="preview" class="employee_img" src="{{url('image/employees/no_image.png')}}" alt="未登録の画像の画像">
                    <p class="ellor" style="color:red">{{implode(' ',$errors->get('image'))}}</p>
                    @if ($errors->all())
                    <p class="ellor" style="color:red">画像ファイルを入れ直してください。</p>
                    @endif
                </td>
            </tr>
            <!-- セレクトボックス -->
            @each('employee_list.parts.table_select', $checkbox_groups,'checkbox_group')
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
            @each('employee_list.parts.table_text', $lines,'line')
        </table>

    </div>

    @include('employee_list.parts.submit_container',['btn_text'=>'確認画面'])

</form>
@endsection




