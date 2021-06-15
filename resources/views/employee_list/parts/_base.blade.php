<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{url('css/employee_list.css')}}">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous"> --}}

    <title>
        {{$header_menus[$app_name]['text']}} / {{--アプリ名--}}
        {{$app_menus[$app_menu_current]['current']}}　{{--アプリメニュー名--}}
        @yield('titles')
    </title>

</head>


<body>
    <header>
        @include('_common.header')
    </header>

    <main>
        {{--appメニュー--}}
        <div class="main_head">
            <h2>{{$header_menus[$app_name]['text']}}</h2>{{--app名--}}
            <ul class="app_menu">
                <?php $app_menus[$app_menu_current]['current'] = true; ?>{{--選択中メニュー--}}
                @foreach($app_menus as $menu)
                <li><a href="{{route($menu['route'])}}" class="{{$menu['current']?'current':''}}">
                {{$menu['text']}}</a></li>
                @endforeach
            </ul>
        </div>

        {{-- パンクズリスト --}}
        <div class="breadcrumb">
            <ul>
                <li>{{$header_menus[$app_name]['text']}}</li>
                <li><a href="{{route($app_menus[$app_menu_current]['route'])}}">{{$app_menus[$app_menu_current]['text']}}</a></li>
                @yield('breadcrumb_li')
            </ul>
        </div>

        <div class="main_body">
            {{-- oparation_btn --}}
            <div class="oparation_btn_container">
            @yield('oparation_btn')
            </div>

            {{-- main_contents --}}
            <div class="contents">
                @yield('main_contents')
            </div>

        </div>

    </main>

    @include('_common.footer')

    <script src="{{url('js/employee_list.js')}}"></script>
    <script src="{{url('js/img_file.js')}}"></script>

</body>
</html>
