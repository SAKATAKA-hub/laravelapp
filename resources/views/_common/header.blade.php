
<ul class="menu">
    <li><h2>業務アプリ</h2></li>
    <?php $header_menus[$app_name]['current'] = true; ?> <!--$app_name:composerより -->
    @foreach($header_menus as $key => $menu)
    <li><a href="{{route($menu['route'])}}" class="{{$menu['current']?'current':''}}">
    {{$menu['text']}}</a></li>
    @endforeach
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
