<tr>
    <td>
        @if($v['ad_count'] == 0 && (!isset($v['c']) || empty($v['c'])) )
            <input type="checkbox" name="category_id[]" value="{{  $v['cid'] }}">
        @endif
    </td>
    <td>{{ $v['cid'] }}</td>
    <td>
        @if(count($parent) > 0){{ join('&nbsp;/&nbsp;', $parent) . '&nbsp;/&nbsp;' }}@endif{{ $v['title'] }}
    </td>
    <td>{{ $v['slug'] }}</td>
    <td>{{ $categoryType[$v['category_type']] }}</td>
    <td>{{ $v['ord'] }}</td>
    <td>
        @if($v['active'] == 1)
            <span class="fa fa-check" aria-hidden="true" style="color:green;"></span>
        @else
            <span class="fa fa-close" aria-hidden="true" style="color:red;"></span>
        @endif
    </td>
    <td>{{ $v['ad_count'] }}</td>
    <td><a href="{{ url('admin/category/edit/' . $v['cid']) }}"><i class="fa fa-edit"></i> {{ trans('admin_common.Edit') }}</a></td>
    <td>
        @if($v['ad_count'] == 0 && (!isset($v['c']) || empty($v['c'])) )
            <a href="{{ url('admin/category/delete/' . $v['cid']) }}" class="text-danger need_confirm"><i class="fa fa-trash"></i> {{ trans('admin_common.Delete') }}</a>
        @endif
    </td>
</tr>
@if(isset($v['c']) && !empty($v['c']))
    <?$parent[] = $v['title'];?>
    @foreach($v['c'] as $kk => $vv)
        @include('admin.common.category_row', ['v' => $vv, 'parent' => $parent])
    @endforeach
@endif