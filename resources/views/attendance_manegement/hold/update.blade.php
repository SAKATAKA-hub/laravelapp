<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        td{
            width: 10em;
            border: solid 1px #bbb;
        }
    </style>
</head>
<body>
    <h2>{{$data['break_id1']}}</h2>
    <h1>Update</h1>
    <table>
        <tr>
            <td>work_id :  {{$work->id}}</td>
            <td>in:{{$data['in']}}</td>
            <td>out:{{$data['out']}}</td>
            <td></td>
        </tr>
        @for ($i = 1; $i <= 4; $i++)
        <tr>
            <td>break_id :{{$data['break_id'.$i]}}</td>
            <td>break_in{{$i}}:{{$data['break_in'.$i]}}</td>
            <td>break_out{{$i}}:{{$data['break_out'.$i]}}</td>
            <td>break_delete{{$i}}:{{isset($data['break_delete'.$i])? 'true': 'false'}}</td>
        </tr>
        @endfor
        <tr>
            <td></td>
            <td>RestrainTime:{{$data['RestrainTime']}}</td>
            <td>BreakTime:{{$data['BreakTime']}}</td>
            <td>WorkingTime:{{$data['WorkingTime']}}</td>
        </tr>


    </table>

</body>
</html>
