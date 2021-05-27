<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>テスト</title>
</head>
<body>
    <h1>テストページ</h1>
    {{-- 従業員検索 --}}
    <form action="#" method="post">
        @csrf
        <div>従業員検索</div>
        <input type="text" name="keyword" value="">

        <div>所属部署 :
            <label><input type="checkbox" name="department" value="営業一課　世田谷支店">営業一課　世田谷支店</label>
            <label><input type="checkbox" name="department" value="営業一課　渋谷支店">営業一課　渋谷支店</label>
            <label><input type="checkbox" name="department" value="営業一課　新宿支店">営業一課　新宿支店</label>
        </div>

        <div>役職 :
            <label><input type="checkbox" name="position" value="係長">係長</label>
            <label><input type="checkbox" name="position" value="主任">主任</label>
            <label><input type="checkbox" name="position" value="一般社員">一般社員</label>
        </div>

        <div>性別 :
            <label><input type="checkbox" name="gender" value="男性">男性</label>
            <label><input type="checkbox" name="gender" value="女性">女性</label>
        </div>

        <button type="submit">検索</button>
    </form>
    <br>


    {{-- 従業員一覧 --}}
    <div>従業員一覧</div>
    @foreach($items as $item)
        <div>
            {{$item->id}} {{$item->name}}({{$item->kana_name}}) tel:{{$item->tell}} mail:{{$item->email}}
            <form action="{{route('test.detail')}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$item->id}}">
                <button>詳細</button>
            </form>
        </div>

    @endforeach
</body>
</html>
