<h1 class="con_heading">{$vendor.title}</h1>

{if $items}

    {include file='com_inshop_items.tpl'}

{else}

    <p>{$LANG.SHOP_VENDOR_NO_ITEMS}</p>

{/if}