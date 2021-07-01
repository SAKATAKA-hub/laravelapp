<p>出力条件を選択してください。</p>

<form name="seach" action="{{route('attendance_manegement.date_list_search')}}" method="POST">
    @csrf
    <ul class="op_btns">
        <li>年月：
            <select name="y_month" id="y_month" onchange="">
                <option value=""></option>
                <option value="2021-07">2021年7月</option>
                <option value="2021-08">2021年8月</option>
                <option value="2021-09">2021年9月</option>
                <option value="2021-10">2021年10月</option>
            </select>
        </li>

        <li>日付：
            <select name="date" id="date">
                <option value=""></option>
                <option value="1">1日</option>
                <option value="2">2日</option>
                <option value="3">3日</option>
                <option value="4">4日</option>
            </select>
        </li>

        <li>勤務現場：
            <select name="place" id="place">
                <option value=""></option>
                <option value="東京支店">東京支店</option>
                <option value="神奈川支店">神奈川支店</option>
                <option value="千葉支店">千葉支店</option>
                <option value="埼玉支店">埼玉支店</option>
            </select>
        </li>

        <li>従業員：
            <select name="employee" id="employee">
                <option value=""></option>
                <option value="1">山田　太郎</option>
                <option value="2">山田　次郎</option>
                <option value="3">山田　三郎</option>
                <option value="4">山田　四郎</option>
            </select>
        </li>


        <li class="serch_btn"><button class="btn-op">絞り込み</button></li>

    </ul>
</form>

<ul class="op_btns">
    <li class="other_btn"><a href="">
        <div class="btn-op">印刷</div>
    </a></li>
</ul>
