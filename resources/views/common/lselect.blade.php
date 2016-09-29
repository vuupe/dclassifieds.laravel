@foreach ($c as $k => $v)
    @if(isset($lid) && $lid == $v['lid'])
        <option value="{{$v['lid']}}" style="padding-left: {{$v['level']*10}}px;" selected>{{$v['title']}}</option>
    @else
        <option value="{{$v['lid']}}" style="padding-left: {{$v['level']*10}}px;">{{$v['title']}}</option>
    @endif

    @if(isset($v['c']) && !empty($v['c'])){
        @include('common.lselect', ['c' => $v['c']])
    @endif
@endforeach