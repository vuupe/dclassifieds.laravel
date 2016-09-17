<?if(isset($adminMenu) && !$adminMenu->isEmpty()){?>
    <?foreach ($adminMenu as $k => $v){?>
        <?if($v->menu_type_id == 1){?>
            <?
            $class = '';
            if($v->menu_controller == $controller){
                $class = 'class="active"';
            }
            $icon = '';
            if(!empty($v->menu_icon)){
                $icon = '<i class="' . $v->menu_icon . '"></i>';
            }
            ?>
            <?if($v->menu_external_link == 1){?>
                <li><a href="<?=$v->menu_external_link?>"><?=$icon?> <span><?=trans('admin_main_menu.' . $v->menu_title_key)?></span></a></li>
            <?} else {?>
                <li <?=$class?>><a href="<?=url($v->menu_link)?>"><?=$icon?> <span><?=trans('admin_main_menu.' . $v->menu_title_key)?></span></a></li>
            <?}?>
        <?} else {?>
            <?
            $icon = '';
            if(!empty($v->menu_icon)){
                $icon = '<i class="' . $v->menu_icon . '"></i>';
            }
            $active = '';
            if($controller_parent_id == $v->menu_id){
                $active = 'active';
            }
            ?>
            <li class="<?=$active?> treeview">
                <a href="#">
                    <?=$icon?> <span><?=trans('admin_main_menu.' . $v->menu_title_key)?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <?if(isset($v->c) && !$v->c->isEmpty()){?>
                <ul class="treeview-menu">
                    <?foreach($v->c as $sk => $sv){?>
                        <?
                        $class = '';
                        if($sv->menu_controller == $controller){
                            $class = 'class="active"';
                        }
                        $icon = '';
                        if(!empty($sv->menu_icon)){
                            $icon = '<i class="' . $sv->menu_icon . '"></i>';
                        }
                        ?>
                        <?if($sv->menu_external_link == 1){?>
                            <li><a href="<?=$v->menu_external_link?>"><?=$icon?> <span><?=trans('admin_main_menu.' . $sv->menu_title_key)?></span></a></li>
                        <?} else {?>
                            <li <?=$class?>><a href="<?=url($sv->menu_link)?>"><?=$icon?> <span><?=trans('admin_main_menu.' . $sv->menu_title_key)?></span></a></li>
                        <?}?>
                    <?}?>
                </ul>
                <?}?>
            </li>
        <?}?>
    <?}//end of foreach?>
<?}//end of if?>


