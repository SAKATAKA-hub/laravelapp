<tr>
    <td>
        @if($line['require'])
        <P class="req">{{$line['text']}}</P>
        @else
        <P>{{$line['text']}}</P>
        @endif
    </td>
    <td>
        <input type="{{$line['type']}}" name="{{$line['name']}}" value="{{old($line['name'])}}">
        {{-- <input type="{{$line['type']}}" name="{{$line['name']}}" value="{{$line['old']}}"> --}}
        @if($errors->has($line['name']))
        <p class="ellor" style="color:red">{{implode(' ',$errors->get($line['name']))}}</p>
        @endif
    </td>
</tr>
