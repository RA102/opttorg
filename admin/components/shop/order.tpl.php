<?php
    $status[1] = 'Принят в обработку';
    $status[2] = 'Оплачен, ждет доставки';
    $status[3] = 'Закрыт';
?>

<div class="order_info">
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td class="first">Покупатель:</td>
            <td><?php echo $order['customer_name']; ?></td>
        </tr>
        <?php if ($order['user_login']){ ?>
        <tr>
            <td class="first">Пользователь:</td>
            <td>
                <a href="<?php echo cmsUser::getProfileURL($item['user_login']); ?>"><?php echo $order['user_nickname']; ?></a>
            </td>
        </tr>
        <?php } ?>
        <?php if ($order['customer_org']){ ?>
            <tr>
                <td class="first">Организация:</td>
                <td><?php echo $order['customer_org']; ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td class="first">Телефон:</td>
            <td><?php echo $order['customer_phone']; ?></td>
        </tr>
        <tr>
            <td class="first">Адрес:</td>
            <td>
                <?php echo $order['customer_address']; ?> [<a target="_blank" style="color:#09C" href="http://maps.yandex.ru/?text=<?php echo urlencode($order['customer_address']); ?>">карта</a>]
            </td>
        </tr>
        <?php if ($order['customer_email']){ ?>
            <tr>
                <td class="first">Электронная почта:</td>
                <td>
                    <a href="mailto:<?php echo $order['customer_email']; ?>"><?php echo $order['customer_email']; ?></a>
                </td>
            </tr>
        <?php } ?>
        <?php if ($order['customer_comment']){ ?>
            <tr>
                <td class="first">Комментарий:</td>
                <td><?php echo $order['customer_comment']; ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

<div class="order_info">
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td class="first">Дата поступления:</td>
            <td><?php echo $order['date_created'] ? $order['date_created'] . '<span class="time">'.$order['time_created'].'</span>' : '&mdash;'; ?></td>
        </tr>
        <tr>
            <td class="first">Дата оплаты:</td>
            <td><?php echo $order['date_payment'] ? $order['date_payment'] . '<span class="time">'.$order['time_payment'].'</span>' : '&mdash;'; ?></td>
        </tr>
        <tr>
            <td class="first">Дата завершения:</td>
            <td><?php echo $order['date_closed'] ? $order['date_closed'] . '<span class="time">'.$order['time_closed'].'</span>'  : '&mdash;'; ?></td>
        </tr>
    </table>
</div>

<div class="order_info">
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td class="first">Статус:</td>
            <td>
                <span style="background:url(/components/shop/images/status/<?php echo $order['status']; ?>.gif) no-repeat right center; padding-right:60px">
                    <?php echo $status[$order['status']]; ?>
                </span>
            </td>
        </tr>
        <tr>
            <td class="first">Тип доставки:</td>
            <td>
                <a href="index.php?view=components&do=config&id=<?php echo $component_id; ?>&opt=edit_delivery&item_id=<?php echo $order['d_type']; ?>">
                    <?php echo $order['delivery']; ?></a> (<?php echo $order['d_price'] ? $order['d_price'] . ' '. $cfg['currency'] : 'бесплатно'; ?>)
            </td>
        </tr>
    </table>
</div>

<div class="order_items">
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <thead>
            <tr>
                <td width="30">id</td>
                <td width="50">Артикул</td>
                <td width="">Название</td>
                <td width="" colspan="6" align="center">
                    <div class="order_add_pos" style="float:right">
                        <a href="javascript:" onclick="$('#add_order_pos').show();$('.order_add_pos').hide();$('#add_art_no').focus()">Добавить позицию</a>
                    </div>
                </td>
            </tr>
        </thead>
        <tbody>
        <?php foreach($order['items'] as $id=>$item){ ?>
            <tr>
                <td width="30"><?php echo $item['item_id']; ?></td>
                <td width="50"><?php echo $item['art_no']; ?></td>
                <td width="">
                    <a href="<?php echo $component_uri; ?>&opt=edit_item&item_id=<?php echo $item['item_id']; ?>"><?php echo $item['title']; ?></a> 
                    <?php if ($item['var_title']) { echo ' // '.$item['var_title']; } ?>
                    <?php if ($item['chars']) { echo ' // '.$item['chars']; } ?>
                    <?php if ($item['load_info']){ ?>
                    <br/><small><?php echo $item['load_info']; ?></small>
                    <?php } ?>
                </td>
                <td width="30" align="right"><?php echo $item['cart_qty']; ?></td>
                <td width="15" align="center">x</td>
                <td width="50"><?php echo $item['price']; ?></td>
                <td width="15" align="center">=</td>
                <td width="50"><strong><?php echo $item['price']*$item['cart_qty']; ?></strong></td>
                <td width="70">
                    <a title="Посмотреть на сайте" href="'/shop/<?php echo $item['seolink'] ?>.html'" target="_blank">
                        <img border="0" hspace="2" alt="Просмотреть" src="images/actions/search.gif" />
                    </a>
                    <a title="Удалить позицию" onclick="jsmsg('Удалить <?php echo $item['title']; ?> из заказа?', '?view=components&do=config&id=<?php echo $component_id; ?>&opt=delete_order_item&order_id=<?php echo $order['id']; ?>&item_id=<?php echo $item['item_id']; ?>')" href="#">
                        <img border="0" hspace="2" alt="Удалить" src="images/actions/delete.gif"/>
                    </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<div id="add_order_pos" class="order_info" style="display:none">
    <form action="index.php" method="POST">
        <input type="hidden" name="view" value="components"/>
        <input type="hidden" name="do" value="config"/>
        <input type="hidden" name="id" value="<?php echo $component_id; ?>"/>
        <input type="hidden" name="opt" value="add_order_item"/>
        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>"/>
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
                <td class="" width="150">Добавить позицию:</td>
                <td width="60">Артикул: </td>
                <td width="200">
                  <input type="text" name="add_art_no" id="add_art_no" style="width:100px" />
                  <input type="button" id="btnCheckAvailableInStock" class="btn btn-default" value="Проверить" />
                  <span
                          id="hintInStock"
                          class="text-danger"
                  ></span>
                </td>
                <td width="36">
                    <a href="/admin/index.php?view=components&do=config&id=<?php echo $component_id; ?>&opt=list_items" target="_blank" title="Открыть список товаров в отдельном окне">
                        <img src="/admin/images/icons/hmenu/cats.png" border="0" />
                    </a>
                </td>
                <td width="50">Кол-во: </td>
                <td>
                  <input
                          name="add_qty"
                          type="number"
                          min="1"
                          value="1"
                          style="width:50px" />
                </td>
                <td width="100" align="right"><input type="submit" name="add_pos" value="Добавить" style="width:100px" /></td>
            </tr>
        </table>
    </form>
</div>

<div class="order_info">
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td class="first">Сумма заказа:</td>
            <td><?php echo $order['summ']; ?> <?php echo $cfg['currency']; ?></td>
        </tr>
		<?php if ($order['giftcode']) { ?>
        <tr>
            <td class="first">Процент скидки:</td>
            <td><?php echo $order['giftcode']; ?>%</td>
        </tr>
        <tr>
            <td class="first">Итого к оплате:</td>
            <td><?php $itogo = round($order['summ']-($order['summ']*$order['giftcode']/100),0); echo $itogo; ?> <?php echo $cfg['currency']; ?></td>
        </tr>
		<?php } else { ?>
        <tr>
            <td class="first">Процент скидки:</td>
            <td>0%</td>
        </tr>
        <tr>
            <td class="first">Итого к оплате:</td>
            <td><?php echo $order['summ']; ?> <?php echo $cfg['currency']; ?></td>
        </tr>		
		<?php } ?>
        <tr>
            <td class="first">Способ оплаты:</td>
            <td><?php echo $order['psys_title']; ?></td>
        </tr>		
    </table>
</div>

<div class="order_info">
    <form action="index.php" method="POST">
        <input type="hidden" name="view" value="components"/>
        <input type="hidden" name="do" value="config"/>
        <input type="hidden" name="id" value="<?php echo $component_id; ?>"/>
        <input type="hidden" name="opt" value="save_order_comment"/>
        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>"/>
        <table cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="first" valign="top" style="padding-top:7px">
                    Комментарий:<br/>
                    <span style="font-weight:normal;font-size:12px;color:gray">Для служебных заметок, показывается только вам</span>
                    <input type="submit" name="add_pos" value="Сохранить" style="width:100px;margin-top:12px;" />
                </td>
                <td>
                    <textarea name="comment" style="width:520px;height:100px"><?php echo $order['comment']; ?></textarea>
                </td>
            </tr>
        </table>
    </form>
</div>


<p>
    <input type="button" name="print" value="Распечатать заказ" onclick="window.print()" />
    <input type="button" name="back" value="Вернуться к списку заказов" onclick="window.location.href='index.php?view=components&do=config&id=<?php echo $_REQUEST['id']; ?>&opt=list_orders'" />
</p>