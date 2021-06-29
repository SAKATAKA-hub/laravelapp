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
        @error($line['name'])
        <p class="error">{{$message}}</p>
        @enderror
    </td>
</tr>
