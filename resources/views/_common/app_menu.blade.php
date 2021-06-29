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
