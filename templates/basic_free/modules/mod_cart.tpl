{if $items_count}
    {if $cfg.showtype=='list'}
        {foreach key=cid item=item from=$items}
            <div class="{cycle values="rowa1,rowa2"}">
                <div>
                    <a class="strong" href="/catalog/item{$item.id}.html"><span class="glyphicon glyphicon-shopping-cart"></span> {$item.title}</a>
                </div>
                {if $item.itemscount == 1}
                    <div><em>&mdash; {$item.totalcost} {$LANG.CURRENCY}</em></div>
                {else}
                    <div><em>&mdash; {$item.itemscount} x {$item.price} = {$item.totalcost} {$LANG.CURRENCY}</em></div>
                {/if}
            </div>
        {/foreach}
        <div align="right" style="margin-top:20px;">
            <a href="/catalog/viewcart.html" class="btn btn-default" title="{$LANG.CART_GOTO_CART}">{$LANG.CART_SUMM}: {$total_summ} {$LANG.CURRENCY}.</a>
        </div>
    {else}
        <div class="cart_count">
            <strong>{$LANG.CART_ITEMS}:</strong> <a href="/catalog/viewcart.html" title="{$LANG.CART_GOTO_CART}">{$items_count} {$LANG.CART_QTY}</a>
        </div>
        {if $cfg.showtype == 'qtyprice'}
            <div><strong>{$LANG.CART_TOTAL}:</strong> {$total_summ} {$LANG.CURRENCY}.</div>
        {/if}
    {/if}
{else}
    <p class="text-info">{$LANG.CART_NOT_ITEMS}</p>
{/if}