<h1 class="con_heading"><span>{$LANG.SHOP_CART}</span></h1>
<div style="background:#fff;padding:15px;margin-bottom:20px;">
{if $items}

    <form action="/shop/order.html" method="post" id="cart_form">
        
        {include file='com_inshop_cart_items.tpl'}
<div class="clearfix" style="height:10px;"></div>
        <div class="cart_form">
            <input type="button" name="back" class="btn btn-not-main" value="&larr; Вернуться в магазин" onclick="window.location.href='{$last_url}';" />
            <input type="button" name="go_order" class="btn btn-main" value="Продолжить оформление &rarr;" onclick="$('#cart_form').submit()" /> 
        </div>

    </form>

{else}

    <p>{$LANG.SHOP_CART_EMPTY}</p>
    <input type="button" name="back" class="btn btn-not-main" value="{$LANG.SHOP_BACK_TO_SHOP}" onclick="window.location.href='{$last_url}';" />

{/if}
</div>