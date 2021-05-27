<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test\detail</title>
</head>
<body>
    <h1>詳細ページ</h1>
    @empty($item)
    <div>データがありません。</div>
    @else
    <div>{{$item->id}}</div>
    <div>{{$item->name}}</div>
    <div>{{$item->kana_name}}</div>
    <div>{{$item->tell}}</div>
    <div>{{$item->email}}</div>
    <div>{{$item->birthday}}</div>
    @endempty
</body>
</html>
