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
    <a href="{{route('test.list')}}">従業員一覧</a>
    <br>
    <form action="#" method="post">
        @csrf
        <input type="text" name="post" value="">
        <button type="submit">検索</button>
    </form>
</body>
</html>
