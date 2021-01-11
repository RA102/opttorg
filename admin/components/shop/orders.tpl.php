<?php if(!defined('VALID_CMS_ADMIN')) { die('ACCESS DENIED'); } ?>

<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top:2px">
    <tr>
        <td valign="top" style="width:130px;<?php if ($hide_cats){ ?>display:none;<?php } ?>" id="cats_cell">

            <div class="cat_link">
                <div>
                    <?php if ($status>0) { ?>
                        <a href="<?php echo $base_uri; ?>&status=0" style="font-weight:bold">Открытые</a>
                    <?php } else { $current_cat = 'Открытые заказы'; ?>
                        Открытые
                    <?php } ?>
                </div>
            </div>
            <?php foreach($cats as $cat_status=>$title) { ?>
                <div class="cat_link">
                    <div>
                        <?php if ($status != $cat_status) { ?>
                            <a href="<?php echo $base_uri.'&status='.$cat_status; ?>"><?php echo $title; ?></a>
                        <?php } else { ?>
                            <?php echo $title; $current_cat = $title . ' заказы'; ?>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </td>

        <td valign="top" id="slide_cell" class="<?php if ($hide_cats){ ?>unslided<?php } ?>" onclick="$('#cats_cell').toggle();$(this).toggleClass('unslided');$('#filter_form input[name=hide_cats]').val(1-$('#cats_cell:visible').length)">
            &nbsp;
        </td>

        <td valign="top" style="padding-left:2px">

            <form action="<?php echo $base_uri; ?>" method="GET" id="filter_form">
                <input type="hidden" name="view" value="components" />
                <input type="hidden" name="do" value="config" />
                <input type="hidden" name="id" value="<?php echo $component_id; ?>" />
                <input type="hidden" name="opt" value="list_orders" />
                <input type="hidden" name="status" value="<?php echo $status; ?>" />
                <input type="hidden" name="hide_cats" value="<?php echo $hide_cats; ?>" />
                <table class="toolmenu" cellpadding="5" border="0" width="100%" style="margin-bottom: 2px;height:41px;">
                    <tr>
                        <td width="">
                            <span style="font-size:16px;color:#0099CC;font-weight:bold;">
                                <?php echo $current_cat; ?>
                            </span>                            
                        </td>
                        <td width="190" align="right">
                            Обновлять список каждые
                        </td>
                        <td width="55">
                            <select name="refresh_sec" style="width:55px" onchange="$('#filter_form').submit()">
                                <option value="300" <?php if($refresh_sec==300) { echo 'selected="selected"'; } ?>>5</option>
                                <option value="600" <?php if($refresh_sec==600) { echo 'selected="selected"'; } ?>>10</option>
                                <option value="900" <?php if($refresh_sec==900) { echo 'selected="selected"'; } ?>>15</option>
                                <option value="1800" <?php if($refresh_sec==1800) { echo 'selected="selected"'; } ?>>30</option>
                                <option value="3600" <?php if($refresh_sec==3600) { echo 'selected="selected"'; } ?>>60</option>
                            </select>
                        </td>
                        <td width="20">
                            минут
                        </td>
                    </tr>
                </table>
                <table class="toolmenu" cellpadding="5" border="0" width="100%" style="margin-bottom: 2px;" id="filterpanel">
                    <tr>
                        <td width="190">
                            <select name="orderby" style="width:190px" onchange="$('#filter_form').submit()">
                                <option value="date_created" <?php if($orderby=='date_start'){ ?>selected="selected"<?php } ?>>по дате поступления</option>
                                <option value="date_payment" <?php if($orderby=='date_payment'){ ?>selected="selected"<?php } ?>>по дате оплаты</option>
                                <option value="date_closed" <?php if($orderby=='date_closed'){ ?>selected="selected"<?php } ?>>по дате закрытия</option>
                                <option value="id" <?php if($orderby=='id'){ ?>selected="selected"<?php } ?>>по id</option>
                                <option value="customer_name" <?php if($orderby=='customer_name'){ ?>selected="selected"<?php } ?>>по имени покупателя</option>
                                <option value="summ" <?php if($orderby=='summ'){ ?>selected="selected"<?php } ?>>по cумме</option>
                            </select>
                        </td>
                        <td width="150">
                            <select name="orderto" style="width:150px" onchange="$('#filter_form').submit()">
                                <option value="asc" <?php if($orderto=='asc'){ ?>selected="selected"<?php } ?>>по возрастанию</option>
                                <option value="desc" <?php if($orderto=='desc'){ ?>selected="selected"<?php } ?>>по убыванию</option>
                            </select>
                        </td>
                        <td width="60">Покупатель:</td>
                        <td width="">
                            <input type="text" name="customer_name" value="<?php echo $customer_name; ?>" style="width:99%"/>
                        </td>
                        <td width="30">
                            <input type="submit" name="filter" value=">>" style="width:30px"/>
                        </td>
                    </tr>
                </table>
            </form>

            <table id="listTable" class="tablesorter" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top:0px">
                <thead>
                    <tr>
                        <th class="lt_header" width="25">id</th>
                        <th class="lt_header" width="">Покупатель</th>
                        <th class="lt_header" width="70">Создан</th>
                        <th class="lt_header" width="70">Оплачен</th>
                        <th class="lt_header" width="70">Закрыт</th>
                        <th class="lt_header" width="55">Статус</th>
                        <th class="lt_header" width="50">Товаров</th>
                        <th class="lt_header" width="70">Сумма</th>
                        <th class="lt_header" align="center" width="65">Действия</th>
                    </tr>
                </thead>
                <?php if ($items){ ?>
                    <tbody>
                        <?php foreach($items as $num=>$item){ ?>
                            <tr id="<?php echo $item['id']; ?>" class="item_tr">
                                <td><?php echo $item['id']; ?></td>
                                <td>
                                    <div>
                                        <a style="font-weight:bold;font-size:14px;" href="?view=components&do=config&id=<?php echo $component_id; ?>&opt=edit_order&item_id=<?php echo $item['id']; ?>"><?php echo $item['customer_name']; ?></a>
                                    </div>
                                    <div class="customer_info">
                                        <?php if ($item['user_id']) { ?>
                                            <span class="user">
                                                <a href="<?php echo cmsUser::getProfileURL($item['user_login']); ?>"><?php echo $item['user_nickname']; ?></a>
                                            </span>
                                        <?php } ?>
                                        <?php if ($item['customer_phone']) { ?>
                                            <span class="phone"><?php echo $item['customer_phone']; ?></span>
                                        <?php } ?>
                                        <?php if ($item['customer_address']) { ?>
                                            <span class="address">
                                                <?php echo $item['customer_address']; ?>
                                                [<a target="_blank" style="color:#09C" href="http://maps.yandex.ru/?text=<?php echo urlencode($item['customer_address']); ?>">карта</a>]
                                            </span>
                                        <?php } ?>
                                    </div>
                                </td>
                                <td><?php echo $item['date_created'] == date('d.m.Y') ? '<strong>Сегодня</strong> '.$item['time_created'] : $item['date_created']; ?></td>
                                <td>
                                    <?php if ($item['date_payment']){ ?>
                                        <?php echo $item['date_payment']; ?>
                                    <?php } else { ?>
                                        <form action="<?php echo $component_uri.'&opt=set_order_status&status=2&order_id='.$item['id']; ?>" method="post">
                                            <input type="hidden" name="secret_key" value="<?php echo $item['secret_key']; ?>" />
                                            <input type="submit" value="Оплачен" title="Отметить оплату заказа" />
                                        </form>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($item['date_closed']){ ?>
                                        <?php echo $item['date_closed']; ?>
                                    <?php } else { ?>
                                        <form action="<?php echo $component_uri.'&opt=set_order_status&status=3&order_id='.$item['id']; ?>" method="post">
                                            <input type="hidden" name="secret_key" value="<?php echo $item['secret_key']; ?>" />
                                            <input type="submit" value="Закрыть" title="Отметить выполнение заказа"/>
                                        </form>
                                    <?php } ?>
                                </td>
                                <td><img src="/components/shop/images/status/<?php echo $item['status']; ?>.gif" border="0" /></td>
                                <td><?php echo sizeof($item['items']); ?></td>
                                <td><?php echo $item['summ']; ?></td>
                                <td align="right">
                                    <div style="padding-right: 8px;">
                                        <a title="Просмотр" href="?view=components&do=config&id=<?php echo $component_id; ?>&opt=edit_order&item_id=<?php echo $item['id']; ?>">
                                            <img border="0" hspace="2" alt="Просмотр" src="components/shop/images/values.gif"/>
                                        </a>
                                        <a title="Удалить" onclick="jsmsg('Удалить заказ #<?php echo $item['id']; ?>?', '?view=components&do=config&id=<?php echo $component_id; ?>&opt=delete_order&item_id=<?php echo $item['id']; ?>')" href="#">
                                            <img border="0" hspace="2" alt="Удалить" src="images/actions/delete.gif"/>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                <?php } else { ?>
                    <tbody>
                        <td colspan="9" style="padding-left:5px"><div style="padding:15px;padding-left:0px">Заказы не найдены</div></td>
                    </tbody>
                <?php } ?>
            </table>

            <script type="text/javascript">highlightTableRows("listTable","hoverRow","clickedRow");</script>

            
            <?php
                if ($pages>1){
                    echo cmsPage::getPagebar($total, $page, $perpage, $base_uri.'&hide_cats='.$hide_cats.'&customer_name='.$customer_name.'&orderby='.$orderby.'&orderto='.$orderto.'&status='.$status.'&page=%page%');
                }
            ?>
        </td>
    </tr>
</table>