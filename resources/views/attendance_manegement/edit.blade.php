@extends('_common.layout_admin')

{{-- ページタイトル --}}
@section('title','')

{{-- パンクズリスト --}}
@section('breadcrumb_li')
@endsection

{{-- 小見出し --}}
@section('subheading',$app_menus[$app_menu_current]['text'])

{{-- 操作ボタン --}}
@section('oparation_btn')
@endsection

{{-- メインコンテンツ --}}
@section('main_contents')
<div class="edit">
    <div class="precautions">
        <h4>入力上の注意</h4>
        <ul>
            <li>時間の入力は"半角数字"を用いて"0000"の形で入力してください。</li>
            <li>勤務時間、休憩時間、労働時間の計算は、15分刻みに計算されます。</li>
        </ul>
        <div id="error" >エラーコメント</div>
    </div>

    <form method="POST" action="{{route('attendance_manegement.update',$work)}}">
        @method('PATCH')
        @csrf

        <table>
            {{-- 従業員情報 --}}
            <tr>
                <td colspan="5">
                    <h4>
                        <div class="pason_item">
                            <img class="employee_img" src="{{url('image/employees/'.$work->employee->image)}}" alt="user image">
                            <p class="id">{{sprintf('%04d',$work->employee_id)}}</p>
                            <p class="name">{{$work->employee->name}}</p>
                        </div>
                        <p>{{$date}}</p>
                    </h4>
                </td>
            </tr>
            {{-- 出勤現場 --}}
            <tr>
                <td class="title">出勤現場</td>
                <td>
                    <select name="place">
                        @foreach ($places as $place)
                        @if ($place->item == $work->place)
                        <option value="{{$place->item}}" selected="selected">{{$place->item}}</option>
                        @else
                        <option value="{{$place->item}}">{{$place->item}}</option>
                        @endif
                        @endforeach
                    </select>
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            {{-- 出退勤時間 --}}
            <tr>
                <td class="td_size1 title">出勤時間</td>
                <td class="td_size1">IN
                    <input type="text" name="in" value="{{gmdate('Hi',$work->in)}}" size="3">
                </td>
                <td class="td_size1">OUT
                    <input type="text" name="out" value="{{gmdate('Hi',$work->out)}}" size="3">
                </td>
                <td class="td_size1"></td>
                <td class="td_size1"></td>
            </tr>

            {{-- 休憩時間 --}}
            @foreach ($work->work_breaks as $break)
            <input type="hidden" name="break_id{{$loop->iteration}}" value="{{$break->id}}">
            <tr class="breaks">
                @if ($loop->first)
                <td class="title" rowspan="4">休憩時間</td>
                @endif
                <td>IN
                    <input type="text" name="break_in{{$loop->iteration}}" class="breakIn" value="{{gmdate('Hi',$break->in)}}" size="3">
                </td>
                <td>OUT
                    <input type="text" name="break_out{{$loop->iteration}}" class="breakOut" value="{{gmdate('Hi',$break->out)}}" size="3">
                </td>
                <td class="breakTime">時間</td>
                <td>
                    <label>
                        <input type="checkbox" name="break_delete{{$loop->iteration}}">
                        <p class="btn-1 brakeDelete">休憩削除</p>
                    </label>
                </td>
            </tr>
            @php $n = $loop->iteration; @endphp
            @endforeach

            {{-- 未入力の休憩時間 --}}
            @php  $n = isset($n)? $n: 0;   @endphp
            @for ($i = $n+1; $i <= 4; $i++)
            <input type="hidden" name="break_id{{$i}}" value="">
            <tr class="breaks delete">
                @if ($i==1)
                <td class="title" rowspan="4">休憩時間</td>
                @endif
                <td>IN
                    <input type="text" name="break_in{{$i}}" class="breakIn" size="3">
                </td>
                <td>OUT
                    <input type="text" name="break_out{{$i}}" class="breakOut" size="3">
                </td>
                <td class="td_size1 breakTime">時間</td>
                <td>
                    <label>
                        <input type="checkbox" name="break_delete{{$i}}" checked="checked">
                        <p class="btn-1 brakeDelete">休憩入力</p>
                    </label>
                </td>
            </tr>
            @endfor

            <tr class="total">
                <td class="title">合計</td>
                <td id="restrainTime">勤務時間{{gmdate('H:i',$work->RestrainTime)}}</td>
                <td id="breakTime">休憩時間{{gmdate('H:i',$work->BreakTime)}}</td>
                <td id="workingTime">労働時間{{gmdate('H:i',$work->WorkingTime)}}</td>
                <td　class="td_size1"></td>
            </tr>

        </table>
        <div class="submit_container">
            <button class="col_btn">修正確定</button>
        </div>

    </form>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/sprintf/1.1.2/sprintf.min.js"></script>
    {{-- <script src="{{url('js/attendance_manegement_edit.js')}}"></script> --}}
    <script>
        "use strict";

        //労働時間等を計算する関数
        function calcWorkTime()
        {
            const inElement = document.querySelector('input[name="in"]');
            const outElement = document.querySelector('input[name="out"]');

            const restrainElement = document.getElementById('restrainTime');
            const breakElement = document.getElementById('breakTime');
            const workingElement = document.getElementById('workingTime');

            const cutMin = 15; //cutMin分刻みに時間を計算

            let restrainTime = 0; //勤務時間
            let breakTime = 0; //休憩時間
            let workingTime = 0; //労働時間
            let calcTime = 0;

            // const inputVal = [
            //         input.value.substring(0,2),
            //         input.value.substring(2,4),
            //     ];

            // 勤務時間(restrainTime)の計算
            let outTime = [
                outElement.value.substring(0,2),
                outElement.value.substring(2,4),
            ];
            outTime = parseInt(outTime[0],10)*60 + parseInt(outTime[1],10);
            outTime = Math.floor(outTime/cutMin)*cutMin;

            let inTime = [
                inElement.value.substring(0,2),
                inElement.value.substring(2,4),
            ];
            inTime = parseInt(inTime[0],10)*60 + parseInt(inTime[1],10);
            inTime = Math.ceil(inTime/cutMin)*cutMin;

            restrainTime = outTime - inTime;
            calcTime = [ Math.floor(restrainTime/60), restrainTime%60 ];
            calcTime = sprintf('勤務時間%02d:%02d', calcTime[0], calcTime[1]);
            restrainElement.textContent = restrainTime >= 0? calcTime: '勤務時間--:--';


            // 休憩時間(breakTime)の計算
            document.querySelectorAll('.breaks').forEach( (breakElement,x) => {
                const breakOutElement = breakElement.querySelector('.breakOut');
                const breakInElement = breakElement.querySelector('.breakIn');
                const totalElement = breakElement.querySelector('.breakTime');
                const check = breakElement.querySelector('input[type="checkbox"]');

                //削除されている休憩はスキップ
                if(!check.checked)
                {
                    let outTime = [
                        breakOutElement.value.substring(0,2),
                        breakOutElement.value.substring(2,4),
                    ];
                    outTime = parseInt(outTime[0],10)*60 + parseInt(outTime[1],10);

                    let inTime = [
                        breakInElement.value.substring(0,2),
                        breakInElement.value.substring(2,4),
                    ];
                    inTime = parseInt(inTime[0],10)*60 + parseInt(inTime[1],10);

                    let totalTime = Math.ceil( (outTime - inTime)/cutMin )*cutMin;
                    breakTime += totalTime > 0? totalTime: 0;

                    calcTime = [ Math.floor(totalTime/60), totalTime%60 ];
                    calcTime = sprintf('休憩時間%02d:%02d', calcTime[0], calcTime[1]);
                    totalElement.textContent = totalTime >= 0? calcTime: '休憩時間--:--';
                }


            });
            calcTime = [ Math.floor(breakTime/60), breakTime%60 ];
            calcTime = sprintf('休憩時間%02d:%02d', calcTime[0], calcTime[1]);
            breakElement.textContent = breakTime >= 0? calcTime: '休憩時間--:--';


            // 労働時間(workingTime)の計算
            workingTime = restrainTime - breakTime;
            calcTime = [ Math.floor(workingTime/60), workingTime%60 ];
            calcTime = sprintf('労働時間%02d:%02d', calcTime[0], calcTime[1]);
            workingElement.textContent = workingTime >= 0? calcTime: '労働時間--:--';

        }



        //入力値のバリデーション
        const inElement = document.querySelector('input[name="in"]');
        const outElement = document.querySelector('input[name="out"]');

        const inputs = document.querySelectorAll('input[type="text"]');
        inputs.forEach( input => {

            input.addEventListener('change', (e) =>{

                console.log('input:'+input.value);
                const inputVal = [
                    input.value.substring(0,2),
                    input.value.substring(2,4),
                ];
                const cutMinut = 15;

                //エラー処理の関数
                function errorFunc(error,input,text)
                {
                    console.log('input NG!');
                    error.textContent = text;
                    input.value = '';
                    input.classList.add('error');
                    return;
                }

                //入力内容のバリデーション
                //1.時間の型かチェック
                const error = document.getElementById('error');
                if( !input.value.match(/^(\d{2}\d{2})$|^()$/) ) //'00:00型'と'空白'
                {
                    errorFunc(error,input,'エラー：時間の入力は"半角数字4ケタ"で入力してください。');
                }
                else if(input.value==='')
                {
                    calcWorkTime();
                    return;
                }
                //2.時間が0～24の間で入力されているかチェック
                else if(input.value > 2400)
                // else if(parseInt(inputVal[0],10) > 24)
                {
                    errorFunc(error,input,'エラー：24:00以内の時間で入力してください。');
                }
                //3.分が0～60の間で入力されているかチェック
                else if(parseInt(inputVal[1],10) > 60)
                {
                    errorFunc(error,input,'エラー：分は"0～60"の数字で入力してください。');
                }
                //4.出勤入力のチェック
                else if((input === inElement)&&(input.value > outElement.value)&&(outElement.value!=='') )
                {
                    errorFunc(error,input,'エラー：出勤時間は、退勤時間より前の時間を入力してください。');
                }
                //5.退勤入力のチェック
                else if((input === outElement)&&(input.value < inElement.value))
                {
                    errorFunc(error,input,'エラー：退勤時間は、出勤時間より前の時間を入力してください。');
                }
                else
                {
                    //6.休憩入力のチェック
                    if(
                        (input.className === 'breakIn') || (input.className === 'breakOut')
                    )
                    {
                        const breaks = document.querySelectorAll('.breaks');
                        breaks.forEach( (breakElement,index) => {
                            const breakIn = breakElement.querySelector('.breakIn');
                            const breakOut = breakElement.querySelector('.breakOut');

                            if( ( breakOut.value!='' )&&( breakIn.value > breakOut.value ) )
                            {
                                errorFunc(error,input,'エラー：休憩終了時間が、休憩開始時間より大きくなるように入力してください。');
                            }
                            else if( ( input.value < inElement.value )||( input.value > outElement.value )&&(outElement.value!=='') )
                            {
                                errorFunc(error,input,'エラー：休憩時間の入力は出勤時間内になるように入力してください。');
                            }
                            else if( (index !== 0) && (breakIn.value !== '')&&( breaks[index-1].querySelector('.breakOut').value > breakIn.value ) )
                            {

                            }

                            // if(
                            //     ( breakIn.value > outElement.value)
                            //     ||( (breakOut.value !== '') &&(breakIn.value > breakOut.value) )
                            //     ||( (index !== 0) && (breakIn.value !== '')&&( breaks[index-1].querySelector('.breakOut').value > breakIn.value ) )
                            //     ||( (index !== 3) && (breakOut.value !== '')&&( breaks[index+1].querySelector('.breakIn').value > breakOut.value ) )
                            // )
                            // {
                            //     errorFunc(error,input,'エラー：休憩時間は、前後の時間に合わせて入力してください。');
                            // }

                        });

                        return;
                    }

                    console.log('input OK!');
                    error.textContent = '';
                    input.classList.remove('error');
                }

                // 労働時間の計算
                calcWorkTime();

            });

        });




        // 休憩削除ボタンが押された時の処理
        document.querySelectorAll('.breaks').forEach( (breakElement,index) => {

            const btn = breakElement.querySelector('.brakeDelete');
            const check = breakElement.querySelector('input[type="checkbox"]');

            check.addEventListener('change',()=>{

                // 労働時間の計算
                calcWorkTime();

                //休憩カラムの表示処理
                breakElement.classList.toggle('delete');
                if(check.checked){
                    btn.textContent = '休憩入力';
                }else{
                    btn.textContent = '休憩削除';
                }

                //エラー文の削除
                error.textContent = '';

            });


        });

