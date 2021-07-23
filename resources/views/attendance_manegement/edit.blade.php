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
        {{-- <div id="error" >エラーコメント</div> --}}
        <div id="error" >
            @if(count($errors))
            <p>エラーが{{count($errors->all())}}個あります</p>
            @foreach ($errors->all() as $error)
            <p>{{$error}}</p>
            @endforeach
            @endif
        </div>
    </div>

    <form method="POST" action="{{route('attendance_manegement.update',$work)}}" onSubmit="return updateConfirm()">
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
                    <input type="text" name="in" value="{{old( 'in', gmdate('Hi',$work->in) )}}"
                    size="3" class="{{$errors->has('in')? 'error': ''}}">

                </td>
                <td class="td_size1">OUT
                    {{-- <input type="text" name="out" value="{{old( 'out', gmdate('Hi',$work->out) )}}" --}}
                    <input type="text" name="out" value="{{old( 'out',empty($work->out)? '': gmdate('Hi',$work->out) )}}"
                    size="3" class="{{$errors->has('out')? 'error': ''}}">
                </td>
                <td class="td_size1"></td>
                <td class="td_size1"></td>
            </tr>

            {{-- 休憩時間 --}}
            @foreach ($work->work_breaks as $break)
                <input type="hidden" name="break_id{{$loop->iteration}}" value="{{$break->id}}">
                @if ( old('break_delete'.$loop->iteration,) )
                <tr class="breaks delete">
                @else
                <tr class="breaks">
                @endif


                    @if ($loop->first)
                    <td class="title" rowspan="4">休憩時間</td>
                    @endif
                    <td>IN
                        <input type="text" name="break_in{{$loop->iteration}}" class="breakIn {{$errors->has('break_in'.$loop->iteration)? 'error': ''}}"
                        value="{{old( 'break_in'.$loop->iteration, gmdate('Hi',$break->in) )}}" size="3">
                    </td>
                    <td>OUT
                        <input type="text" name="break_out{{$loop->iteration}}" class="breakOut {{$errors->has('break_out'.$loop->iteration)? 'error': ''}}"
                        value="{{old('break_out'.$loop->iteration, empty($break->out)? '': gmdate('Hi',$break->out) )}}" size="3">
                    </td>
                    <td>
                        <p class="breakTime">休憩時間{{ gmdate('H:i',old( 'break_time'.$loop->iteration, $break->total_time ) )}}</p>
                        <input class="totalPost" type="hidden" name="{{'break_time'.$loop->iteration}}" value="{{old('break_time'.$loop->iteration,$break->total_time)}}">
                    </td>
                    <td>
                        @if ( old('break_delete'.$loop->iteration,) )
                        <label>
                            <input type="checkbox" name="break_delete{{$loop->iteration}}" checked="checked">
                            <p class="btn-1 brakeDelete">休憩入力</p>
                        </label>
                        @else
                        <label>
                            <input type="checkbox" name="break_delete{{$loop->iteration}}">
                            <p class="btn-1 brakeDelete">休憩削除</p>
                        </label>
                        @endif
                    </td>
                </tr>
                @php $n = $loop->iteration; @endphp
            @endforeach

            {{-- 未入力の休憩時間 --}}
            @php  $n = isset($n)? $n: 0;   @endphp
            @for ($i = $n+1; $i <= 4; $i++)
                <input type="hidden" name="break_id{{$i}}" value="">
                @if( ( count($errors->all()) >0 )&&( !old('break_delete'.$i) ) )
                <tr class="breaks">
                @else
                <tr class="breaks  delete">
                @endif
                    @if ($i==1)
                    <td class="title" rowspan="4">休憩時間</td>
                    @endif
                    <td>IN
                        <input type="text" name="break_in{{$i}}" value="{{old('break_in'.$i,'')}}"
                        class="breakIn {{$errors->has('break_in'.$i)? 'error': ''}}" size="3">
                    </td>
                    <td>OUT
                        <input type="text" name="break_out{{$i}}" value="{{old('break_out'.$i,'')}}"
                        class="breakOut {{$errors->has('break_out'.$i)? 'error': ''}}" size="3">
                    </td>
                    <td>
                        <p class="breakTime">休憩時間{{ gmdate('H:i',old('break_time'.$i) )}}</p>
                        <input class="totalPost" type="hidden" name="{{'break_time'.$i}}" value="{{old('break_time'.$i,'')}}">
                    </td>
                    <td>
                        @if( ( count($errors->all()) >0 )&&( !old('break_delete'.$i) ) )
                        <label>
                            <input type="checkbox" name="break_delete{{$i}}" >
                            <p class="btn-1 brakeDelete">休憩削除</p>
                        </label>
                        @else
                        <label>
                            <input type="checkbox" name="break_delete{{$i}}" checked="checked">
                            <p class="btn-1 brakeDelete">休憩入力</p>
                        </label>
                        @endif
                    </td>
                </tr>
            @endfor

            <tr class="total">
                <td class="title">合計</td>
                <td id="restrainTime">
                    {{old('restrainTime', '勤務時間'.gmdate('H:i',$work->RestrainTime) )}}
                </td>
                <td id="breakTime">
                    {{old('breakTime', '休憩時間'.gmdate('H:i',$work->BreakTime) )}}
                </td>
                <td id="workingTime">
                    {{old('workingTime', '労働時間'.gmdate('H:i',$work->WorkingTime) )}}
                </td>
                <td　class="td_size1"></td>
            </tr>

        </table>
        <div id='totalTimePosts' >
            <input type="hidden" name="restrainTime" value="{{gmdate('H:i',$work->RestrainTime)}}">
            <input type="hidden" name="breakTime" value="{{gmdate('H:i',$work->BreakTime)}}">
            <input type="hidden" name="workingTime" value="{{gmdate('H:i',$work->WorkingTime)}}">
        </div>
        <div class="submit_container">
            <button class="col_btn" type="submit">修正確定</button>
        </div>

    </form>
