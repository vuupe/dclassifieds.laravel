<tr>
	<td>
		<?if($v['ad_count'] == 0 && (!isset($v['c']) || empty($v['c'])) ){?>
			<input type="checkbox" name="location_id[]" value="<?=$v['lid']?>">
		<?}?>
	</td>
	<td>{{ $v['lid'] }}</td>
	<td>
		<?if(count($parent) > 0){?><?echo join('&nbsp;/&nbsp;', $parent) . '&nbsp;/&nbsp;';?><?}?>{{ $v['title'] }}
	</td>
	<td>{{ $v['slug'] }}</td>
	<td>
		<?if($v['active'] == 1){?>
			<span class="fa fa-check" aria-hidden="true" style="color:green;"></span>
		<?} else {?>
			<span class="fa fa-close" aria-hidden="true" style="color:red;"></span>
		<?}?>
	</td>
	<td>{{ $v['ad_count'] }}</td>
	<td><a href="{{ url('admin/location/edit/' . $v['lid']) }}"><i class="fa fa-edit"></i> Edit</a></td>
	<td>
		<?if($v['ad_count'] == 0 && (!isset($v['c']) || empty($v['c'])) ){?>
			<a href="{{ url('admin/location/delete/' . $v['lid']) }}" class="text-danger need_confirm"><i class="fa fa-trash"></i> Delete</a>
		<?}?>
	</td>
</tr>
<?if(isset($v['c']) && !empty($v['c'])){?>
	<?$parent[] = $v['title'];?>
	<?foreach($v['c'] as $kk => $vv){?>
		@include('admin.common.location_row', ['v' => $vv, 'parent' => $parent])
	<?}?>
<?}?>