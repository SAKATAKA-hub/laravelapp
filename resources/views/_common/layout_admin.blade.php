<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{url($app_style)}}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <title>
        {{$header_menus[$app_name]['text'].
        ' / '.$app_menus[$app_menu_current]['text']}}
        @yield('title')
    </title>

</head>

<body class='admin'>
    @include('_common.header')
    <main>
        @include('_common.app_menu')

        <div class="main_body">
            {{-- パンクズリスト --}}
            <ul class="breadcrumb">
                <li>{{$header_menus[$app_name]['text']}}</li>
                <li><a href="{{route($app_menus[$app_menu_current]['route'])}}">{{$app_menus[$app_menu_current]['text']}}</a></li>
                @yield('breadcrumb_li')
            </ul>

            {{-- 小見出し --}}
            <h3>@yield('subheading')</h3>

            {{-- 操作ボタン --}}
            <div class="oparation_btn_container">
            @yield('oparation_btn')
            </div>

            {{-- メインコンテンツ --}}
            <div class="contents">
                @yield('main_contents')
            </div>

        </div>
    </main>
    @include('_common.footer')
    @include('employees_manegement.parts.js')


</body>
