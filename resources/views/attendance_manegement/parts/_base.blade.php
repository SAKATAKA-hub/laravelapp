<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{url('css/employee_list.css')}}"> --}}
    <link rel="stylesheet" href="{{url('css/attendance_manegement.css')}}">

    <title>{{$header_menus[$app_name]['text'].' / '.$app_menus[$app_menu_current]['text']}}@yield('titles')</title>
    {{--アプリ名--}}{{--アプリメニュー名--}}

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
                {{-- <li><a href="{{route($menu['route'])}}" class="{{$menu['current']?'current':''}}">
                {{$menu['text']}}</a></li> --}}
                @endforeach
            </ul>
        </div>

    </main>
</body>
