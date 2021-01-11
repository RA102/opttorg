{if $orders}
    <div class="p_orders">
    {foreach key=id item=order from=$orders}
<form {if $order.comment==1}action="/kvit.php?id={$order.id}"{/if} method="post">
<input type="hidden" name="order_id" value="{$order.id}" />
<input type="hidden" name="date_created" value="{$order.date_created}" />
<input type="hidden" name="dogovor" value="{$order.dogovor}" />
<input type="hidden" name="org_name" value="{$order.customer_org|escape:'html'}" />
<input type="hidden" name="org_adr" value="{$order.customer_address|escape:'html'}" />
<input type="hidden" name="bin_iin" value="{$order.customer_inn|escape:'html'}" />
<input type="hidden" name="summ" value="{$order.summ}" />
<input type="hidden" name="dostavka_sum" value="{$order.dostavka_sum}" />
        <div class="order">
            <div class="show_items pull-right">
                <a href="javascript:" onclick="{literal}${/literal}(this).hide();{literal}${/literal}('div[class=items][rel={$order.id}]').slideDown('fast')">Показать товары</a>
            </div>		
            <div class="strong">Заказ №{$order.id} от {$order.date_created} на сумму {$order.summ} {$cfg.currency} {if $order.dogovor} Договор: {$order.dogovor}{/if}</div>
            <div style="margin:7px 0;">
                <span>Статус:</span> {$status[$order.status]}
                {if $order.date_payment}
                    | <span class="date">Оплата:</span> {$order.date_payment}
                {/if}
                {if $order.date_closed}
                    | <span class="date">Завершен:</span> {$order.date_closed}
                {/if}
				{if !$order.date_closed}
				{if $order.comment==1}
					| <input type="submit" value="Квитанция на оплату" />
				{elseif $order.comment==2}
					| <a href="https://epay.kkb.kz/demo" target="_blank">Перейти к оплате Visa</a>
				{elseif $order.comment==3}
					| <a href="https://qiwi.kz" target="_blank">Перейти к оплате QIWI</a> 
				{else}
					| Обрабатывается менеджером, подождите
				{/if}
				{/if}
            </div>

            <div class="items" rel="{$order.id}" style="display: none">
				<div class="table-responsive">
                <table class="table table-bordered">
					{$col="1"}
                    {foreach key=item_id item=item from=$order.items}
					
					
                    <tr>
                        <td width="50">{$item.art_no}</td>
                        <td width="">
                           <!-- <a href="/shop/{$item.seolink}.html" target="_blank">-->{$item.title} {if $item.var_title}//{$item.var_title}{/if}<!--</a>-->
                        </td>
                        <td width="30" align="right">{$item.cart_qty}</td>
                        <td width="15" align="center">x</td>
                        <td width="50">{$item.price}</td>
                        <td width="15" align="center">=</td>
                        <td width="100"><strong>{math equation="x*y" x=$item.price y=$item.cart_qty}</strong> тг.</td>
                        </td>
                    </tr>
					<input type="hidden" name="art_no{$col}" value="{$item.art_no}" />
					<input type="hidden" name="title{$col}" value="{$item.title|escape:'html'}{if $item.var_title} - {$item.var_title|escape:'html'}{/if}" />
					<input type="hidden" name="cart_qty{$col}" value="{$item.cart_qty}" />
					<input type="hidden" name="price{$col}" value="{$item.price}" />
					{$total=$item.price*$item.cart_qty}
					<input type="hidden" name="total{$col}" value="{$total}" />
					{$col=$col+1}
                    {/foreach}
					<input type="hidden" name="col" value="{$col}" />
                </table>
				</div>
            </div>
        </div>
</form>
    {/foreach}
    </div>
{else}
	<p class="text-danger">Вы пока не совершали заказов в нашем магазине.</p>
{/if}