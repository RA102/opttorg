<?php if (!defined('VALID_CMS_ADMIN')) {
    die('ACCESS DENIED');
} ?>

<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top:2px">
    <tr>
        <td valign="top" width="240" style="<?php if ($hide_cats) { ?>display:none;<?php } ?>" id="cats_cell">

            <div class="cat_add_link">
                <div>
                    <a href="?view=components&do=config&id=<?php echo $component_id; ?>&opt=add_cat" style="color:#09C">Добавить категорию</a>
                </div>
            </div>
            <div class="cat_link">
                <div>
                    <?php if ($category_id) { ?>
                        <a href="<?php echo $base_uri; ?>" style="font-weight:bold">Все товары</a>
                    <?php } else {
                        $current_cat = 'Все товары'; ?>
                        Все товары
                    <?php } ?>
                </div>
            </div>
            <?php foreach ($cats as $num => $cat) { ?>
                <div style="padding-left:<?php echo ($cat['NSLevel'] - 1) * 20; ?>px" class="cat_link">
                    <div onmouseover="$(this).find('.move').show()" onmouseout="$(this).find('.move').hide()">
                        <?php if ($category_id != $cat['id']) { ?>
                            <a href="<?php echo $base_uri . '&vendor_id=' . $vendor_id . '&cat_id=' . $cat['id']; ?>" style="<?php if ($cat['NSLevel'] == 1) {
                                echo 'font-weight:bold';
                            } ?>"><?php echo $cat['title']; ?></a>
                        <?php } else { ?>
                            <?php echo $cat['title'];
                            $current_cat = $cat['title']; ?>
                        <?php } ?>
                        <span class=""><?php echo $total ?></span>
                        <span class="move" style="display:none">
                            <a href="/admin/index.php?view=components&do=config&id=<?php echo $component_id; ?>&opt=move_cat&cat_id=<?php echo $cat['id']; ?>&dir=up" title="Вверх"><img src="/components/shop/images/cat_up.png" border="0"/></a>
                            <a href="/admin/index.php?view=components&do=config&id=<?php echo $component_id; ?>&opt=move_cat&cat_id=<?php echo $cat['id']; ?>&dir=down" title="Вниз"><img src="/components/shop/images/cat_down.png" border="0"/></a>
                        </span>
                    </div>
                </div>
            <?php } ?>
        </td>

        <td valign="top" id="slide_cell" class="<?php if ($hide_cats) { ?>unslided<?php } ?>" onclick="$('#cats_cell').toggle();$(this).toggleClass('unslided');$('#filter_form input[name=hide_cats]').val(1-$('#cats_cell:visible').length)">
            &nbsp;
        </td>

        <td valign="top" style="padding-left:2px">

            <form action="<?php echo $base_uri; ?>" method="GET" id="filter_form">
                <input type="hidden" name="view" value="components"/>
                <input type="hidden" name="do" value="config"/>
                <input type="hidden" name="id" value="<?php echo $component_id; ?>"/>
                <input type="hidden" name="opt" value="list_items"/>
                <input type="hidden" name="cat_id" value="<?php echo $category_id; ?>"/>
                <input type="hidden" name="hide_cats" value="<?php echo $hide_cats; ?>"/>
                <table class="toolmenu" cellpadding="5" border="0" width="100%" style="margin-bottom: 2px;">
                    <tr>
                        <td width="">
                            <span style="font-size:16px;color:#0099CC;font-weight:bold;">
                                <?php echo $current_cat . ' ' . ($vendor ? '<a href="?view=components&do=config&id=35&opt=edit_vendor&item_id=' . $vendor_id . '">' . $vendor . '</a>' : ''); ?>
                            </span>
                            <span style="padding-left: 15px;">
                                <a title="Добавить товар" href="?view=components&do=config&id=<?php echo $component_id; ?>&opt=add_item<?php if ($category_id) { ?>&cat_id=<?php echo $category_id;
                                } ?>">
                                    <img border="0" hspace="2" alt="Добавить товар" src="images/actions/add.gif"/>
                                </a>
                                <a title="Изменить цены" href="javascript:" onclick="javascript:$('#pricepanel').slideToggle();">
                                    <img border="0" hspace="2" alt="Изменить цены" src="components/shop/images/price.gif"/>
                                </a>
                                <?php if ($category_id) { ?>
                                    <a title="Характеристики товаров категории" href="?view=components&do=config&id=<?php echo $component_id; ?>&opt=list_chars&cat_id=<?php echo $category_id; ?>">
                                        <img border="0" hspace="2" alt="Характеристики товаров категории" src="components/shop/images/char.gif"/>
                                    </a>
                                    <a title="Редактировать категорию" href="?view=components&do=config&id=<?php echo $component_id; ?>&opt=edit_cat&item_id=<?php echo $category_id; ?>">
                                        <img border="0" hspace="2" alt="Редактировать категорию" src="images/actions/edit.gif"/>
                                    </a>
                                    <a title="Удалить категорию" onclick="jsmsg('Удалить категорию?', '?view=components&do=config&id=<?php echo $component_id; ?>&opt=delete_cat&item_id=<?php echo $category_id; ?>')" href="#">
                                        <img border="0" hspace="2" alt="Удалить категорию" src="images/actions/delete.gif"/>
                                    </a>
                                <?php } ?>
                            </span>
                        </td>
                    </tr>
                </table>
                <table class="toolmenu" cellpadding="5" border="0" width="100%" style="margin-bottom: 2px;" id="filterpanel">
                    <tr>
                        <td width="130">
                            <select name="orderby" style="width:130px" onchange="$('#filter_form').submit()">
                                <?php if ($category_id) { ?>
                                    <option value="ic.ordering" <?php if ($orderby == 'ordering'){ ?>selected="selected"<?php } ?>>по порядку</option>
                                <?php } ?>
                                <option value="title" <?php if ($orderby == 'title'){ ?>selected="selected"<?php } ?>>по названию</option>
                                <option value="art_no" <?php if ($orderby == 'art_no'){ ?>selected="selected"<?php } ?>>по артикулу</option>
                                <option value="price" <?php if ($orderby == 'price'){ ?>selected="selected"<?php } ?>>по цене</option>
                                <option value="id" <?php if ($orderby == 'id'){ ?>selected="selected"<?php } ?>>по id</option>
                                <option value="qty" <?php if ($orderby == 'qty'){ ?>selected="selected"<?php } ?>>по количеству</option>

                            </select>
                        </td>
                        <td width="150">
                            <select name="orderto" style="width:150px" onchange="$('#filter_form').submit()">
                                <option value="asc" <?php if ($orderto == 'asc'){ ?>selected="selected"<?php } ?>>по возрастанию</option>
                                <option value="desc" <?php if ($orderto == 'desc'){ ?>selected="selected"<?php } ?>>по убыванию</option>
                            </select>
                        </td>
                        <td width="180">
                            <select name="vendor_id" style="width:180px" onchange="$('#filter_form').submit()">
                                <option value="0" <?php if (!$vendor_id){ ?>selected="selected"<?php } ?>>все производители</option>
                                <?php foreach ($vendors as $vendor) { ?>
                                    <option value="<?php echo $vendor['id']; ?>" <?php if ($vendor_id == $vendor['id']){ ?>selected="selected"<?php } ?>><?php echo $vendor['title']; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td width="20">Арт.:</td>
                        <td width="60">
                            <input type="text" name="art_no" value="<?php echo $art_no_part; ?>" style="width:60px"/>
                        </td>
                        <td width="40">Код произ.:</td>
                        <td width="100">
                            <input type="text" name="ven_code" value="<?php echo $ven_code ?>" style="width:100px"/>
                        </td>
                        <td width="60">Название:</td>
                        <td width="">
                            <input type="text" name="title" value="<?php echo $title_part; ?>" style="width:99%"/>
                        </td>
                        <td width="30">
                            <input type="submit" name="filter" value=">>" style="width:30px"/>
                        </td>
                    </tr>
                </table>
            </form>

            <?php if ($inCore->inRequest('prices_upd')) { ?>
                <div style="color:green;margin-top:10px;margin-bottom:15px;">Цены на товары были успешно изменены</div>
            <?php } ?>

            <form action="<?php echo $base_uri; ?>" method="GET" id="pricepanel">
                <input type="hidden" name="view" value="components"/>
                <input type="hidden" name="do" value="config"/>
                <input type="hidden" name="id" value="<?php echo $component_id; ?>"/>
                <input type="hidden" name="opt" value="update_prices"/>
                <input type="hidden" name="cat_id" value="<?php echo $category_id; ?>"/>
                <div class="toolmenu">
                    <table class="" cellpadding="3" border="0" style="margin-bottom: 4px;">
                        <tr>
                            <td width="130">
                                <select name="p_sign" style="width:130px">
                                    <option value="1">Увеличить</option>
                                    <option value="-1">Уменьшить</option>
                                </select>
                            </td>
                            <td width="">
                                цены на
                                <input type="hidden" name="p_cat_id" value="<?php echo $category_id; ?>"/>
                            </td>
                            <!--
                        <td width="150">
                            <select name="p_cat_id" style="width:150px">
                                <option value="0" <?php if ($category_id == 0) {
                                echo 'selected';
                            } ?>>все товары</option>
                                <?php
                            // echo $inCore->getListItemsNS('cms_shop_cats', $category_id);
                            ?>
                            </select>
                        </td>
                        -->
                            <td width="">
                                <input type="text" name="p_val" value="" style="width:60px"/>
                                <select name="p_is_percent" style="width:60px">
                                    <option value="1">%</option>
                                    <option value="0">руб.</option>
                                </select>
                            </td>
                            <td width="">
                                <input type="checkbox" id="p_is_recursive" name="p_is_recursive" value="1" title="Включая подкатегории"/>
                            </td>
                            <td width="">
                                <label for="p_is_recursive">рекурсивно</label>
                            </td>
                            <td width="">
                                <input type="checkbox" id="p_is_round" name="p_is_round" value="1" title="Цены без копеек"/>
                            </td>
                            <td width="">
                                <label for="p_is_round">округлять</label>
                            </td>
                            <td width="">
                                <input type="checkbox" id="p_is_old" name="p_is_old" value="1" title="Текущие цены станут зачеркнутыми на сайте"/>
                            </td>
                            <td width="">
                                <label for="p_is_old">сохр. старые цены</label>
                            </td>
                            <td>
                                <input type="submit" id="p_submit" name="p_submit" value="Применить"/>
                            </td>
                        </tr>
                    </table>
                </div>
            </form>

            <form name="selform" action="index.php?view=components" method="post">
                <table id="listTable" class="tablesorter" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top:0px">
                    <thead>
                    <tr>
                        <th class="lt_header" align="center" width="20">
                            <a class="lt_header_link" title="Инвертировать выделение" href="javascript:" onclick="javascript:invert()">#</a>
                        </th>
                        <th class="lt_header" width="25">id</th>
                        <th class="lt_header" width="40">Арт.</th>
                        <th class="lt_header" width="16">
                            <img src="/admin/components/shop/images/photogray.gif" border="0"/></th>
                        <th class="lt_header" width="">Название</th>
                        <th class="lt_header" width="80">Ст. цена</th>
                        <th class="lt_header" width="80"><a href="">Кол-во по складу</a></th>
                        <th class="lt_header" width="80">Цена</th>
                        <th class="lt_header" width="65">Показ</th>
                        <?php if ($category_id && sizeof($items) > 1) { ?>
                            <th class="lt_header" width="85">&darr;&uarr;</th>
                        <?php } ?>
                        <th class="lt_header" align="center" width="65">Действия</th>
                        <th class="lt_header" align="center" width="25">FixPrice</th>
                    </tr>
                    </thead>
                    <?php if ($items) { ?>
                        <tbody>
                        <?php foreach ($items as $num => $item) { ?>
                            <tr id="<?php echo $item['id']; ?>" class="item_tr">
                                <td><input type="checkbox" name="item[]" value="<?php echo $item['id']; ?>"/></td>
                                <td><?php echo $item['id']; ?></td>
                                <td><?php echo $item['art_no']; ?></td>
                                <td>
                                    <a href="#" class="itemlink">
                                        <img src="/images/markers/photo.png" border="0"/>
                                    </a>
                                    <div class="imghint">
                                        <img src="/images/photos/small/<?php echo $item['filename']; ?>"/>
                                    </div>
                                </td>
                                <td>
                                    <a href="index.php?view=components&do=config&id=<?php echo $component_id; ?>&opt=edit_item&item_id=<?php echo $item['id']; ?>">
                                        <?php echo $item['title']; ?>
                                    </a>
                                    <?php if ($item['vars']) { ?>
                                        <span style="float:right">
                                                [<a href="javascript:" style="color:#09C" onclick="$('.itemvars<?php echo $item['id']; ?>').toggle();">варианты</a>]
                                            </span>
                                        <div class="itemvars<?php echo $item['id']; ?>" style="display:none">
                                            <?php foreach ($item['vars'] as $var) { ?>
                                                <div class="var">
                                                    <span><?php echo $var['art_no']; ?> </span> - <?php echo $var['title']; ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </td>

                                <td>
                                    <input type="text" id="old_price" value="<?php echo $item['old_price']; ?>" name="old_price[<?php echo $item['id']; ?>]" class="price<?php echo $item['id']; ?>"/>
                                    <?php if ($item['vars']) { ?>
                                        <div class="itemvars<?php echo $item['id']; ?>" style="display:none">
                                            <?php foreach ($item['vars'] as $var) { ?>
                                                <input type="text" id="old_price" <?php if (!$var['is_price']) { ?>style="color:silver" onclick="varPriceClick(this, <?php echo $var['id']; ?>)" <?php } ?> value="<?php echo $var['old_price']; ?>" name="var_price[<?php echo $var['id']; ?>]" onblur="varPriceChange(this, <?php echo $item['id']; ?>, <?php echo $var['id']; ?>)"/>
                                                <input type="hidden" value="<?php echo $var['is_price']; ?>" name="var_is_price[<?php echo $var['id']; ?>]" class="var_is_price<?php echo $var['id']; ?>"/>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </td>

                                <td>
                                    <?php echo $item['qty']; ?>
                                </td>

                                <td>
                                    <input type="text" id="price" value="<?php echo $item['price']; ?>" name="price[<?php echo $item['id']; ?>]" class="price<?php echo $item['id']; ?>"/>
                                    <?php if ($item['vars']) { ?>
                                        <div class="itemvars<?php echo $item['id']; ?>" style="display:none">
                                            <?php foreach ($item['vars'] as $var) { ?>
                                                <input type="text" id="price" <?php if (!$var['is_price']) { ?>style="color:silver" onclick="varPriceClick(this, <?php echo $var['id']; ?>)" <?php } ?> value="<?php echo $var['price']; ?>" name="var_price[<?php echo $var['id']; ?>]" onblur="varPriceChange(this, <?php echo $item['id']; ?>, <?php echo $var['id']; ?>)"/>
                                                <input type="hidden" value="<?php echo $var['is_price']; ?>" name="var_is_price[<?php echo $var['id']; ?>]" class="var_is_price<?php echo $var['id']; ?>"/>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </td>

                                <td>
                                    <?php if ($item['published']) { ?>
                                        <a id="publink<?php echo $item['id']; ?>" href="javascript:pub(<?php echo $item['id']; ?>, 'view=components&do=config&id=<?php echo $component_id; ?>&opt=hide_item&item_id=<?php echo $item['id']; ?>', 'view=components&do=config&id=35&opt=show_item&item_id=<?php echo $item['id']; ?>', 'off', 'on');" title="Скрыть">
                                            <img id="pub<?php echo $item['id']; ?>" border="0" src="images/actions/on.gif"/>
                                        </a>
                                    <?php } else { ?>
                                        <a id="publink<?php echo $item['id']; ?>" href="javascript:pub(<?php echo $item['id']; ?>, 'view=components&do=config&id=<?php echo $component_id; ?>&opt=show_item&item_id=<?php echo $item['id']; ?>', 'view=components&do=config&id=35&opt=hide_item&item_id=<?php echo $item['id']; ?>', 'on', 'off');" title="Показать">
                                            <img id="pub<?php echo $item['id']; ?>" border="0" src="images/actions/off.gif"/>
                                        </a>
                                    <?php } ?>

                                    <?php if ($item['is_front']) { ?>
                                        <a id="frontlink<?php echo $item['id']; ?>" href="javascript:front(<?php echo $item['id']; ?>, 'view=components&do=config&id=<?php echo $component_id; ?>&opt=hide_item_front&item_id=<?php echo $item['id']; ?>', 'view=components&do=config&id=35&opt=show_item_front&item_id=<?php echo $item['id']; ?>', 'unfront', 'front');" title="Убрать с витрины">
                                            <img id="front<?php echo $item['id']; ?>" border="0" src="components/shop/images/front.gif"/>
                                        </a>
                                    <?php } else { ?>
                                        <a id="frontlink<?php echo $item['id']; ?>" href="javascript:front(<?php echo $item['id']; ?>, 'view=components&do=config&id=<?php echo $component_id; ?>&opt=show_item_front&item_id=<?php echo $item['id']; ?>', 'view=components&do=config&id=35&opt=hide_item_front&item_id=<?php echo $item['id']; ?>', 'front', 'unfront');" title="На витрину">
                                            <img id="front<?php echo $item['id']; ?>" border="0" src="components/shop/images/unfront.gif"/>
                                        </a>
                                    <?php } ?>

                                    <?php if ($item['is_hit']) { ?>
                                        <a id="hitlink<?php echo $item['id']; ?>" href="javascript:hit(<?php echo $item['id']; ?>, 'view=components&do=config&id=<?php echo $component_id; ?>&opt=hide_item_hit&item_id=<?php echo $item['id']; ?>', 'view=components&do=config&id=35&opt=show_item_hit&item_id=<?php echo $item['id']; ?>', 'unhit', 'hit');" title="Отменить хит">
                                            <img id="hit<?php echo $item['id']; ?>" border="0" src="components/shop/images/hit.gif"/>
                                        </a>
                                    <?php } else { ?>
                                        <a id="hitlink<?php echo $item['id']; ?>" href="javascript:hit(<?php echo $item['id']; ?>, 'view=components&do=config&id=<?php echo $component_id; ?>&opt=show_item_hit&item_id=<?php echo $item['id']; ?>', 'view=components&do=config&id=35&opt=hide_item_hit&item_id=<?php echo $item['id']; ?>', 'hit', 'unhit');" title="Хит продаж">
                                            <img id="hit<?php echo $item['id']; ?>" border="0" src="components/shop/images/unhit.gif"/>
                                        </a>
                                    <?php } ?>

                                    <?php if ($item['is_spec']) { ?>
                                        <a id="speclink<?php echo $item['id']; ?>" href="javascript:spec(<?php echo $item['id']; ?>, 'view=components&do=config&id=<?php echo $component_id; ?>&opt=hide_item_spec&item_id=<?php echo $item['id']; ?>', 'view=components&do=config&id=35&opt=show_item_spec&item_id=<?php echo $item['id']; ?>', 'unspec', 'spec');" title="Отменить акцию">
                                            <img id="spec<?php echo $item['id']; ?>" border="0" src="components/shop/images/spec.gif"/>
                                        </a>
                                    <?php } else { ?>
                                        <a id="speclink<?php echo $item['id']; ?>" href="javascript:spec(<?php echo $item['id']; ?>, 'view=components&do=config&id=<?php echo $component_id; ?>&opt=show_item_spec&item_id=<?php echo $item['id']; ?>', 'view=components&do=config&id=35&opt=hide_item_spec&item_id=<?php echo $item['id']; ?>', 'spec', 'unspec');" title="Акция">
                                            <img id="spec<?php echo $item['id']; ?>" border="0" src="components/shop/images/unspec.gif"/>
                                        </a>
                                    <?php } ?>
                                </td>
                                <?php if ($category_id && sizeof($items) > 1) { ?>
                                    <td style="display: flex;">
                                        <?php
                                        $display_move_down = ($num < sizeof($items) - 1) ? 'inline' : 'none';
                                        $display_move_up = ($num > 0) ? 'inline' : 'none';
                                        ?>
                                        <a class="move_item_down" href="javascript:void(0)" onclick="moveItem(<?php echo $item['id']; ?>, 1)" title="Подвинуть ниже" style="float:left;display:<?php echo $display_move_down; ?>"><img src="images/actions/down.gif" border="0"/></a>
                                        <a class="move_item_up" href="javascript:void(0)" onclick="moveItem(<?php echo $item['id']; ?>, -1)" title="Подвинуть выше" style="float:right;display:<?php echo $display_move_up; ?>"><img src="images/actions/top.gif" border="0"/></a>
                                    </td>
                                <?php } ?>
                                <td align="right">
                                    <div style="padding-right: 8px; display: flex;">
                                        <a title="Посмотреть на сайте" href="/shop/<?php echo $item['seolink']; ?>.html">
                                            <img border="0" hspace="2" alt="Посмотреть на сайте" src="images/actions/search.gif"/>
                                        </a>
                                        <a title="Редактировать" href="?view=components&do=config&id=<?php echo $component_id; ?>&opt=edit_item&item_id=<?php echo $item['id']; ?>">
                                            <img border="0" hspace="2" alt="Редактировать" src="images/actions/edit.gif"/>
                                        </a>
                                        <a title="Удалить" onclick="jsmsg('Удалить <?php echo $item['title']; ?>?', '?view=components&do=config&id=<?php echo $component_id; ?>&opt=delete_item&item_id=<?php echo $item['id']; ?>')" href="#">
                                            <img border="0" hspace="2" alt="Удалить" src="images/actions/delete.gif"/>
                                        </a>
                                    </div>
                                </td>
                                <td align="center">
                                    <input type="checkbox" value="1" name="fixprice">
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    <?php } else { ?>
                        <tbody>
                        <td colspan="7" style="padding-left:5px">
                            <div style="padding:15px;padding-left:0px">Товары не найдены</div>
                        </td>
                        </tbody>
                    <?php } ?>
                </table>
                <?php if ($items) { ?>

                    <div style="margin-top:4px;padding-top:4px;">
                        <table class="" cellpadding="5" border="0" height="40">
                            <tr>
                                <td width="">
                                    <strong style="color:#09C">Отмеченные:</strong>
                                </td>
                                <td width="" class="sel_pub">
                                    <input type="button" name="" value="Сохранить" onclick="sendShopForm(<?php echo $_REQUEST['id']; ?>, 'saveprices');" style="font-weight:bold"/>
                                    <input type="button" name="" value="Изменить" onclick="sendShopForm(<?php echo $_REQUEST['id']; ?>, 'edit_item');"/>
                                    <input type="button" name="" value="Перенести" onclick="$('.sel_move').toggle();$('.sel_pub').toggle();"/>
                                </td>
                                <td class="sel_move" style="display:none">
                                    Перенести в категорию
                                </td>
                                <td class="sel_move" style="display:none">
                                    <select id="move_cat_id" style="width:250px">
                                        <?php
                                        echo $inCore->getListItemsNS('cms_shop_cats', $category_id);
                                        ?>
                                    </select>
                                </td>
                                <td class="sel_move" style="display:none">
                                    <input type="button" name="" value="ОК" onclick="sendShopForm(<?php echo $_REQUEST['id']; ?>, 'move_items', $('select#move_cat_id').val(), <?php echo $category_id; ?>);"/>
                                    <input type="button" name="" value="Отмена" onclick="$('td.sel_move').toggle();$('td.sel_pub').toggle();"/>
                                </td>
                                <td class="sel_pub">
                                    <input type="button" name="" value="Показать" onclick="sendShopFormShow(<?php echo $_REQUEST['id']; ?>, <?php echo $category_id; ?>);"/>
                                    <input type="button" name="" value="Скрыть" onclick="sendShopFormHide(<?php echo $_REQUEST['id']; ?>, <?php echo $category_id; ?>);"/>
                                </td>
                                <td class="sel_pub">
                                    <input type="button" name="" value="Удалить" onclick="sendShopForm(<?php echo $_REQUEST['id']; ?>, 'delete_item');"/>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php } ?>
                <script type="text/javascript">highlightTableRows("listTable", "hoverRow", "clickedRow");</script>
                <script type="text/javascript">
                    $('a.itemlink').hover(
                        function () {
                            $(this).parent('td').find('div.imghint').fadeIn("fast");
                        },
                        function () {
                            $(this).parent('td').find('div.imghint').fadeOut("fast");
                        }
                    );
                </script>
            </form>

            <?php
            if ($pages > 1) {
                echo cmsPage::getPagebar($total, $page, $perpage, $base_uri . '&hide_cats=' . $hide_cats . '&title=' . $title_part . '&art_no=' . $art_no_part . '&orderby=' . $orderby . '&orderto=' . $orderto . '&vendor_id=' . $vendor_id . '&cat_id=' . $category_id . '&page=%page%');
            }
            ?>
        </td>
    </tr>
</table>