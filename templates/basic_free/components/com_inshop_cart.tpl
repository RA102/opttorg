<h1 class="con_heading"><span>{$LANG.SHOP_CART}</span></h1>
<div style="margin-bottom:20px;">
    {if $items}
        <form id="cart_form" action="/shop/order.html" method="post" >
                {include file='com_inshop_cart_items.tpl'}

{*            <div class="clearfix" style="height:10px;"></div>*}
            <input type="button" name="back" class="btn btn-not-main" value="&larr; Вернуться в магазин" onclick="window.location.href='{$last_url}';"/>
        </form>
    {else}
        <p>{$LANG.SHOP_CART_EMPTY}</p>
        <input type="button" name="back" class="btn btn-not-main" value="{$LANG.SHOP_BACK_TO_SHOP}"
               onclick="window.location.href='{$last_url}';"/>
    {/if}
</div>