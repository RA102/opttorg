{if $orders}
    <div class="p_orders">
    {foreach key=id item=order from=$orders}

        <div class="order">
            <div class="head">Заказ №{$order.id} от {$order.date_created} на сумму {$order.summ} {$cfg.currency}</div>
            <div class="data">
                <span>Статус:</span> {$status[$order.status]}
                <span class="date">Cоздан:</span> {$order.date_created}
                {if $order.date_payment}
                    <span class="date">Оплата:</span> {$order.date_payment}
                {/if}
                {if $order.date_closed}
                    <span class="date">Завершен:</span> {$order.date_closed}
                {/if}
            </div>
            <div class="show_items">
                <a href="javascript:" onclick="{literal}${/literal}(this).hide();{literal}${/literal}('div[class=items][rel={$order.id}]').slideDown('fast')">Показать товары</a>
            </div>
            <div class="items" rel="{$order.id}" style="display: none">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    {foreach key=item_id item=item from=$order.items}
                    <tr>
                        <td width="50">{$item.art_no}</td>
                        <td width="">
                            {$item.title} {if $item.var_title}//{$item.var_title}{/if}
                        </td>
                        <td width="30" align="right">{$item.cart_qty}</td>
                        <td width="15" align="center">x</td>
                        <td width="50">{$item.price}</td>
                        <td width="15" align="center">=</td>
                        <td width="50"><strong>{math equation="x*y" x=$item.price y=$item.cart_qty}</strong></td>
                        </td>
                    </tr>
                    {/foreach}
                </table>

            </div>
        </div>

    {/foreach}
    </div>
{else}
	<p>Вы пока не совершали заказов в нашем магазине.</p>
{/if}