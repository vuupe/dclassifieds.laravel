@foreach ($c as $k => $v)
    @if(isset($cid) && $cid == $v['cid'])
        <option value="{{$v['cid']}}" style="padding-left: {{$v['level']*10}}px;" selected data-type="{{ $v['category_type'] }}">{{$v['title']}}</option>
    @else
        <option value="{{$v['cid']}}" style="padding-left: {{$v['level']*10}}px;" data-type="{{ $v['category_type'] }}">{{$v['title']}}</option>
    @endif

    @if(isset($v['c']) && !empty($v['c'])){
        @include('common.cselect', ['c' => $v['c']])
    @endif
@endforeach