</script>
    <script>
        'use strict';
        // 修正コンフォーム
        document.getElementById('update').addEventListener('submit',e=>{
            e.preventDefault();
            if(!confirm('この内容で上書きします。\nよろしいですか？')){return;}
            e.target.submit();
        });

        // 削除コンフォーム
        document.getElementById('destroy').addEventListener('submit',e=>{
            e.preventDefault();
            if(!confirm('この勤怠記録を削除します。\nよろしいですか？')){return;}
            e.target.submit();
        });
    </script>

</div>





<h1>Edit</h1>
<p>{{$work->id}}</p>
<p class="id">{{sprintf('%04d',$work->employee_id)}}</p>
<p>{{$work->employee->name}}</p>
<p>{{$work->date}}</p>
<p>{{gmdate('H:i',$work->in)}}-{{gmdate('H:i',$work->out)}}</p>
@foreach ($work->work_breaks as $break)
<p>{{gmdate('H:i',$break->in)}} - {{$break->out == NULL? '--:--': gmdate('H:i',$break->out)}}</p>
@endforeach
<p>{{gmdate('H:i',$work->RestrainTime)}}</p>
<p>{{gmdate('H:i',$work->BreakTime)}}</p>
<p>{{gmdate('H:i',$work->WorkingTime)}}</p>

@endsection
