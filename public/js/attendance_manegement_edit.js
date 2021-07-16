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


    // 勤務時間(restrainTime)の計算
    let outTime = outElement.value.split(':');
    outTime = parseInt(outTime[0],10)*60 + parseInt(outTime[1],10);
    outTime = Math.floor(outTime/cutMin)*cutMin;

    let inTime = inElement.value.split(':');
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
            let outTime = breakOutElement.value.split(':');
            outTime = parseInt(outTime[0],10)*60 + parseInt(outTime[1],10);

            let inTime = breakInElement.value.split(':');
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



//値が入力された時の処理
const inElement = document.querySelector('input[name="in"]');
const outElement = document.querySelector('input[name="out"]');

const inputs = document.querySelectorAll('input[type="text"]');
inputs.forEach( input => {

    input.addEventListener('change', (e) =>{

        console.log('input:'+input.value);
        const inputVal = input.value.split(':');
        const cutMinut = 15;

        //入力内容のバリデーション
        //1.時間の型かチェック
        const error = document.getElementById('error');
        if( !input.value.match(/^(\d{2}\d{2})$|^()$/) ) //'00:00型'と'空白'
        {
            console.log('input NG!');
            error.textContent = 'エラー：時間の入力は"半角数字4ケタ"で入力してください。';
            input.value = '';
            input.classList.add('error');
            // return;
        }
        else if(input.value==='')
        {
            calcWorkTime();
            return;
        }

        //2.時間が0～24の間で入力されているかチェック
        else if(parseInt(inputVal[0],10) > 24)
        {
            console.log('input NG!');
            error.textContent = 'エラー：時間は"0～24"の数字で入力してください。';
            input.value = '';
            input.classList.add('error');
            // return;
        }
        //3.分が0～60の間で入力されているかチェック
        else if(parseInt(inputVal[1],10) > 60)
        {
            console.log('input NG!');
            error.textContent = 'エラー：分は"0～60"の数字で入力してください。';
            input.value = '';
            input.classList.add('error');
            // return;
        }
        //4.分がcutMinut分刻みでで入力されているかチェック
        // else if(parseInt(inputVal[1],10) % cutMinut !== 0)
        // {
        //     console.log(input.value);
        //     console.log('input NG!');
        //     error.textContent = 'エラー：分は15分刻みでで入力してください。';
        //     input.value = '';
        //     input.classList.add('error');
        //     // return;
        // }
        //5.出勤・退勤入力のチェック
        else if(
            ( (input === inElement)&&(input.value > outElement.value) ) ||
            ( (input === outElement)&&(input.value < inElement.value) )
        )
        {
            console.log('input NG!');
            error.textContent = 'エラー：出退勤入力時間が前後しているこによるエラー。';
            input.value = '';
            input.classList.add('error');
        }
        else
        {
            //休憩入力のチェック
            if(
                (input.className === 'breakIn') || (input.className === 'breakOut')
            )
            {
                console.log('break!');

                const breaks = document.querySelectorAll('.breaks');
                breaks.forEach( (breakElement,index) => {
                    const breakIn = breakElement.querySelector('.breakIn');
                    const breakOut = breakElement.querySelector('.breakOut');

                    if(
                        ( breakIn.value > outElement.value)
                        ||( (breakOut.value !== '') &&(breakIn.value > breakOut.value) )
                        ||( (index !== 0) && (breakIn.value !== '')&&( breaks[index-1].querySelector('.breakOut').value > breakIn.value ) )
                        ||( (index !== 3) && (breakOut.value !== '')&&( breaks[index+1].querySelector('.breakIn').value > breakOut.value ) )
                    )
                    {
                        console.log('input NG!');
                        error.textContent = 'エラー：入力内容と前後の時間がそぐわない事によるエラー。';
                        input.value = '';
                        input.classList.add('error');
                        return;
                    }

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
        error.textContent = 'エラー：';

    });


});

