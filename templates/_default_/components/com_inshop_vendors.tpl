<h1 class="con_heading">{$LANG.SHOP_VENDORS}</h1>

{if $vendors}
    <div class="shop_vendors_list">
        {foreach key=num item=vendor from=$vendors}
            <div class="vendor">
                <a href="/shop/vendors/{$vendor.id}">{$vendor.title}</a> {if $vendor.items_count}<span>{$vendor.items_count}</span>{/if}
            </div>
        {/foreach}
    </div>
{/if}