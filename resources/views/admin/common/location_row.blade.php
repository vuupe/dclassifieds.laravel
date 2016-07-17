<tr>
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
	<td><a href=""><i class="fa fa-edit"></i> Edit</a></td>
	<td><a href="" class="text-danger"><i class="fa fa-trash"></i> Delete</a></td>
</tr>
<?if(isset($v['c']) && !empty($v['c'])){?>
	<?$parent[] = $v['title'];?>
	<?foreach($v['c'] as $kk => $vv){?>
		@include('admin.common.location_row', ['v' => $vv, 'parent' => $parent])
	<?}?>
<?}?>