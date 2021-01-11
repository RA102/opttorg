{if $vendors}

    <div id="inshop_vendors_list" class="list-group">
    {foreach key=num item=vendor from=$vendors}
            {if $current_id != $vendor.id}
                <a class="list-group-item" href="/shop/vendors/{$vendor.id}">{$vendor.title}{if $vendor.items_count} <span class="badge">{$vendor.items_count}</span>{/if}</a>
            {else}
                <a class="list-group-item active" href="/shop/vendors/{$vendor.id}">{$vendor.title}{if $vendor.items_count} <span class="badge">{$vendor.items_count}</span>{/if}</a>
            {/if}
    {/foreach}
    </div>

{/if}