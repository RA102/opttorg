{if $items}

    {if $cfg.ratings}
        {add_js file='components/shop/js/rating/jquery.MetaData.js'}
        {add_js file='components/shop/js/rating/jquery.rating.js'}
        {add_css file='components/shop/js/rating/jquery.rating.css'}
    {/if}

    {add_js file='components/shop/js/cart.js'}

    <div class="shop_items_sort">
        <span>{$LANG.SHOP_SORT_BY}:</span>
        {foreach key=t item=type from=$order_types}
            {if $type.selected}
                <a href="/shop/sort/{$type.order}/{if $orderto=='asc'}desc{else}asc{/if}" class="selected">
                    {$type.name}
                    {if $orderto=='asc'}&darr;{else}&uarr;{/if}</a>
            {else}
                <a href="/shop/sort/{$type.order}/asc">{$type.name}</a>
            {/if}
            {if $t<3}|{/if}
        {/foreach}
    </div>
    <div class="shop_items_list">

        {foreach key=num item=item from=$items}

            <table cellpadding="0" cellspacing="0" border="0" class="shop_item">
                <tr>
                    {if $cfg.show_thumb}
                    <td valign="top" class="image_td">
                        <div class="image">
                            <a href="/shop/{$item.seolink}.html">
                                <img src="/images/photos/small/{$item.filename}" border="0" />
                                {if $cfg.show_hit_img && $item.is_hit}<div class="is_hit"></div>{/if}
                            </a>
                            {if $cfg.ratings}
                                <div class="rating">
                                    <form action="/shop/rate" method="POST">
                                        <input type="hidden" name="item_id" value="{$item.id}" />
                                        <input type="hidden" name="points" value="{$item.id}" />
                                        {section name=rate start=1 loop=6 step=1}
                                            <input name="rate" type="radio" class="star" value="{$smarty.section.rate.index}" {if $item.rating>=$smarty.section.rate.index}checked="checked"{/if} {if !$is_user || $item.user_voted}disabled="disabled"{/if} />
                                        {/section}
                                    </form>
                                    {if $item.rating}
                                        <small>{$item.rating}</small>
                                    {/if}
                                </div>
                            {/if}
                        </div>
                    </td>
                    {/if}
                    <td valign="top" class="details_td">
                        <div class="details">
                            <div class="title">
                                <a href="/shop/{$item.seolink}.html">{$item.title}</a>
                                {if $cfg.show_vendors && $item.vendor}/ <a href="/shop/vendors/{$item.vendor_id}" class="vendor">{$item.vendor}</a>{/if}
                                {if $cfg.show_compare}
                                    <span class="compare">
                                        {if !$item.is_in_compare}
                                        <a class="add" href="/shop/compare/{$item.id}">{$LANG.SHOP_COMPARE_ADD}</a>
                                        {else}
                                        {$LANG.SHOP_COMPARE_ITEM_IN} <a href="/shop/compare.html">{$LANG.SHOP_COMPARE_IN}</a>
                                        {/if}
                                    </span>
                                {/if}
                            </div>

                            {if $cfg.show_desc}
                            <div class="desc">{$item.shortdesc}</div>
                            {/if}

                            <form action="/shop/addtocart" method="POST">

                            {if $item.chars}
                                <ul class="chars_list">
                                    {foreach key=num item=char from=$item.chars}
                                        {if $char.value}
                                            {if !$char.is_custom}
                                                <li>
                                                    <span class="quest">{$char.title}:</span>
                                                    <span class="answer">{"|"|str_replace:', ':$char.value} {if $char.units}{$char.units}{/if}</span>
                                                </li>
                                            {else}
                                                <li>
                                                    <span class="quest">{$char.title}:</span>
                                                    <span class="answer">
                                                        <select name="chars[{$char.id}]">
                                                            {foreach key=c item=val from=$char.items}
                                                                <option value="{$val}">{$val}</option>
                                                            {/foreach}
                                                        </select>
                                                    </span>
                                                </li>
                                            {/if}
                                        {/if}
                                    {/foreach}
                                </ul>
                            {/if}

                            {if $cfg.is_shop && !$root_cat.is_catalog}

                                {if !$cfg.track_qty || $item.qty>0}

                                        <input type="hidden" name="add_to_cart_item_id" value="{$item.id}" />
                                        <table cellpadding="0" cellspacing="0" border="0" height="34" class="price_table">
                                            <tr>
                                                {if $item.old_price > 0}
                                                    <td style="padding-right:0px">
                                                        <div class="old_price"><span>{$item.old_price} {$cfg.currency}</span></div>
                                                    </td>
                                                    <td width="16" style="padding-right:0px">
                                                        <img src="/components/shop/images/shop_arrow.gif" border="0" />
                                                    </td>
                                                {/if}
                                                {if !$item.vars}
                                                    <td>
                                                        <div class="price"><span>{$item.price} {$cfg.currency}</span></div>
                                                        <input type="hidden" name="var_art_no" value="" />
                                                    </td>
                                                {else}
                                                    <td>
                                                        <select name="var_art_no" class="var_art_no">
                                                            {foreach key=num item=var from=$item.vars}
                                                                {if $var.qty>0}
                                                                    <option value="{$var.art_no}">{$var.title} &mdash; {$var.price} {$cfg.currency}</option>
                                                                {/if}
                                                            {/foreach}
                                                        </select>
                                                    </td>
                                                {/if}
                                                <td>
                                                    <div id="add_to_cart_{$item.id}">
                                                        {if $cfg.qty_mode != 'one'}
                                                            <div class="qty" style="display:none">
                                                                <table cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td>{$LANG.SHOP_CART_ADD_QTY}</td>
                                                                        <td>
                                                                            {if $cfg.qty_mode=='qty'}
                                                                                {if $item.qty}
                                                                                    <select name="qty" style="width:50px">
                                                                                        {section name=qty loop=$item.qty step=1}
                                                                                          <option value="{$smarty.section.qty.index+1}" {if $smarty.section.qty.index+1 == $item.cart_qty}selected="selected"{/if}>{$smarty.section.qty.index+1}</option>
                                                                                        {/section}
                                                                                    </select>
                                                                                {/if}
                                                                            {/if}
                                                                            {if $cfg.qty_mode=='any'}
                                                                                <input name="qty" style="width:50px;text-align:center" value="1" />
                                                                            {/if}
                                                                        </td>
                                                                        <td><input type="submit" value="{$LANG.SHOP_ADD}" /></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <input type="button" onclick="addToCart({$item.id})" class="add" name="addtocart" value="{$LANG.SHOP_ADD_TO_CART}" />
                                                        {else}
                                                            <input type="submit" class="add" name="addtocart" value="{$LANG.SHOP_ADD_TO_CART}" />
                                                        {/if}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>

                                {else}
                                    <div class="old_price"><span style="text-decoration:none;color:#666">Нет в наличии</span></div>
                                {/if}
                            {/if}

                            </form>

                        </div>
                    </td>
                </tr>
            </table>

        {/foreach}

    </div>
    {if $pages>1}
        <div class="shop_pages">
            {$pagebar}
        </div>
    {/if}

    {if $cfg.ratings}
        <script type="text/javascript">
        {literal}
            $('.star').rating({
                callback: function(value, link){
                    $(this.form).find('input[name=points]').val(value);
                    this.form.submit();
                }
            });
        {/literal}
        </script>
    {/if}

{/if}
