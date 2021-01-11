{if $vendors}

    <div id="inshop_vendors_list">
    {foreach key=num item=vendor from=$vendors}
        <div class="vendor">
            {if $current_id != $vendor.id}
                <a href="/shop/vendors/{$vendor.id}">{$vendor.title}</a>
            {else}
                {$vendor.title}
            {/if}
        </div>
    {/foreach}
    </div>

{/if}