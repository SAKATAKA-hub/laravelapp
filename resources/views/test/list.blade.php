<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!--vue.js-->
    {{-- <link rel="stylesheet" href="{{ mix('/css/app.css') }}"><!--vue.js--> --}}
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script><!--vue.js-->
    <title>テスト</title>
</head>
<body id="EmployeeList">
    <h1>テストページ</h1>



        <!-- Vue.jsを利用したチェックボックス -->
        <form name="seach" action="#" method="POST">
            <ul class="op_btns">
                <li><input type="text" name="mode" placeholder="例）名前 ふりがな　ID"></li>

                <li class="dd_menu" v-for="(CheckGroups, index) in CheckBoxs">
                    {{-- <div class="btn-op refined">{{CheckBox['title']}}</div> --}}
                    {{-- <div class="btn-op refined">{{name}}</div> --}}
                </li>

                {{--

                    <ul class="dd_box">
                        <!-- □全て選択  -->
                        <li><label><input type="checkbox" name="{{CheckBox.all.name}}" v-model="CheckBoxs[index].all.checked" @change="AllChecked(index)" :checked="CheckBox.all.checked">全て選択</label></li>
                        <!-- <li><label><input type="checkbox" name="namae" @click="AllChecked()">全て選択</label></li> -->

                        <!-- □個別選択 -->
                        <li v-for="(check,i) in CheckBox.checkes"><label>
                            <input type="checkbox" name="departments" v-model="CheckBoxs[index].checkes[i].checked" value="{{check.value}}" @change="DisCheck(index)" :checked="check.checked">
                            {{check.value}}
                        </label></li>
                    </ul>
                 --}}

                <li class="serch_btn"><button class="btn-op">絞り込み</button></li>

            </ul>
        </form>

        <!-- END Vue.jsを利用したチェックボックス -->


    @foreach($CheckGroups as $key => $CheckGroup)
    {{-- <h3>{{$CheckGroup['title']}}</h3> --}}
    @foreach($CheckGroup['checks'] as $Check)

    {{-- <p>{{$Check['item']}}</p> --}}

    @endforeach
    @endforeach





    {{-- 従業員検索 --}}
    <form action="#" method="post">
        @csrf
        <div>従業員検索</div>
        <input type="text" name="keyword" value="">

        <div>所属部署 :
            <label><input type="checkbox" name="department" value="営業一課　世田谷支店">営業一課　世田谷支店</label>
            <label><input type="checkbox" name="department" value="営業一課　渋谷支店">営業一課　渋谷支店</label>
            <label><input type="checkbox" name="department" value="営業一課　新宿支店">営業一課　新宿支店</label>
        </div>

        <div>役職 :
            <label><input type="checkbox" name="position" value="係長">係長</label>
            <label><input type="checkbox" name="position" value="主任">主任</label>
            <label><input type="checkbox" name="position" value="一般社員">一般社員</label>
        </div>

        <div>性別 :
            <label><input type="checkbox" name="gender" value="男性">男性</label>
            <label><input type="checkbox" name="gender" value="女性">女性</label>
        </div>

        <button type="submit">検索</button>
    </form>
    <br>


    {{-- 従業員一覧 --}}
    <div>従業員一覧</div>
    @foreach($items as $item)
        <div>
            {{$item->id}} {{$item->name}}({{$item->kana_name}}) tel:{{$item->tell}} mail:{{$item->email}}
            <form action="{{route('test.detail')}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$item->id}}">
                <button>詳細</button>
            </form>
        </div>

    @endforeach



    <?php
        $json_data = json_encode($CheckGroups);
    ?>

    {{-- <script src=" {{ mix('js/app.js') }} "></script> --}}
    <script>
        Vue.component('button-counter', {
            data: function () {
                return {
                    count: 0
                }
            },
            // template: '<button v-on:click="count++">You clicked me {{ count }} times.</button>',
        })

        new Vue({
            el  : '#EmployeeList',
            data: {
                name: 'sakai',
                CheckGroups : JSON.parse('<?php echo $json_data; ?>'),
            },

        });
    </script>
{{--
    <script>
        /* PHPのデータをからJSにJSONデータとして変換させる */
        // const jsonData = JSON.parse('<?= $json_data; ?>');
        let vm = new Vue({

            el  : '#EmployeeList',
            data: {
                // CheckBoxs : jsonData,
            },

            methods: {
                // #「すべて選択」で全てのチェックボックスにチェックが付く
                // AllChecked : function(index)
                // {
                //     const checkbox_all = this.CheckBoxs[index].all;
                //     const checkbox = this.CheckBoxs[index].checkes;

                //     for (let i = 0; i < checkbox.length; i++)
                //     {
                //         checkbox[i].checked = checkbox_all.checked;
                //     }
                // },

                // #「すべて選択」チェックが付く
                // DisCheck : function(index)
                // {
                //     console.log('DisCheck');
                //     const checkbox_all = this.CheckBoxs[index].all;
                //     const checkbox = this.CheckBoxs[index].checkes;
                //     let count = 0;
                //     for (let i = 0; i < checkbox.length; i++)
                //     {
                //         if(checkbox[i].checked)
                //         {
                //             count ++;
                //             checkbox_all.checked = checkbox.length === count ? true : false;
                //         }
                //         else
                //         {
                //             checkbox_all.checked =  false;
                //         }
                //     }
                // },

            },

        });
    </script>
 --}}
</body>
</html>
