<?php if(!defined('VALID_CMS_ADMIN')) { die('ACCESS DENIED'); } ?>

<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top:2px">
    <tr>
        <td valign="top" width="240" style="" id="cats_cell">

            <div class="chars_link">
                <div>
                    <?php if (!$show_all) { ?>
                        <a href="<?php echo $base_uri; ?>&all=1" style="font-weight:bold">Список характеристик</a>
                    <?php } else { $current_cat = 'Все характеристики'; ?>
                        Список характеристик
                    <?php } ?>
                </div>
            </div>

            <div style="margin-top:10px;margin-bottom:10px;border-top:dotted 1px silver"></div>

            <div class="cat_link">
                <div>
                    <?php if ($category_id || $show_all) { ?>
                        <a href="<?php echo $base_uri; ?>" style="font-weight:bold">Для всех категорий</a>
                    <?php } else { $current_cat = 'Для всех категорий'; ?>
                        Для всех категорий
                    <?php } ?>
                </div>
            </div>

            <?php foreach($cats as $cat) { ?>                
                <div style="padding-left:<?php echo ($cat['NSLevel']-1)*20; ?>px" class="cat_link">
                    <div>
                    <?php if ($category_id != $cat['id']) { ?>
                        <a href="<?php echo $base_uri.'&vendor_id='.$vendor_id.'&cat_id='.$cat['id']; ?>" style="<?php if ($cat['NSLevel']==1){ echo 'font-weight:bold'; } ?>"><?php echo $cat['title']; ?></a>
                    <?php } else { ?>
                        <?php echo $cat['title']; $current_cat = $cat['title']; ?>
                    <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </td>

        <td valign="top" id="slide_cell" class="" onclick="$('#cats_cell').toggle();$(this).toggleClass('unslided');">
            &nbsp;
        </td>

        <td valign="top" style="padding-left:2px">

            <?php if (!$show_all){ ?>
                <table class="toolmenu" cellpadding="5" border="0" width="100%" style="<?php if(!$category_id){ ?>margin-bottom: 2px;<?php } ?>">
                    <tr>
                        <td width="">
                            <span style="font-size:16px;color:#0099CC;font-weight:bold;"><?php echo $current_cat; ?></span>
                        </td>
                    </tr>
                </table>
            <?php } ?>

            <?php if ($show_all){ ?>                
                    <table class="toolmenu" cellpadding="5" border="0" width="100%" style="margin-bottom: 2px;" id="filterpanel">
                        <tr>
                            <td width="220">
                                <form action="<?php echo $base_uri; ?>&all=1" method="GET" id="filter_form">
                                    <input type="hidden" name="view" value="components" />
                                    <input type="hidden" name="do" value="config" />
                                    <input type="hidden" name="id" value="<?php echo $component_id; ?>" />
                                    <input type="hidden" name="all" value="1" />
                                    <input type="hidden" name="opt" value="list_chars" />
                                    <select name="group" style="width:220px" onchange="$('#filter_form').submit()">
                                        <option value="0" <?php if(!$group){ ?>selected="selected"<?php } ?>>все группы</option>
                                        <?php foreach($groups as $curr_group) { ?>
                                            <option value="<?php echo $curr_group; ?>" <?php if($curr_group==$group){ ?>selected="selected"<?php } ?>><?php echo $curr_group; ?></option>
                                        <?php } ?>
                                    </select>
                                </form>
                            </td>
                            <?php if ($group){ ?>
                                <td width="100">
                                    <form action="<?php echo $component_uri; ?>&opt=rename_char_group" method="post" id="rename_form">
                                        <input type="hidden" name="old_name" value="<?php echo $group; ?>" />
                                        <input type="hidden" name="new_name" value="" />
                                        <input type="button" id="grp_rename" name="grp_rename" class="button" onClick="renameCharGroup('<?php echo $group; ?>')" value="Переименовать" style="width:120px"/>
                                    </form>
                                </td>
                                <td>
                                    <form action="<?php echo $component_uri; ?>&opt=delete_char_group" method="post" id="delete_form">
                                        <input type="hidden" name="group_name" value="<?php echo $group; ?>" />
                                        <input type="button" id="grp_delete" name="grp_delete" class="button" onClick="deleteCharGroup('<?php echo $group; ?>')" value="Удалить группу" style="width:120px"/>
                                    </form>
                                </td>
                            <?php } ?>
                        </tr>
                    </table>
            <?php } ?>

            <?php if($category_id){ ?>
                <form action="<?php echo $base_uri; ?>" method="GET" id="bind_form">
                    <input type="hidden" name="view" value="components" />
                    <input type="hidden" name="do" value="config" />
                    <input type="hidden" name="id" value="<?php echo $component_id; ?>" />
                    <input type="hidden" name="opt" value="bind_char" />
                    <input type="hidden" name="cat_id" value="<?php echo $category_id; ?>" />
                    <table cellpadding="0" cellspacing="3" border="0">
                        <tr>
                            <td width="250">
                                <select id="bind_char" name="char_id" class="select" style="width:250px">
                                    <?php foreach($all_items as $item_id=>$item){ ?>
                                        <?php if(!isset($items[$item_id]) && !$item['bind_all']){ ?>
                                            <option value="<?php echo $item_id; ?>"><?php echo $item['title']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </td>
                            <td width="">
                                <input type="submit" id="bind" name="bind" class="button" value="Привязать характеристику" />
                            </td>
                            <?php if ($items){ ?>
                                <td width="30" align="center">или</td>
                                <td width="">
                                    <input type="button" id="unbind_all" name="unbind_all" class="button" onclick="$('#bind_form input[name=opt]').val('unbind_chars');$('#bind_form').submit()" value="Отвязать все характеристики" />
                                </td>
                            <?php } ?>
                        </tr>
                    </table>
                </form>
            <?php } ?>

            <?php if($category_id){ ?>
                <form action="<?php echo $base_uri; ?>" method="GET" id="bind_group_form">
                    <input type="hidden" name="view" value="components" />
                    <input type="hidden" name="do" value="config" />
                    <input type="hidden" name="id" value="<?php echo $component_id; ?>" />
                    <input type="hidden" name="opt" value="bind_char_group" />
                    <input type="hidden" name="cat_id" value="<?php echo $category_id; ?>" />
                    <table cellpadding="0" cellspacing="3" border="0">
                        <tr>
                            <td width="250">
                                <select id="bind_char_group" name="char_group_id" class="select" style="width:250px">
                                    <?php foreach($groups as $curr_group) { ?>
                                        <option value="<?php echo $curr_group; ?>" <?php if($curr_group==$group){ ?>selected="selected"<?php } ?>><?php echo $curr_group; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td width="">
                                <input type="submit" id="bind" name="bind" class="button" value="Привязать группу характеристик" />
                            </td>
                        </tr>
                    </table>
                </form>
            <?php } ?>

            <?php if ($items){ $num=0; ?>
            <form name="selform" action="index.php?view=components" method="post">
                <table id="listTable" class="tablesorter" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top:0px">
                    <thead>
                        <tr>
                            <th class="lt_header" width="25">id</th>
                            <th class="lt_header" width="">Название</th>
                            <th class="lt_header" width="150">Группа</th>
                            <th class="lt_header" width="45">Показ</th>
                            <?php if ($category_id && sizeof($items)>1){ ?>
                                <th class="lt_header" width="24">&darr;&uarr;</th>
                            <?php } ?>
                            <th class="lt_header" align="center" width="65">Действия</th>
                        </tr>
                    </thead>                    
                        <tbody>
                            <?php foreach($items as $item_id=>$item){ $num++;?>
                                <tr id="<?php echo $item['id']; ?>">
                                    <td><?php echo $item['id']; ?></td>
                                    <td>
                                        <a href="index.php?view=components&do=config&id=<?php echo $component_id; ?>&opt=edit_char&item_id=<?php echo $item['id']; ?>">
                                            <?php echo $item['title']; ?>
                                        </a>                                        
                                    </td>                                    
                                    <td>
                                        <?php echo ($item['fieldgroup'] ? $item['fieldgroup'] : '---'); ?>
                                    </td>
                                    <td>
                                        <?php if ($item['published']) { ?>
                                            <a id="publink<?php echo $item['id']; ?>" href="javascript:pub(<?php echo $item['id']; ?>, 'view=components&do=config&id=<?php echo $component_id; ?>&opt=hide_char&item_id=<?php echo $item['id']; ?>', 'view=components&do=config&id=35&opt=show_char&item_id=<?php echo $item['id']; ?>', 'off', 'on');" title="Скрыть">
                                                <img id="pub<?php echo $item['id']; ?>" border="0" src="images/actions/on.gif"/>
                                            </a>
                                        <?php } else { ?>
                                            <a id="publink<?php echo $item['id']; ?>" href="javascript:pub(<?php echo $item['id']; ?>, 'view=components&do=config&id=<?php echo $component_id; ?>&opt=show_char&item_id=<?php echo $item['id']; ?>', 'view=components&do=config&id=35&opt=hide_char&item_id=<?php echo $item['id']; ?>', 'on', 'off');" title="Показать">
                                                <img id="pub<?php echo $item['id']; ?>" border="0" src="images/actions/off.gif"/>
                                            </a>
                                        <?php } ?>

                                        <?php if ($item['is_compare']) { ?>
                                            <a id="comparelink<?php echo $item['id']; ?>" href="javascript:compare(<?php echo $item['id']; ?>, 'view=components&do=config&id=<?php echo $component_id; ?>&opt=uncompare_char&item_id=<?php echo $item['id']; ?>', 'view=components&do=config&id=35&opt=compare_char&item_id=<?php echo $item['id']; ?>', 'uncompare', 'compare');" title="В сравнении">
                                                <img id="compare<?php echo $item['id']; ?>" border="0" src="components/shop/images/compare.gif"/>
                                            </a>
                                        <?php } else { ?>
                                            <a id="comparelink<?php echo $item['id']; ?>" href="javascript:compare(<?php echo $item['id']; ?>, 'view=components&do=config&id=<?php echo $component_id; ?>&opt=compare_char&item_id=<?php echo $item['id']; ?>', 'view=components&do=config&id=35&opt=uncompare_char&item_id=<?php echo $item['id']; ?>', 'compare', 'uncompare');" title="В сравнении">
                                                <img id="compare<?php echo $item['id']; ?>" border="0" src="components/shop/images/uncompare.gif"/>
                                            </a>
                                        <?php } ?>

                                        <?php if ($item['is_filter']) { ?>
                                            <a id="filterlink<?php echo $item['id']; ?>" href="javascript:filter(<?php echo $item['id']; ?>, 'view=components&do=config&id=<?php echo $component_id; ?>&opt=unfilter_char&item_id=<?php echo $item['id']; ?>', 'view=components&do=config&id=35&opt=filter_char&item_id=<?php echo $item['id']; ?>', 'unfilter', 'filter');" title="В фильтре">
                                                <img id="filter<?php echo $item['id']; ?>" border="0" src="components/shop/images/filter.gif"/>
                                            </a>
                                        <?php } else { ?>
                                            <a id="filterlink<?php echo $item['id']; ?>" href="javascript:filter(<?php echo $item['id']; ?>, 'view=components&do=config&id=<?php echo $component_id; ?>&opt=filter_char&item_id=<?php echo $item['id']; ?>', 'view=components&do=config&id=35&opt=unfilter_char&item_id=<?php echo $item['id']; ?>', 'filter', 'unfilter');" title="В фильтре">
                                                <img id="filter<?php echo $item['id']; ?>" border="0" src="components/shop/images/unfilter.gif"/>
                                            </a>
                                        <?php } ?>

                                    </td>
                                    <?php if ($category_id && sizeof($items)>1){ ?>
                                        <td>
                                            <?php
                                                $display_move_down  = ($num<sizeof($items)) ? 'inline' : 'none';
                                                $display_move_up    = ($num>1) ? 'inline' : 'none';
                                            ?>
                                            <a class="move_item_down" href="javascript:void(0)" onclick="moveChar(<?php echo $item['id']; ?>, 1)" title="Подвинуть ниже" style="float:left;display:<?php echo $display_move_down; ?>"><img src="images/actions/down.gif" border="0"/></a>
                                            <a class="move_item_up" href="javascript:void(0)" onclick="moveChar(<?php echo $item['id']; ?>, -1)" title="Подвинуть выше" style="float:right;display:<?php echo $display_move_up; ?>"><img src="images/actions/top.gif" border="0"/></a>
                                        </td>
                                    <?php } ?>
                                    <td align="right">
                                        <div style="padding-right: 8px;">
                                            <a title="Значения" href="?view=components&do=config&id=<?php echo $component_id; ?>&opt=edit_char_values&item_id=<?php echo $item['id']; ?>">
                                                <img border="0" hspace="2" alt="Значения" src="components/shop/images/values.gif"/>
                                            </a>
                                            <a title="Редактировать" href="?view=components&do=config&id=<?php echo $component_id; ?>&opt=edit_char&item_id=<?php echo $item['id']; ?>">
                                                <img border="0" hspace="2" alt="Редактировать" src="images/actions/edit.gif"/>
                                            </a>
                                            <?php if ($show_all){ ?>
                                                <a title="Удалить характеристику" onclick="jsmsg('Удалить характеристику <?php echo $item['title']; ?>?', '?view=components&do=config&id=<?php echo $component_id; ?>&opt=delete_char&item_id=<?php echo $item['id']; ?>')" href="#">
                                                    <img border="0" hspace="2" alt="Удалить" src="images/actions/delete.gif"/>
                                                </a>                                                
                                            <?php } else { ?>
                                                <a title="Отвязать характеристику" onclick="jsmsg('Удалить привязку характеристики?\nСама характеристика не будет удалена', '?view=components&do=config&id=<?php echo $component_id; ?>&opt=unbind_char&item_id=<?php echo $item['id']; ?>&cat_id=<?php echo $category_id; ?>')" href="#">
                                                    <img border="0" hspace="2" alt="Удалить" src="components/shop/images/unbind.gif"/>
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>                    
                </table>
                <?php } ?>
                
                <?php if (!$items){ ?>
                    <form action="<?php echo $base_uri; ?>" method="GET" id="copy_form">
                        <input type="hidden" name="view" value="components" />
                        <input type="hidden" name="do" value="config" />
                        <input type="hidden" name="id" value="<?php echo $component_id; ?>" />
                        <input type="hidden" name="opt" value="copy_cat_chars" />
                        <input type="hidden" name="to_cat_id" value="<?php echo $category_id; ?>" />
                        <table cellpadding="0" cellspacing="3" border="0">
                            <tr>
                                <td>
                                    <select name="from_cat_id" style="width:250px">
                                        <?php
                                            echo $inCore->getListItemsNS('cms_shop_cats');
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="submit" id="submit" name="copy_chars" class="button" value="Скопировать характеристики" />
                                </td>
                            </tr>
                        </table>
                   </form>
                <?php } ?>

                <script type="text/javascript">highlightTableRows("listTable", "hoverRow", "clickedRow");</script>
            </form>
            
        </td>
    </tr>
</table>