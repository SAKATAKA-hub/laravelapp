<tr>
<td>
    <p class="req">{{$checkbox_group['title']}}</P>
    <p style="color:red"> 必須</p>
</td>
<td>
    <select name="{{$checkbox_group['key']}}">
        @foreach($checkbox_group['checks'] as $checkbox)
        @if ($checkbox['item'] == old($checkbox_group['key']))
        <option value="{{$checkbox['item']}}" selected>{{$checkbox['item']}}</option>
        @else
        <option value="{{$checkbox['item']}}">{{$checkbox['item']}}</option>
        @endif
        @endforeach
    </select>
</td>

</tr>

<!--
$lines = [
    ['text'=>'', 'type'=> 'text', 'name'=> 'text', 'value'=> 'text', ],
];
 -->
