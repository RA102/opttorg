{add_js file='components/shop/js/cart.js'}

<h1 class="con_heading">
    {if $cfg.show_hit_img && $item.is_hit}<span class="is_hit">{/if}
    {$item.title}
    {if $cfg.show_hit_img && $item.is_hit}</span>{/if}
</h1>

{if $cfg.ratings}
    {add_js file='components/shop/js/rating/jquery.MetaData.js'}
    {add_js file='components/shop/js/rating/jquery.rating.js'}
    {add_css file='components/shop/js/rating/jquery.rating.css'}
    <div class="item_rating">
        <form action="/shop/rate" method="POST">
            <input type="hidden" name="item_id" value="{$item.id}" />
            <input type="hidden" name="points" value="{$item.id}" />
            {section name=rate start=1 loop=6 step=1}
                <input name="rate" type="radio" class="star" value="{$smarty.section.rate.index}" {if $item.rating>=$smarty.section.rate.index}checked="checked"{/if} {if !$is_user || $item.user_voted}disabled="disabled"{/if} />
            {/section}
        </form>
        {if $item.rating}
            <small>{$item.rating} / <span style="color:gray">{$item.rating_votes|spellcount:$LANG.SHOP_VOTES:$LANG.SHOP_VOTES2:$LANG.SHOP_VOTES10}</span></small>
        {/if}
    </div>
{/if}

<table cellpadding="0" cellspacing="0" border="0" class="shop_detail_item">
    <tr>
        <td class="image_td" valign="top">
            <div class="image">
                <img src="/images/photos/medium/{$item.filename}" border="0" />
            </div>
            {if $item.images}
                <div class="images">
                    {foreach key=num item=file from=$item.images}
                        <a href="/images/photos/medium/{$file}" class="lightbox-enabled" rel="lightbox-galery" title="{$item.title|escape:'html'} ({$LANG.SHOP_PHOTO} {$num+1})"><img src="/images/photos/small/{$file}" border="0" width="80" height="80"/></a>
                    {/foreach}
                </div>
            {/if}
        </td>
        <td class="details_td" valign="top">
            <div class="details">

                {if $cfg.show_cats}
                    <div class="cats">
                        {$LANG.SHOP_ITEM_CATS}:
                        {foreach key=num item=cat from=$item.cats}
                            <a href="/shop/{$item.cats_data[$num].seolink}">{$item.cats_data[$num].title}</a>{if $num<sizeof($item.cats)-1}, {/if}
                        {/foreach}
                    </div>
                {/if}

                {if $cfg.show_vendors && $item.vendor}
                    <div class="vendor">
                        {$LANG.SHOP_ITEM_VENDOR}: <a href="/shop/vendors/{$item.vendor_id}">{$item.vendor}</a>
                    </div>
                {/if}

                {if $cfg.show_full_desc}
                    <div class="description">{$item.description}</div>
                {/if}

                {if $item.tagline}
                    <div class="vendor">
                        {$item.tagline}
                    </div>
                {/if}

                <form action="/shop/addtocart" method="POST">

                {if $item.chars}
                    {assign var=last_grp value=""}
                    <ul class="chars_list">
                        {foreach key=num item=char from=$item.chars}
                            {if $cfg.show_char_grp}
                                {if $char.fieldgroup && ($char.fieldgroup!=$last_grp)}
                                    <li class="grp">{$char.fieldgroup}</li>
                                {/if}
                                {assign var=last_grp value=$char.fieldgroup}
                            {/if}

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

                {if $cfg.is_shop && !$item.hide_price}

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
                        <br/><div class="old_price"><span style="text-decoration:none;color:#666">Нет в наличии</span></div>
                    {/if}
                {/if}

                </form>

            </div>
        </td>
    </tr>
</table>
{if $nav}
    <div class="related">
        <h3>{$LANG.SHOP_ITEMS_NAV}:</h3>
        <div class="item_nav">
            {if $nav.prev}
                &larr; <a href="/shop/{$nav.prev.seolink}.html">{$nav.prev.title}</a>
            {/if}
            {if $nav.prev && $nav.next} | {/if}
            {if $nav.next}
                <a href="/shop/{$nav.next.seolink}.html">{$nav.next.title}</a> &rarr;
            {/if}
        </div>
    </div>
{/if}
{if $cfg.show_related && $related_items}
    <div class="related">
        <h3>{$LANG.SHOP_RELATED}:</h3>
        <table border="0" cellpadding="6">
            {foreach key=rid item=rel from=$related_items}
                <tr>
                    <td>
                        <a href="/shop/{$rel.seolink}.html">
                            <img src="/images/photos/small/{$rel.filename}" style="width:64px;max-width:64px;height:auto" title="{$rel.title}"/>
                        </a>
                    </td>
                    <td>
                        <a href="/shop/{$rel.seolink}.html">{$rel.title}</a>
                    </td>
                </tr>
            {/foreach}
        </table>
    </div>
{/if}

<script type="text/javascript">

    {if $cfg.ratings}
        {literal}
            $('.star').rating({
                callback: function(value, link){
                    $(this.form).find('input[name=points]').val(value);
                    this.form.submit();
                }
            });
        {/literal}
    {/if}

</script>