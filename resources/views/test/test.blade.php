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
    <form action="#" method="post" enctype="multipart/form-data">
        @csrf
        <input type="text" name="post" value=""><br>
        <input type="file" name="image"><br>
        <button type="submit">登録</button>
    </form>
    <br>



    <h3>従業員リストへジャンプ</h3>
    <form action="{{route('employee_list')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="input" name="keywords"><br>
        <button type="submit">移動</button>
    </form>


</body>
</html>
