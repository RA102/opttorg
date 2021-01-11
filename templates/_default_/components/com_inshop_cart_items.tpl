{if $items}

        {add_js file='components/shop/js/cart.js'}

        <table cellpadding="0" cellspacing="0" border="0" width="99%" class="cart_table">
            {foreach key=num item=item from=$items}
                <tr>
                    <td width="70">
                        <div class="art_no">{$item.art_no}</div>
                    </td>
                    <td width="25">
                        <a href="#" class="itemlink">
                            <img src="/images/markers/photo.png" border="0"/>
                        </a>
                        <div class="imghint">
                            <img src="/images/photos/small/{$item.filename}" />
                        </div>
                    </td>
                    <td>
                        <a href="/shop/{$item.seolink}.html" class="title">{$item.title}</a>
                        {if $item.var_title}<span class="var_title"> / {$item.var_title}</span>{/if}
                        {if $item.chars}<span class="var_title"> / {$item.chars}</span>{/if}
                    </td>
                    {if !$readonly}
                        <td width="30">
                            <a href="/shop/deletefromcart/{$item.cart_id}" title="Отказаться от товара">
                                <img src="/images/icons/delete.gif" border="0" />
                            </a>
                        </td>
                        <td style="width:60px">
                            {if $cfg.qty_mode=='qty'}
                                {if $item.qty}
                                    <select name="qty[{$item.cart_id}]" style="width:50px" onchange="recountSumm()">
                                        {section name=qty loop=$item.qty step=1}
                                          <option value="{$smarty.section.qty.index+1}" {if $smarty.section.qty.index+1 == $item.cart_qty}selected="selected"{/if}>{$smarty.section.qty.index+1}</option>
                                        {/section}
                                    </select>
                                {/if}
                            {/if}
                            {if $cfg.qty_mode=='any'}
                                <input name="qty[{$item.cart_id}]" onchange="recountSumm()" style="width:50px;text-align:center" value="{if $item.cart_qty}{$item.cart_qty}{else}1{/if}" />
                            {/if}
                        </td>
                    {/if}
                    <td width="60" {if $readonly}align="center"{/if}>
                        {if $readonly}{$item.cart_qty} {/if}{if ($item.qty || $cfg.qty_mode=='any') && $cfg.qty_mode != 'one'}{$LANG.SHOP_PIECES} x {/if}
                    </td>
                    <td>
                        {if ($item.qty || $cfg.qty_mode=='any') && $cfg.qty_mode != 'one'}<span class="price"><span class="value">{$item.price}</span> {$cfg.currency}</span>{/if}
                    </td>
                    <td width="200" align="right">
                        <span class="totalprice">= <span class="value">{$item.totalprice}</span> {$cfg.currency}</span>
                    </td>
                </tr>
            {/foreach}
            <tr>
                <td><div class="art_no">&nbsp;</div></td>
                <td>&nbsp;</td>
                <td>
                    <span class="total_summ_title">
                        {$LANG.SHOP_TOTAL_SUMM}<span id="dsize" {if !$discount_size}style="display:none"{/if}>, со скидкой <span class="value">{$discount_size}</span>%</span>
                    </span>
                </td>
                {if !$readonly}
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                {/if}
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="right">
                    <span class="total_summ_price">= <span class="value">{$totalsumm}</span> {$cfg.currency}</span>
                    <input type="hidden" id="totalsumm" value="{$totalsumm}" />
                </td>
            </tr>
        </table>

        <script type="text/javascript">
            {literal}
                $('a.itemlink').hover(
                    function() {
                        $(this).parent('td').find('div.imghint').fadeIn("fast");
                    },
                    function() {
                        $(this).parent('td').find('div.imghint').fadeOut("fast");
                    }
                );
            {/literal}

            {literal}
        function calculateDiscount(totalsumm){
{/literal}

            var dis = new Array();

            {if $cfg.discount}
            {foreach key=summ item=discount from=$cfg.discount}
                dis[{$summ|intval}] = {$discount};
            {/foreach}
            {/if}

{literal}

            var discount_size = 0;

            if (isNaN(totalsumm) || totalsumm == ''){ totalsumm = 0; }

            for (var summ in dis){
                if (totalsumm >= summ) {
                    discount_size = dis[summ];
                }
            }

            if (isNaN(discount_size) || discount_size == ''){
                discount_size = 0;
            }

            if (discount_size > 0){
                totalsumm = totalsumm - (totalsumm * (discount_size/100));
                $('#dsize .value').html(discount_size);
                $('#dsize').show();
            } else {
                $('#dsize').hide();
            }

            $('.total_summ_price .value').html(totalsumm);
            $('.total_summ_price .value').fadeOut().fadeIn();

            return;

        }

{/literal}
        </script>

{/if}