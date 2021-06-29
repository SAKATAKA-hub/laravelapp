@if($app_menu_current == 'index')
<form name="seach" action="{{route('employees_manegement.index')}}" method="POST">
@else
<form name="seach" action="{{route('employees_manegement.admin')}}" method="POST">
@endif
    @csrf
    <p class="filtering_key">絞り込み条件：{{$seach_text_all}}</p>
    <ul class="op_btns">
        {{-- 検索ボックス --}}
        @if($seach_text)
        <li><input type="text" name="keywords" value="{{$seach_text}}" size="30"></li>
        @else
        <li><input type="text" name="keywords" placeholder="キーワード　例）氏名・ふりがな" size="30"></li>
        @endif

        {{-- チェックボックス --}}
        @foreach($checkbox_groups as $check_key => $checkbox_group)
        <li class="dd_menu">
            <div class="btn-op refined">{{$checkbox_group['title']}}</div>
            <ul class="dd_box">
                {{-- □全て選択チェックボックス --}}
                <li><label>
                    {{-- <input type="hidden" name="{{$checkbox_group['all']['name']}}" value="no_checked"> --}}
                    <input type="checkbox" name="{{$checkbox_group['all']['name']}}" value="true" onClick="ALLChecked(this)"
                    {{$checkbox_group['all']['checked'] ? 'checked' :''}} >

                    {{$checkbox_group['all']['item']}}
                </label></li>

                {{-- その他選択チェックボックス --}}
                @foreach($checkbox_group['checks'] as $key => $checkbox)
                <li><label>
                    <input type="checkbox" name="{{$checkbox['name']}}" value="{{$checkbox['item']}}" onClick="DisCheck(this)"
                    {{$checkbox['checked'] ? 'checked' :''}} >

                    {{$checkbox['item']}}
                </label></li>
                @endforeach
            </ul>
        </li>
        @endforeach


        {{-- 検索ボタン --}}
        <li class="serch_btn"><button type="submit" class="btn-op">絞り込み</button></li>

    </ul>
</form>

{{-- ボタン --}}
@if($app_menu_current == 'admin')
<ul class="op_btns">
    <li class="other_btn"><div class="btn-op">
        <a href="{{route('employees_manegement.create')}}">新規作成</a>
    </div></li>
</ul>

@endif
