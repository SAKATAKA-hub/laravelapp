<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>タイムカード</title>
  <link rel="stylesheet" href="{{url('css/time_card.css')}}">
</head>
<body>
  <main class="{{$work_status}}">
    <h2>タイムカード</h2>

    <!--現在時刻の表示領域-->
    <div id="showTime">
      <div id="nowDay"></div>
      <div id="nowTime"></div>
    </div>

    <!--ユーザー情報-->
    <div class="userInfo">
    <!-- <div class="userInfo outWork"> -->
      <div class="top">
        <p id="userId">{{sprintf('%04d',$employee->id)}}</p>
        <p id="userName">{{$employee->name}}</p>
        <img id="userImg" src="{{url('image/employees/'.$employee->image)}}" alt="user image">
        <p>出勤現場：{{$place}}</p>

      </div>
      <div class="bottom">
        <p class="workState">退勤中</p>
      </div>
    </div>


    <p>work id: {{$work !='NoWork'? $work->id: 'no work id' }}</p>


    <!--従業員等変更入力-->
    <div class ="input_change">
        {{-- 従業員の変更 --}}
        <form class="changeForm" method="POST" action="{{route('time_card.change_employee')}}">
            @csrf
            <select name="employee" >
                <option value="{{$employee->id}}">従業員変更</option>
                @foreach ($select_employees as $select_e)
                <option value="{{$select_e->id}}">{{sprintf('%04d',$select_e->id).':'.$select_e->name}}</option>
                @endforeach
            </select>
        </form>

        {{-- 出勤現場の変更 --}}
        <form class="changeForm" method="POST" action="{{route('time_card.change_place')}}">
            @csrf
            <input type="hidden" name="employee_id" value="{{$employee->id}}">
            <select name="place">
                <option value="$place">出勤現場変更</option>
                @foreach ($select_places as $select_p)
                <option value="{{$select_p->item}}">{{$select_p->item}}</option>
                @endforeach
            </select>
        </form>



    </div>

    <!--出退勤入力ボタン-->
    <div class ="input_work">
        <!--勤務開始ボタン-->
        <form action="{{route('time_card.work_in',compact('place','employee') )}}" method="POST">
            @csrf <button id="workIn">勤務開始</button>
        </form>

        <!--勤務終了ボタン-->
        <form action="{{route('time_card.work_out',compact('place','employee','work') )}}" method="POST">
            @method('PATCH') @csrf <button id="workOut">勤務終了</button>
        </form>

        <!--休憩開始ボタン-->
        <form action="{{route('time_card.work_break_in',compact('place','employee','work') )}}" method="POST">
            @method('PATCH') @csrf <button id="breakIn">休憩開始</button>
        </form>

        <!--休憩終了ボタン-->
        <form action="{{route('time_card.work_break_out',compact('place','employee','work') )}}" method="POST">
            @method('PATCH') @csrf <button id="breakOut">休憩終了</button>
        </form>



    </div>

    <button class="close_btn" onClick="window.close(); return false;">閉じる</button>

  </main>

  @include('_common.footer')

  <script>

    'use strict';

    //アラート表示
    window.onload =()=>{
        const message = "{{$message}}";
        if(message){ alert(message);}
    }

    //入力対象変更後にsubmitする
    document.querySelectorAll('.changeForm').forEach(form => {
        const select = form.querySelector('select');
        select.onchange = ()=>{
            form.submit();
        };
    });

    // 時間の表示
    function showTime()
    {
        const now = new Date();
        const nowYear = now.getFullYear();
        const nowMonth = String(now.getMonth()+1).padStart(2,'0');
        const nowDate = String(now.getDate()).padStart(2,'0');
        const nowHour = String(now.getHours()).padStart(2,'0');
        const nowMin = String(now.getMinutes()).padStart(2,'0');
        const nowSec = String(now.getSeconds()).padStart(2,'0');
        const dayNum = String(now.getUTCDay());

        const DayArry =["(日)","(月)","(火)","(水)","(木)","(金)","(土)"];

        let ampm = "";
        if(nowHour<12){ampm = "AM";}
        else{ampm = "PM";}

        const outputDay = `${nowYear}年${nowMonth}月${nowDate}日${DayArry[dayNum]}`;
        const outputTime = `${ampm} ${nowHour % 12}:${nowMin}:${nowSec}`;

        document.getElementById('nowDay').textContent = outputDay;
        document.getElementById('nowTime').textContent = outputTime;
        refresh();
    }
    function refresh(){setTimeout(showTime,1000);}

    showTime();


    // テスト用コード
    const inputBtns = [
        {
            'element' : document.getElementById('workIn'),
            'workStatus' : 'in',
        },{
            'element' : document.getElementById('breakIn'),
            'workStatus' : 'break',
        },{
            'element' : document.getElementById('breakOut'),
            'workStatus' : 'in',
        },{
            'element' : document.getElementById('workOut'),
            'workStatus' : 'out',
        },
    ];

    const mainElement = document.querySelector('main');

    // inputBtns.forEach(btn=>{
    //     btn.element.onclick = e =>{
    //         e.preventDefault();

    //         mainElement.className =btn.workStatus;

    //         console.log(mainElement.className);
    //     };
    // });




  </script>
</body>
