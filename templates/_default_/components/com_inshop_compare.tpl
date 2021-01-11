<h1 class="con_heading">{$LANG.SHOP_COMPARE}</h1>

{if $items}

    <table cellpadding="0" cellspacing="0" border="0" class="compare_table">
        
        <tr>
            <td>&nbsp;</td>
            {foreach key=num item=item from=$items}
                <td class="item_title">
                    <a href="/shop/{$item.seolink}.html">{$item.title}</a>
                </td>
            {/foreach}
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            {foreach key=num item=item from=$items}
                <td class="item_image">
                    <a href="/shop/{$item.seolink}.html">
                        <img src="/images/photos/small/{$item.filename}" border="0" />
                    </a>
                </td>
            {/foreach}
        </tr>

        <tr>
            <td>&nbsp;</td>
            {foreach key=num item=item from=$items}
                <td>
                    <div class="compare_remove">
                        <a href="/shop/compare/remove/{$item.id}">{$LANG.SHOP_COMPARE_REMOVE}</a>
                    </div>
                </td>
            {/foreach}
        </tr>
        
        {if $cfg.compare_prices}
        <tr class="char_row">
            <td class="char_title">{$LANG.SHOP_PRICE}:</td>
            {foreach key=item_id item=item from=$items}
                <td class="char_value">{$item.price|number_format:2:".":" "} {$cfg.currency}</td>
            {/foreach}
        </tr>
        {/if}

        {foreach key=char_title item=cmp from=$cmp_chars}
            <tr class="char_row">
                <td class="char_title">{$char_title}:</td>
                {foreach key=item_id item=item from=$items}
                    <td class="char_value">{if $cmp[$item.id]}{$cmp[$item.id]}{else}&mdash;{/if}</td>
                {/foreach}
            </tr>
        {/foreach}
        
    </table>

    <script type="text/javascript">
        {literal}
            $('.compare_table tr.char_row:even').css('background-color', '#ECECEC');
        {/literal}
    </script>


{else}

    <p>{$LANG.SHOP_COMPARE_EMPTY}</p>
   
{/if}

<p>
    <br/>
    <input type="button" value="{$LANG.SHOP_BACK_TO_SHOP}" onclick="window.location.href='{$last_url}';" />
</p>