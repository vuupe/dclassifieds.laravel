<tr>
	<td>
		<input type="checkbox" name="user_id[]" value="<?=$v->user_id?>">
	</td>
	<td>{{ $v->user_id }}</td>
	<td>{{ $v->name }}</td>
	<td>{{ $v->email }}</td>
	<td>
		<?if($v->user_activated == 1){?>
			<span class="fa fa-check" aria-hidden="true" style="color:green;"></span>
		<?} else {?>
			<span class="fa fa-close" aria-hidden="true" style="color:red;"></span>
		<?}?>
	</td>
	<td>{{ $v->location_name }}</td>
	<td><a href="{{ url('admin/user/edit/' . $v->user_id) }}"><i class="fa fa-edit"></i> Edit</td>
	<td><a href="{{ url('admin/user/delete/' . $v->user_id) }}" class="text-danger need_confirm"><i class="fa fa-trash"></i> Delete</a></td>
</tr>

