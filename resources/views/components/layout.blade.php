<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{url('css/employee_list.css')}}">
    <title>従業員一覧</title>
</head>


<body>
    <header>
        <ul class="menu">
            <li><h2>業務アプリ</h2></li>
            <li></li>
            <li><a href="" class="current">タイムカード</a></li>
            <li><a href="">従業員一覧</a></li>
            <li><a href="">勤怠一覧</a></li>
            <li><a href="">スケジュール</a></li>
        </ul>
        <ul class="user">
            <li class="item"><img src="{{url('image/employees/e0001.png')}}" alt="user image"></li>
            <li class="item">name nameさん </li>
            <li class="item dd_menu">
                <i class="material-icons">arrow_drop_down</i>
                <ul class="dd_box">
                    <li><a href="">ログアウト</a></li>
                    <li><a href="">パスワード変更</a></li>
                    <li><a href="">その他設定変更</a></li>
                </ul>
            </li>
        </ul>
    </header>


    <main>
        {{$main}}
    </main>

    <footer><p>&copy2021 SAKAI TAKAHIRO</p></footer>

    <script src="{{url('js/employee_list.js')}}"></script>


</body>
</html>
