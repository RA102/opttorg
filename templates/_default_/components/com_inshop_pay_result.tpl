{if $success}
    <h1 class="con_heading">{$LANG.SHOP_ORDER_SUCCESS}</h1>
{else}
    {if $accept}
        <h1 class="con_heading">{$LANG.SHOP_ORDER_ACCEPTED}</h1>
    {else}
        <h1 class="con_heading">{$LANG.SHOP_ORDER_FAIL}</h1>
    {/if}
{/if}

<p>{$message_text}</p>

<p style="margin-top:25px">
    <input type="button" id="continue" name="continue" class="button" value="{$LANG.CONTINUE}" onclick="window.location.href='/';" />
</p>