<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>テスト</title>
</head>
<body>
    <h2>フォームページ</h2>
    <form method="GET" action="#">
        @csrf
        <p>{{$msg}}</p>
        <input type="text" name="msg">
        <input type="submit">
    </form>
</body>
</html>