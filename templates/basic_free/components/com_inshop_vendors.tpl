<h1 class="con_heading">{$LANG.SHOP_VENDORS}</h1>

{if $vendors}
    <div class="list-group">
        {foreach key=num item=vendor from=$vendors}
                <a href="/shop/vendors/{$vendor.id}" class="list-group-item">{$vendor.title} {if $vendor.items_count}<span class="badge">{$vendor.items_count}</span>{/if}</a>
        {/foreach}
    </div>
{/if}