<h1 class="con_heading">{$LANG.SHOP_CART}</h1>

{if $items}

    <form action="/shop/order.html" method="post" id="cart_form">
        
        {include file='com_inshop_cart_items.tpl'}

        <div class="cart_form">
            <input type="button" name="back" value="{$LANG.SHOP_BACK_TO_SHOP}" onclick="window.location.href='{$last_url}';" />
            <input type="button" name="go_order" value="{$LANG.SHOP_GO_ORDER}" onclick="$('#cart_form').submit()" />
        </div>

    </form>

{else}

    <p>{$LANG.SHOP_CART_EMPTY}</p>
    <p><input type="button" name="back" value="{$LANG.SHOP_BACK_TO_SHOP}" onclick="window.location.href='{$last_url}';" /></p>

{/if}
