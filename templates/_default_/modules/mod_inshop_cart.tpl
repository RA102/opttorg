{if !$items}
    <p>{$LANG.SHOP_CART_EMPTY}</p>
{/if}

{if $items}

    {if $cfg.showtype=='qty' || $cfg.showtype=='qtyprice'}

        <p>
            <a href="/shop/cart.html" style="font-weight:bold">{$LANG.SHOP_CART_ITEMS_QTY}:</a> {$items_count}</p>
        {if $cfg.showtype=='qtyprice'}
            <p><strong>{$LANG.SHOP_TOTAL_SUMM}:</strong> {$totalsumm} {$shop_cfg.currency}</p>
        {/if}

    {/if}

    {if $cfg.showtype=='list'}
        <ul class="mod_inshop_cart_list">
            {foreach key=num item=item from=$items}
                <li>
                    <a href="/shop/cart.html" title="{$LANG.SHOP_GO_TO_CART}">{$item.title}</a>
                    {if $cfg.showqty}&mdash; {$item.cart_qty} {$LANG.SHOP_PIECES}{/if}
                </li>
            {/foreach}
        </ul>

        <div class="mod_inshop_cart_total">
           <span>{$LANG.SHOP_TOTAL_SUMM}:</span> {$totalsumm} {$shop_cfg.currency}<br/>
           <a href="/shop/order.html" style="font-size:14px;font-weight:bold">Оформить заказ</a>
        </div>


    {/if}

{/if}