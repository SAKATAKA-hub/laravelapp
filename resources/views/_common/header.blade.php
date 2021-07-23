<header>
    <ul class="menu">
        {{-- ページロゴ --}}
        <li>
            <a href="{{route('/')}}">
                <h2>業務アプリ</h2>
            </a>
        </li>

        {{-- タイムカード --}}
        <li>
            @php list($input, $place, $employee) =['no_input','no_place','6']; @endphp
            <a href="{{route('time_card.index',compact('input','place','employee') )}}">
                タイムカード
            </a>
        </li>

        {{-- その他アプリ --}}
        <?php $header_menus[$app_name]['current'] = true; ?> <!--$app_name:composerより -->
        @foreach($header_menus as $menu)
        <li>
            <a href="{{route($menu['route'])}}" class="{{$menu['current']?'current':''}}">
            {{$menu['text']}}</a>
        </li>
        @endforeach
    </ul>

    {{-- ユーザー情報 --}}
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
{{--

--}}
