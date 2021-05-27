<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{url('css/employee_list.css')}}">
    <title>従業員詳細</title>
</head>
<body>
    <header>
        <ul class="menu">
            <li><h2>業務アプリ</h2></li>
            <li><a class="current" href="">タイムカード</a></li>
            <li><a href="">従業員一覧</a></li>
            <li><a href="">勤怠一覧</a></li>
            <li><a href="">スケジュール</a></li>
        </ul>
        <ul class="user">
            <li class="item"><img src="{{url('image/e0001.png')}}" alt="user image"></li>
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
        <div class="main_head">
            <h2>従業員一覧</h2>
            <ul class="app_menu">
                <li><a href="{{route('employee_list')}}" class="current">閲覧画面</a></li>
                <li><a href="{{route('employee_list.admin')}}">編集画面</a></li>
            </ul>
        </div>

        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('employee_list')}}">従業員一覧</a></li>
                <li><a href="#">{{$employee->name}}さんの詳細ページ</a></li>
            </ul>
        </div>

        <div class="main_body">
            {{-- ＜メインコンテンツ＞ --}}
            <div class="contents">
                <div class="employee_container">
                    <table class="job-t">
                        <tr>
                            <td><img class="employee_img" src="../image/{{$employee->image}}" alt="{{$employee->name}}さんの画像"></td>
                            <td colspan="2">
                                <p>{{sprintf("%04d",$employee->id)}}</p>
                                <p>{{$employee->kana_name}}</p>
                                <h2>{{$employee->name}}</h2>
                            </td>
                        </tr>
                        <tr><td>役職：{{$employee->position}}</td><td>所属部署：{{$employee->department}}</td><td>性別：{{$employee->gender}}</td></tr>
                    </table>

                    <table class="work-t">
                        <tr><td colspan="8">契約曜日</td></tr>
                        <tr><td>月</td><td>火</td><td>水</td><td>木</td><td>金</td><td>土</td><td>日</td><td>祝日</td></tr>
                        <tr><td>0-00</td><td>0-00</td><td>0-00</td><td>0-00</td><td>0-00</td><td>0-00</td><td>0-00</td><td>0-00</td></tr>
                    </table>

                    <table class="individual-t">
                        {{-- <tr><td>生年月日</td><td>{{date('Y-m-d',$employee->birthday)}}</td></tr> --}}
                        <tr><td>生年月日</td><td>{{$employee->birthday}}</td></tr>
                        <tr><td>電話番号</td><td>{{$employee->tell}}</td></tr>
                        <tr><td>メール</td><td>{{$employee->email}}</td></tr>
                        {{-- <tr><td>住所</td><td>〒154-0015 東京都世田谷区桜新町1-1-1 カモメ荘101</td></tr> --}}
                        <tr><td>入社日</td><td>{{$employee->hire_date}}</td></tr>
                        <tr><td>退社日</td><td>-</td></tr>
                    </table>

                </div>

                <div class="submit_container">
                    <button onclick="history.back()">戻る</button>
                </div>
            </div>
        </div>

    </main>
    <footer><p>&copy2021 SAKAI TAKAHIRO</p></footer>
</body>

</html>
