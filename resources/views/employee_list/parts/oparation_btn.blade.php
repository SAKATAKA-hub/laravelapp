<p class="filtering_key">絞り込み条件：{{$seach_text}}</p>

<form name="seach" action="#" method="POST">
    @csrf
    <ul class="op_btns">
        {{-- 検索ボックス --}}
        <li><input type="text" name="keywords" placeholder="キーワード　例）氏名・ふりがな" size="30"></li>

        {{-- チェックボックス --}}
        @foreach($checkbox_groups as $check_key => $checkbox_group)
        <li class="dd_menu">
            <div class="btn-op refined">{{$checkbox_group['title']}}</div>
            <ul class="dd_box">
                {{-- □全て選択チェックボックス --}}
                <li><label>
                    <input type="checkbox" name="{{$checkbox_group['all']['name']}}" value="true" onClick="ALLChecked(this)" checked>
                    {{$checkbox_group['all']['item']}}
                </label></li>

                {{-- その他選択チェックボックス --}}
                @foreach($checkbox_group['checks'] as $key => $checkbox)
                <li><label>
                    <input type="checkbox" name="{{$checkbox['name']}}" value="{{$checkbox['item']}}" onClick="DisCheck(this)" checked>
                    {{$checkbox['item']}}
                </label></li>
                @endforeach
            </ul>
        </li>
        @endforeach


        {{-- 検索ボタン --}}
        <li class="serch_btn"><button type="submit" class="btn-op">絞り込み</button></li>

        <li class="insert">
            <a class="btn-op" href="{{route('employee_list.admin.insert')}}" style="{{$insert_btn}}">新規作成</a>
        </li>

    </ul>
</form>

