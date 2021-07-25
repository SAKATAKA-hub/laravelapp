<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>日別勤怠一覧</title>
</head>
<body>
    <a href="">日別勤怠一覧</a>
    <a href="">月別勤怠一覧</a>
    <a href="">個人別勤怠一覧</a>

    <div class="select_change_container" style="display:flex;">
        <form action="">
            <label>年月変更
                <input type="text" name="month" size="4">
                <input type="hidden" name ="day">
                <input type="hidden" name ="employee">
                <select name="">
                    <option value="">選択</option>
                </select>
            </label>
        </form>
        <form action="">
            <label>　日付変更
                <input type="text" name="month" size="4">
                <input type="hidden" name ="day">
                <input type="hidden" name ="employee">
                <select name="">
                    <option value="">選択</option>
                </select>
            </label>
        </form>
        <form action="">
            <label>　従業員変更
                <input type="text" name="month" size="4">
                <input type="hidden" name ="day">
                <input type="hidden" name ="employee">
                <select name="">
                    <option value="">選択</option>
                </select>
            </label>
        </form>
    </div>

    <div class="befor_after_change_container" style="display: flex;">
        <form action="">
            <label>
                <input type="hidden" name="month">
                <input type="hidden" name ="day">
                <input type="hidden" name ="employee">
                <button>前月</button>
            </label>
        </form>
        <form action="">
            <label>
                <input type="hidden" name="month">
                <input type="hidden" name ="day">
                <input type="hidden" name ="employee">
                <button>前日</button>
            </label>
        </form>
        <form action="">
            <label>
                <input type="hidden" name="month">
                <input type="hidden" name ="day">
                <input type="hidden" name ="employee">
                <button>翌日</button>
            </label>
        </form>
        <form action="">
            <label>
                <input type="hidden" name="month">
                <input type="hidden" name ="day">
                <input type="hidden" name ="employee">
                <button>翌月</button>
            </label>
        </form>
    </div>


    <div>{{$month}}</div>
    <div>{{$day}}</div>
    <div>{{$employee}}</div>

</body>
</html>