</div>

{{-- コンフォームの表示 --}}
{{-- <script src="{{url('js/conform.js')}}"></script> --}}
<script>
    'use strict';
    function updateConfirm()
    {
        if(window.confirm('この内容で上書きします。\nよろしいですか？')) // 確認ダイアログを表示
        {
            return true; // 「OK」時は送信を実行
        }
        else // 「キャンセル」時の処理
        {
            // window.alert('キャンセルされました'); // 警告ダイアログを表示
            return false; // 送信を中止
        }
    }
</script>

{{-- edit.js --}}
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

        const totalTimePosts = document.getElementById('totalTimePosts').querySelectorAll('input');
        const restrainTimePost = totalTimePosts[0];
        const breakTimePost = totalTimePosts[1];
        const workingTimePost = totalTimePosts[2];


        const cutMin = 15; //cutMin分刻みに時間を計算

        let restrainTime = 0; //勤務時間
        let breakTime = 0; //休憩時間
        let workingTime = 0; //労働時間
        let calcTime = 0;

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
        calcTime = sprintf('%02d:%02d', calcTime[0], calcTime[1]);
        restrainElement.textContent = restrainTime >= 0? '勤務時間'+calcTime: '勤務時間--:--';
        restrainTimePost.value = restrainTime >= 0? '勤務時間'+calcTime: '勤務時間--:--';


        // 休憩時間(breakTime)の計算
        document.querySelectorAll('.breaks').forEach( (breakElement,x) => {
            const breakOutElement = breakElement.querySelector('.breakOut');
            const breakInElement = breakElement.querySelector('.breakIn');
            const totalElement = breakElement.querySelector('.breakTime');
            const totalPost = breakElement.querySelector('.totalPost');
            const check = breakElement.querySelector('input[type="checkbox"]');

            //削除されている休憩はスキップ
            if(!check.checked)
            {
                let outTime = [
                    breakOutElement.value.substring(0,2),
                    breakOutElement.value.substring(2,4),
                ];
                outTime = parseInt(outTime[0],10)*60*60 + parseInt(outTime[1],10)*60;

                let inTime = [
                    breakInElement.value.substring(0,2),
                    breakInElement.value.substring(2,4),
                ];
                inTime = parseInt(inTime[0],10)*60*60 + parseInt(inTime[1],10)*60;

                let totalTime = Math.ceil( (outTime - inTime)/cutMin )*cutMin;
                totalTime = totalTime > 0? totalTime: 0;
                totalTime = breakTime + totalTime < restrainTime? 0: totalTime;//休憩時間の合計が勤務時間をおけてしまう入力の時は、個の休憩時間を加算しない。
                breakTime += totalTime;

                calcTime = [ Math.floor(totalTime/(60*60)), totalTime%(60*60)/60 ];
                calcTime = sprintf('%02d:%02d', calcTime[0], calcTime[1]);
                totalElement.textContent = totalTime >= 0? '休憩時間'+calcTime: '休憩時間--:--';
                totalPost.value = isNaN(totalTime)? 0: totalTime;
            }

        });
        calcTime = [ Math.floor(breakTime/60), breakTime%60 ];
        calcTime = sprintf('%02d:%02d', calcTime[0], calcTime[1]);
        breakElement.textContent = breakTime >= 0? '休憩時間'+calcTime: '休憩時間--:--';
        breakTimePost.value = breakTime >= 0? '休憩時間'+calcTime: '休憩時間--:--';


        // 労働時間(workingTime)の計算
        workingTime = restrainTime - breakTime;
        calcTime = [ Math.floor(workingTime/60), workingTime%60 ];
        calcTime = sprintf('%02d:%02d', calcTime[0], calcTime[1]);
        workingElement.textContent = workingTime >= 0? '労働時間'+calcTime: '労働時間--:--';
        workingTimePost.value = workingTime >= 0? '労働時間'+calcTime: '労働時間--:--';
    }



    //入力値のバリデーション
    const inElement = document.querySelector('input[name="in"]');
    const outElement = document.querySelector('input[name="out"]');

    const inputs = document.querySelectorAll('input[type="text"]');
    inputs.forEach( input => {

        input.addEventListener('change', (e) =>{

            console.log('input:'+input.value);

            //エラー処理の関数
            function errorFunc(error,input,text)
            {
                console.log('input NG!');
                error.textContent = text;
                // input.value = '';
                input.classList.add('error');
                return;
            }

            //入力内容のバリデーション
            //1.時間の型かチェック
            const error = document.getElementById('error');
            if( !input.value.match(/^(([0-1]\d|2[0-3])([0-6]\d)|2400)$/) ) //'0000~2400'と'空白'
            {
                errorFunc(error,input,'エラー：時間の入力は半角数字4桁で、2400以内の時間で入力してください。');
            }
            else if(input.value==='')
            {
                calcWorkTime();
                return;
            }
            //2.出勤入力のチェック
            else if((input === inElement)&&(input.value > outElement.value)&&(outElement.value!=='') )
            {
                errorFunc(error,input,'エラー：出勤時間を退勤時間より前になるように入力してください。');
            }
            //3.退勤入力のチェック
            else if((input === outElement)&&(input.value < inElement.value))
            {
                errorFunc(error,input,'エラー：退勤時間を出勤時間より前になるように入力してください。');
            }
            else
            {
                //4.休憩入力のチェック
                if( (input.className === 'breakIn') || (input.className === 'breakOut') )
                {
                    console.log('break');
                    const breaks = document.querySelectorAll('.breaks');
                    breaks.forEach( (breakElement,index) => {
                        const breakIn = breakElement.querySelector('.breakIn');
                        const breakOut = breakElement.querySelector('.breakOut');

                        if( ( input.value < inElement.value )||(( input.value > outElement.value )&&(outElement.value!=='')) )
                        {
                            errorFunc(error,input,'エラー：休憩時間の入力は出勤時間内になるように入力してください。');
                        }
                        // else
                        if( ( breakOut.value!='' )&&( breakIn.value > breakOut.value ) )
                        {
                            errorFunc(error,input,'エラー：休憩終了時間を休憩開始時間より後になるようにに入力してください。');
                        }
                        else if( (index !== 0) && (breakIn.value !== '')&&(  breakIn.value < breaks[index-1].querySelector('.breakOut').value ) )
                        {
                            errorFunc(error,input,'エラー：休憩時間が重ならないように入力してください。');
                        }

                    });

                    // 労働時間の計算
                    calcWorkTime();
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
@endsection

