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
                <li><a href="">従業員一覧</a></li>
                <li><a href="">○○さんの詳細ページ</a></li>
                <li><a href="">編集画面</a></li>
                <li><a href="">○○さんの編集ページ</a></li>
            </ul>
        </div>

        <div class="main_body">
            <div class="oparation_btn_container">
                <p class="filtering_key">絞り込み条件：</p>

                <form action="#" method="POST">
                    @csrf
                    <ul class="op_btns">
                        <li><input type="text" name="keywords" value="{{$seach_woord}}"></li>

                        <li class="dd_menu">
                            <button class="btn-op refined">所属部署絞り込み</button>
                            <ul class="dd_box">
                                <li><button>全て</button></li>
                                @foreach($check_departments as $check_department)
                                <li><label><input type="checkbox" name="departments[]" value="{{$check_department->item}}" checked>{{$check_department->item}}</label></li>
                                @endforeach
                            </ul>
                        </li>

                        <li class="dd_menu">
                            <button  class="btn-op refined">役職絞り込み</button>
                            <ul class="dd_box">
                                <li><button>全て</button></li>
                                @foreach($check_positions as $check_position)
                                <li><label><input type="checkbox" name="positions[]" value="{{$check_position->item}}" checked>{{$check_position->item}}</label></li>
                                @endforeach
                            </ul>
                        </li>

                        <li class="dd_menu">
                            <button  class="btn-op refined">性別絞り込み</button>
                            <ul class="dd_box">
                                <li><button>全て</button></li>
                                @foreach($check_genders as $check_gender)
                                <li><label><input type="checkbox" name="genders[]" value="{{$check_gender->item}}" checked>{{$check_gender->item}}</label></li>
                                @endforeach
                            </ul>
                        </li>


                        <li class="serch_btn"><button type="submit" class="btn-op">絞り込み</button></li>

                    </ul>
                </form>
            </div>

            {{-- ＜メインコンテンツ＞ --}}
            <div class="contents">
                <table class="all_list">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td></td> <!-- image -->
                            <td class="long">氏名</td>
                            <td class="long">ふりがな</td>
                            <td class="long">役職</td>
                            <td class="long">所属部署</td>
                            <td class="long"></td> <!-- button -->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                        <tr>
                            <td>{{sprintf("%04d",$employee->id)}}</td>
                            <td><img class="employee_img" src="image/{{$employee->image}}" alt="{{$employee->name}}さんの画像"></td>
                            <td>{{$employee->name}}</td>
                            <td>{{$employee->kana_name}}</td>
                            <td>{{$employee->position}}</td>
                            <td>{{$employee->department}}</td>
                            <td>
                                <form action="{{route('employee_list.detail')}}" method="post">
                                    @csrf
                                    <input type="hidden" value="{{$employee->id}}" name="id">
                                    <button type="submit" class="btn-1">詳細</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7">検索内容に一致する情報がありません</td></tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

        </div>

    </main>
    <footer><p>&copy2021 SAKAI TAKAHIRO</p></footer>
</body>
</html>
