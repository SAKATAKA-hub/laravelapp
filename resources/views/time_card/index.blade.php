<body>
    <h1>TimeCard</h1>

    {{-- 従業員の変更 --}}
    <form class="changeForm" method="POST" action="{{route('time_card.change_employee')}}">
        @csrf
        <div class="input_change_container">
            <p>従業員　変更:
                <select name="employee" style="background : skyblue;">
                    <option value="6" {{$employee=="6"? 'selected':''}}>従業員6</option>
                    <option value="7" {{$employee=="7"? 'selected':''}}>従業員7</option>
                    <option value="8" {{$employee=="8"? 'selected':''}}>従業員8</option>
                    <option value="9" {{$employee=="9"? 'selected':''}}>従業員9</option>
                </select>
            </p>
        </div>
    </form>

    {{-- 出勤現場の変更 --}}
    <form class="changeForm" method="POST" action="{{route('time_card.change_place')}}">
        @csrf
        <input type="hidden" name="employee" value="{{$employee}}">
        <div class="input_change_container">
            <p>出勤現場　変更:
                <select name="place" style="background : skyblue;">
                    <option value="東京支店" {{$place=="東京支店"? 'selected':''}}>東京支店</option>
                    <option value="神奈川支店" {{$place=="神奈川支店"? 'selected':''}}>神奈川支店</option>
                    <option value="千葉支店" {{$place=="千葉支店"? 'selected':''}}>千葉支店</option>
                </select>
            </p>
        </div>
    </form>


    <h2>work status: {{$work_status}}</h2>
    <p>work place: {{$place}}</p>
    <p>employee id: {{sprintf('%04d',$employee)}}</p>
    <p>work id: {{$work !='NoWork'? $work->id: 'no work id' }}</p>
    {{-- <p>break id: {{$work_break !='NoBreak'? $work_break->id: 'no break id'}}</p> --}}

    <div class="input_work_container" style="display: flex;">
        <form action="{{route('time_card.work_in',compact('place','employee') )}}" method="POST">
            @csrf <button>勤務開始</button>
        </form>
        <form action="{{route('time_card.work_break_in',compact('place','employee','work') )}}" method="POST">
            @method('PATCH') @csrf <button>休憩開始</button>
        </form>
        <form action="{{route('time_card.work_break_out',compact('place','employee','work') )}}" method="POST">
            @method('PATCH') @csrf <button>休憩終了</button>
        </form>

        <form action="{{route('time_card.work_out',compact('place','employee','work') )}}" method="POST">
            @method('PATCH') @csrf <button>勤務終了</button>
        </form>
    </div>

    <script>
        "use strict";

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

    </script>
</body>
