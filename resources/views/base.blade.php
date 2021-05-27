<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/base.css">
    <title>@yield('title')</title>
</head>


<body>
    <header>
        <ul>
            <li><h2>業務アプリ</h2></li>
            @foreach($header_menus as $h_menu)
            <li><a class="{{$app_name == $h_menu['url'] ? 'current' : ''}}" href="{{$h_menu['url']}}">
                {{$h_menu['title']}}
            </a></li>
            @endforeach
        </ul>
        <ul>
            <li><img src="image/employees/men1.png" alt="user image"></li>
            <li class="user_name">name nameさん </li>
            <li>logout</li>
        </ul>
    </header>


    <main>
        <div class="main_head">
            <div class="center_container">
                <h2>@yield('title')</h2>
                <ul>
                    @foreach($app_menus as $app_menu)
                    <li><a class="" href="{{$app_menu['url']}}">
                        {{$app_menu['title']}}
                    </a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="breadcrumb">
            <div class="center_container">
                <ul>
                    <li><a href="@yield('rute')">@yield('title')</a></li>
                    @yield('breadcrumb')
                </ul>
            </div>
        </div>

        

        <div class="main_body center_container">            
            <div class="operation_btn">
                @yield('operation_btn')
            </div>

            <div class="contents">
                @yield('contents')
            </div>
        </div>

    </main>
    <footer><p>&copy2021 SAKAI TAKAHIRO</p></footer>
</body>
</html>