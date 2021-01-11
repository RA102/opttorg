{if $success}
    <h1>#{$order_id}: <span>{$LANG.SHOP_ORDER_SUCCESS}</span></h1>
{else}
    {if $accept}
        <h1>#{$order_id}: <span>{$LANG.SHOP_ORDER_ACCEPTED}</span></h1>
    {else}
        <h1>#{$order_id}: <span>{$LANG.SHOP_ORDER_FAIL}</span></h1>
    {/if}
{/if}
<div class="good-wrp">	
<p>{$message_text}</p>
{$showorders}
<br />
    <input type="button" id="continue" class="btn btn-{if $success || $accept}success{else}warning{/if} btn-lg" name="continue" class="button" value="{$LANG.CONTINUE}" onclick="window.location.href='/';" />
<br /><br />
</div>
{$orders}