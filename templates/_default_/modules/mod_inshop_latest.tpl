{if $items}

    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="mod_inshop_front">
        {assign var="col" value="1"}
        {foreach key=tid item=item from=$items}
            {if $col==1} <tr> {/if}
				<td valign="top" width="{$colwidth}%">

                    <div class="item_wrap">

                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td height="200">
                                    {if $cfg.show_title}
                                    <div class="title">
                                        <a href="/shop/{$item.seolink}.html">{$item.title}</a>
                                    </div>
                                    {/if}
                                    <div class="image">
                                        <a href="/shop/{$item.seolink}.html" title="{$item.title}">
                                            <img src="/images/photos/small/{$item.filename}" border="0"/>
                                            {if $cfg.show_hit_img && $item.is_hit}<div class="is_hit"></div>{/if}
                                        </a>
                                    </div>                                    
                                </td>
                            </tr>
                            {if $shop_cfg.is_shop && $item.price}
                            <tr>
                                <td height="40">
                                    <div class="price"><span>{$item.price} {$shop_cfg.currency}</span></div>
                                </td>
                            </tr>
                            {/if}
                        </table>
                    </div>

				</td>
				{if $col==$cfg.cols} </tr> {assign var="col" value="1"} {else} {math equation="x + 1" x=$col assign="col"} {/if}
			{/foreach}
			{if $col>1}
				<td colspan="{math equation="x - y + 1" x=$col y=$cfg.cols}">&nbsp;</td></tr>
			{/if}
    </table>

{/if}