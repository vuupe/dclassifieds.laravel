<tr>
	<td>
		<input type="checkbox" name="ad_id[]" value="<?=$v->ad_id?>">
	</td>
	<td>{{ $v->ad_id }}</td>
	<td>{{ $v->location_name }}</td>
	<td>{{ $v->ad_title }}</td>
	<td>{{ $v->user_id }}</td>
	<td>{{ $v->ad_puslisher_name }}</td>
	<td>{{ $v->ad_email }}</td>
	<td>
		<?if($v->ad_promo == 1){?>
			<span class="fa fa-check" aria-hidden="true" style="color:green;"></span>
		<?} else {?>
			<span class="fa fa-close" aria-hidden="true" style="color:red;"></span>
		<?}?>
	</td>
	<td>{{ $v->ad_publish_date }}</td>
	<td>
		<?if($v->ad_active == 1){?>
			<span class="fa fa-check" aria-hidden="true" style="color:green;"></span>
		<?} else {?>
			<span class="fa fa-close" aria-hidden="true" style="color:red;"></span>
		<?}?>
	</td>
	<td>{{ $v->ad_view }}</td>
	<td><a href="{{ url('admin/ad/edit/' . $v->ad_id) }}"><i class="fa fa-edit"></i> Edit</td>
	<td><a href="{{ url('admin/ad/delete/' . $v->ad_id) }}" class="text-danger need_confirm"><i class="fa fa-trash"></i> Delete</a></td>
</tr>

