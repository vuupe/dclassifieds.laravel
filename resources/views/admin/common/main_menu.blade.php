<?if(isset($adminMenu) && !$adminMenu->isEmpty()){?>
	<?foreach ($adminMenu as $k => $v){?>
		<?
		$class = '';
		if($v->menu_controller == $controller){
			$class = 'class="active"';
		}
		$icon = '';
		if(!empty($v->menu_icon)){
			$icon = '<i class="' . $v->menu_icon . '"></i> ';
		}
		?>
		<?if($v->menu_external_link == 1){?>
			<li><a href="<?=$v->menu_external_link?>"><?=$icon?><span><?=trans('admin_main_menu.' . $v->menu_title_key)?></span></a></li>
		<?} else {?>
			<li <?=$class?>><a href="<?=url($v->menu_link)?>"><?=$icon?><span><?=trans('admin_main_menu.' . $v->menu_title_key)?></span></a></li>
		<?}?>
	<?}//end of foreach?>
<?}//end of if?>
