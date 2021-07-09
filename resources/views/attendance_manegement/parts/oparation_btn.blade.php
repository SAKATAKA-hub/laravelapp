@switch($app_menu_current)
    @case('date_list'||'admin')

    @if ($app_menu_current == 'date_list')
    <form name="seach" action="{{route('attendance_manegement.date_list_search')}}" method="POST">
    @elseif($app_menu_current == 'admin')
    <form name="seach" action="{{route('attendance_manegement.admin_search')}}" method="POST">
    @endif
        @csrf
        <p>出力条件を選択してください。</p>
        <ul class="op_btns">
            <li>年月：
                <select name="y_month" id="select_Y_m" onchange="changeSelectDate()">
                    @foreach ($select_items['y_month'] as $item)
                    @if ($item['selected'])
                    <option value="{{$item['value']}}" selected>{{$item['text']}}</option>
                    @else
                    <option value="{{$item['value']}}">{{$item['text']}}</option>
                    @endif
                    @endforeach
                </select>
            </li>

            <li>日付：
                <select name="date" id="select_d">
                    @foreach ($select_items['date'] as $item)
                    @if ($item['selected'])
                    <option value="{{$item['value']}}" selected>{{$item['text']}}</option>
                    @else
                    <option value="{{$item['value']}}">{{$item['text']}}</option>
                    @endif
                    @endforeach
                </select>
            </li>

            <li>勤務現場：
                <select name="place" id="place">
                    <option value="">全て</option>
                    @foreach ($select_items['place'] as $item)
                    @if ( !empty($input) && ($input['place'] == $item['item']) )
                    <option value="{{$item['item']}}" selected>{{$item['item']}}</option>
                    @else
                    <option value="{{$item['item']}}">{{$item['item']}}</option>
                    @endif
                    @endforeach
                </select>
            </li>

            <li class="serch_btn"><button class="btn-op">検索</button></li>

        </ul>
    </form>
    @if( $app_menu_current != 'admin')
    <ul class="op_btns">
        <li class="other_btn">
            <form action="{{route('attendance_manegement.print_date_list')}}" method="POST">
                @csrf
                <input type="hidden" name="Ymd" value="{{$Ymd}}">
                <button class="btn-op">印刷</button>
            </form>
        </li>
    </ul>
    @endif
    @break


    @case('month_list')
    <form name="seach" action="{{route('attendance_manegement.month_list_search')}}" method="POST">
        @csrf
        <p>出力条件を選択してください。</p>
        <ul class="op_btns">
            <li>年月：
                <select name="y_month"  onchange="">
                    @foreach ($select_items['y_month'] as $item)
                    @if ($item['selected'])
                    <option value="{{$item['value']}}" selected>{{$item['text']}}</option>
                    @else
                    <option value="{{$item['value']}}">{{$item['text']}}</option>
                    @endif
                    @endforeach
                </select>
            </li>

            <li>勤務現場：
                <select name="place" >
                    <option value="">全て</option>
                    @foreach ($select_items['place'] as $item)
                    @if ( !empty($input) && ($input['place'] == $item['item']) )
                    <option value="{{$item['item']}}" selected>{{$item['item']}}</option>
                    @else
                    <option value="{{$item['item']}}">{{$item['item']}}</option>
                    @endif
                    @endforeach
                </select>
            </li>

            <li class="serch_btn"><button class="btn-op">検索</button></li>

        </ul>
    </form>

    <ul class="op_btns">
        <li class="other_btn">
            <form action="{{route('attendance_manegement.print_month_list')}}" method="POST">
                @csrf
                <input type="hidden" name="Ymd" value="{{$Ymd}}">
                <button class="btn-op">印刷</button>
            </form>
        </li>
    </ul>
    @break


    @case('person_list')
    <form name="seach" action="{{route('attendance_manegement.person_list_search')}}" method="POST">
        @csrf
        <p>出力条件を選択してください。</p>
        <ul class="op_btns">
            <li>従業員：
                <select name="employee_id" id="employee">
                    <option value="">選択してください</option>
                    @foreach ($select_items['employee'] as $item)
                    @if ( !empty($employee_id) && ($employee_id == $item['id']) )
                    <option value="{{$item['id']}}" selected>{{ sprintf('%04d:%s', $item['id'], $item['name']) }}</option>
                    @else
                    <option value="{{$item['id']}}">{{ sprintf('%04d:%s', $item['id'], $item['name']) }}</option>
                    @endif
                    @endforeach
                </select>
            </li>

            <li>年月：
                <select name="y_month" id="y_month" onchange="">
                    @foreach ($select_items['y_month'] as $item)
                    @if ($item['selected'])
                    <option value="{{$item['value']}}" selected>{{$item['text']}}</option>
                    @else
                    <option value="{{$item['value']}}">{{$item['text']}}</option>
                    @endif
                    @endforeach
                </select>
            </li>

            <li class="serch_btn"><button class="btn-op">検索</button></li>

        </ul>
    </form>
    <ul class="op_btns">
        <li class="other_btn">
            <form action="{{route('attendance_manegement.print_person_list')}}" method="POST">
                @csrf
                <input type="hidden" name="Ymd" value="{{$Ymd}}">
                <input type="hidden" name="employee_id" value="{{$employee_id}}">
                <button class="btn-op">印刷</button>
            </form>
        </li>
    </ul>

    @break
    @default

@endswitch

