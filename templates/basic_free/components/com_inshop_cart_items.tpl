{if $items}

    {add_js file='components/shop/js/cart.js'}
    {$totl="0"}
    <div class="row">
        <div class="p-4 mr-3 bg-white cart-left--div" style="width: 760px;">{* col-md-7 col-lg-7 col-xl-7 *}
            <ul class="media-list cart_table ">
                {foreach key=num item=item from=$items}
                    {if $smarty.session.user.group_id==10}<!-- оптовик -->{$iprice=$item.opt}{else}<!-- все остальные -->{$iprice=$item.price}{/if}
                    <li class="media">
                        <div class="media-left">
                            <a href="/shop/{$item.seolink}.html" title="{$item.art_no} / {$item.title}">
                                <img class="media-object" src="/images/photos/small/{$item.filename}"
                                     alt="{$item.art_no} / {$item.title}"/>
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="cart-items--title">
                                <a class="" href="/shop/{$item.seolink}.html" title="{$item.art_no} / {$item.title}">
                                    {$item.title}
                                </a>
                            </h4>
                            <div class="my-2">
                                <span class="text--color-blue">Код товара:{$item.art_no}</span>
                            </div>
                            <p class="trr">
                                {if !$readonly}<span>
                                    <input class="input-item-quantity" name="qty[{$item.cart_id}]" onchange="recountSumm()"
                                           value="{if $item.cart_qty}{$item.cart_qty}{else}1{/if}" type="number"/>
                                    </span>
                                {/if}

                                {if ($item.qty || $cfg.qty_mode=='any') && $cfg.qty_mode != 'one'}
                                    <span class="price">
                                    <span class="new-price">{$iprice}</span>
                                    {$cfg.currency}
                                        {if $item.old_price}
                                            <sup style="color:red;font-size:.8em;">{math equation="100-(x*100/y)" x=$iprice y=$item.old_price format="%.0f"}
                                            %</sup>
                                        {/if}
                                    </span>
                                {/if}


                                {if $readonly}
                                    {$item.cart_qty}
                                {/if}
                                {if ($item.qty || $cfg.qty_mode=='any') && $cfg.qty_mode != 'one'}
{*                                    {$LANG.SHOP_PIECES} x*}
                                {/if}

                                {if $smarty.session.user.group_id==10}<!-- оптовик -->
                                    {$tots=$iprice*$item.cart_qty}
                                    <span class="totalprice">=
                                    <span class="value">{$tots}</span>
                                    {$cfg.currency}</span>{else}<!-- все остальные --><span class="totalprice">=
                                    <span class="value">{$item.totalprice}</span>
                                    {$cfg.currency}</span>
                                {/if}
                                <div>
                                    {if !$readonly}
                                        <a href="/shop/deletefromcart/{$item.cart_id}" title="Отказаться от товара" class="">
                                            <span class="cart-remove--item">Удалить из корзины</span>
                                        </a>
                                    {/if}
                                </div>

                            </p>
                        </div>
                    </li>
                    {$totl=$totl+$tots}
                {/foreach}
            </ul>
        </div>
        <div class="bg-white cart-right--div" style="width: 360px;"> {* col-12 col-sm-12 col-md-4 col-lg-4 clo-xl-4 *}
            <div class="cart_form">
                <input type="button" name="go_order" class="btn btn-main" value="Продолжить оформление &rarr;"
                       onclick="$('#cart_form').submit()"/>
            </div>
            <table class="">
                <tr class="igogo">
                    <td class="hidden-xs">
                        <h4><span class="total_summ_title">
                        {$LANG.SHOP_TOTAL_SUMM}<span id="dsize" {if !$discount_size}style="display:none"{/if}>, со скидкой <span
                                            class="value">{$discount_size}</span>%</span>
                    </span></h4>
                        <input type="hidden" name="giftcode" value="{$discount_size}"/>
                    </td>
                    {if $smarty.session.user.group_id==10}
                        <td align="right">
                            <h4><span class="total_summ_price">&nbsp;= <span
                                            class="value">{$totl}</span> {$cfg.currency}</span>
                                <input type="hidden" id="totalsumm" value="{$totl}"/></h4>
                        </td>
                    {else}
                        <td align="right">
                            <h4>
                            <span class="total_summ_price">&nbsp;= <span
                                        class="value">{$totalsumm}</span> {$cfg.currency}</span>
                                <input type="hidden" id="totalsumm" value="{$totalsumm}"/></h4>
                        </td>
                    {/if}
                </tr>
            </table>

        </div>
    </div>
    <script type="text/javascript">
        {literal}
        $('a.itemlink').hover(
            function () {
                $(this).parent('td').find('div.imghint').fadeIn("fast");
            },
            function () {
                $(this).parent('td').find('div.imghint').fadeOut("fast");
            }
        );
        {/literal}

        {literal}
        function calculateDiscount(totalsumm) {
            {/literal}

            var dis = new Array();

            {if $cfg.discount}
            {foreach key=summ item=discount from=$cfg.discount}
            dis[{$summ|intval}] = {$discount};
            {/foreach}
            {/if}

            {literal}

            var discount_size = 0;

            if (isNaN(totalsumm) || totalsumm == '') {
                totalsumm = 0;
            }

            for (var summ in dis) {
                if (totalsumm >= summ) {
                    discount_size = dis[summ];
                }
            }

            if (isNaN(discount_size) || discount_size == '') {
                discount_size = 0;
            }

            if (discount_size > 0) {
                totalsumm = totalsumm - (totalsumm * (discount_size / 100));
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