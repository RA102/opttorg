<div itemscope itemtype="http://schema.org/Product">
    {add_js file='components/shop/js/cart.js'}
    {if $smarty.session.user.group_id==10}{$iprice=$item.opt}{else}{$iprice=$item.price}{/if}
        <a href="#" class="history-back hidden-lg hidden-md" onclick="history.back();">&laquo;</a>
    <script src="/templates/basic_free/js/jquery.maskedinput.min.js"></script>
    {if $topbanner!=''}{$topbanner}{/if}
    <div class="good-wrp">
        <form action="/shop/addtocart" method="POST">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                    <div class="thumb-cat">
                        <a id="itemimage" href="/images/photos/medium/{$item.filename}" class="lightbox-enabled" rel="lightbox-galery" title="{$item.title|escape:'html'} - {$item.art_no}">
                            <img src="/images/photos/small/{$item.filename}" class="img-fluid" alt="{$item.title|escape:'html'} - {$item.art_no} – интернет-магазин SanMarket" itemprop="image"/>{if $item.old_price>0}
                            {assign var="disco" value=((100-($iprice*100/$item.old_price))|ceil)}
                            <div class="ribbon-lt"><span>Скидка {$disco}%</span></div>{/if}
                            {if $item.novinka==1}
                                <div class="ribbon-rt"><span>Новинка</span></div>
                            {/if}
                            {if $item.is_hit}
                                <div class="ribbon-rb"><span>Хит</span></div>
                            {/if}
                            {if $item.is_spec}
                                <div class="ribbon-lb"><span>Акция</span></div>
                            {/if}</a>
                    </div>

                    {if $item.images}
                        <div class="additional-gird">
                            <ul class="additional-gird-list">
                                {foreach key=num item=file from=$item.images}
                                    <li>
                                        <a href="/images/photos/medium/{$file}" class="lightbox-enabled" rel="lightbox-galery" title="{$item.title|escape:'html'} - {$item.art_no}, фото {$num+1}">
                                            <img src="/images/photos/small/{$file}" class="img-fluid" alt="{$item.title|escape:'html'} - {$item.art_no}, фото {$num+1} - интернет-магазин SanMarket"/>
                                        </a>
                                    </li>
                                {/foreach}
                            </ul>
                        </div>
                    {/if}

                    <!--
                    <div class="h4">Поделитесь этим товаром</div>
                    <p class="text-small">Сохраните ссылку на товар в Вашем аккаунте в любимой соцсети, чтобы не потерять!</p>
                    <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                    <script src="//yastatic.net/share2/share.js"></script>
                    <div class="ya-share2 yashasha" data-services="vkontakte,facebook,odnoklassniki,moimir,whatsapp,skype,telegram" data-counter=""></div>
                    -->
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 ">
                    {$item.sell_warehouse}
                    1
                    <div class="chars-wrp">
                        <div class="row mb-lg-3 mb-md-3">
                            <div class="col-12 border-bottom px-0">
                                <h1 class="item--title con_heading" itemprop="name">{$item.title}</h1>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 order-0 col-sm-12 order-sm-0 col-md-12 order-md-0 col-lg-5 order-lg-7 col-xl-5 order-xl-7 pl-0" itemprop="offers" itemscope itemtype="http://schema.org/Offer">

                                {if $iprice > 0}
                                    {if $cfg.is_shop && !$item.hide_price}
                                        {if $cfg.track_qty}
                                            {if $item.old_price > 0}
                                                <div class="old-price">
                                                    <s>{$item.old_price|number_format:0:" ":" "} {$cfg.currency}</s>
                                                </div>
                                            {/if}
                                            <meta itemprop="price" content="{$iprice}"/>
                                            <meta itemprop="priceCurrency" content="KZT"/>
                                            <meta itemprop="priceValidUntil" content="2030-12-12"/>
                                            <meta itemprop="url" content="https://sanmarket.kz/shop/{$item.seolink}.html"/>
                                            <div class="new-price">
                                                <span id="results">{$iprice|number_format:0:" ":" "}</span> {$cfg.currency}
                                            </div>

                                            <div class="text-right text--color-blue">
                                                <div class="col-12">
                                                    <span class="mr-1 font-weight-bold">Код товара:</span> <span>{$item.art_no}</span>
                                                </div>
                                                <div class="col-12">
                                                    <span class="mr-1 font-weight-bold">Код производителя:</span> <span>{$item.ven_code}</span>
                                                </div>

                                            </div>
                                            <p class="text-right text-small">
                                                <strong>При заказе по телефону</strong><br/> назовите менеджеру данный код
                                            </p>
                                           {if {$item.qty|intval} > 1 && {$item.sell_warehouse} == 1}
                                                <p class="text-right">
                                                    <u class="count-item text-green">Есть в наличии</u>
                                                </p>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div id="add_to_cart_{$item.id}">
                                                            {if $cfg.qty_mode != 'one'}
                                                                <div class="qty text-right text-sm-right text-md-right">

                                                                    {if $cfg.qty_mode=='qty'}
                                                                        {if $item.qty}
                                                                            <select name="qty" class="vkorz">
                                                                                {section name=qty loop=$item.qty step=1}
                                                                                    <option value="{$smarty.section.qty.index+1}"
                                                                                            {if $smarty.section.qty.index+1 == $item.cart_qty}selected="selected"{/if}>{$smarty.section.qty.index+1}</option>
                                                                                {/section}
                                                                            </select>
                                                                        {/if}
                                                                    {/if}
                                                                    {if $cfg.qty_mode=='any'}
                                                                        <div class="d-inline-block">
                                                                            <div class="position-relative">
                                                                                <input
                                                                                        id="qtyy"
                                                                                        class="input-item-quantity"
                                                                                        name="qty"
                                                                                        type="number"
                                                                                        min="1"
                                                                                        value="1"
                                                                                        oninput="change()"
                                                                                />
                                                                                <div class="inputItemCount__top"></div>
                                                                                <div class="inputItemCount__bottom"></div>
                                                                            </div>
                                                                        </div>
                                                                    {/if}
                                                                    <div class="d-inline-block">
                                                                        <button type="submit" class="btn-vkorz btn btn-main btn-block btn-lg{if $item.is_in_cart>0} btn-disabled{/if}">{if $item.is_in_cart>0}В корзине{else}{if $item.qty!=0}В корзину{else}В корзину{/if}{/if}</button>
                                                                    </div>

                                                                </div>
                                                            {else}
                                                                <input type="submit" class="add btn-vkorz" name="addtocart" value="{$LANG.SHOP_ADD_TO_CART}"/>
                                                            {/if}
                                                        </div>
                                                    </div>
                                                </div>
                                                <a class="btn-oneclick ml-auto" href="#" data-toggle="modal" data-target="#oneclicker" >Заказать в один клик!</a>
                                                {if $item.kaspikz}
                                                    <div class="small mt10 text-center btn-kaspi">
                                                    <a rel="nofollow" target="_blank" href="{$item.kaspikz}"><img src="/templates/basic_free/img/kaspykz.png" height="48"/></a>
                                                    </div>
                                                {/if}


                                           {elseif {$item.qty_from_vendor|intval} > 1 && {$item.sell_to_order} == 1}
                                                <p class="text-right">
                                                    <u class="count-item text-yellow">Под заказ</u>
                                                </p>
                                               <p class="text-right">
                                                   <u class="text-green">Срок доставки:
                                                       {$item.time_delivery}
                                                        {if $item.time_delivery == 1}
                                                            день.
                                                        {elseif $item.time_delivery == 2 || $item.time_delivery == 3 || $item.time_delivery == 4}
                                                            дня.
                                                        {else}
                                                            дней.
                                                        {/if}
                                                   </u>
                                               </p>

                                                <a class="btn-oneclick ml-auto" href="#" data-toggle="modal" data-target="#oneclicker" >Заказать в один клик!</a>
                                           {elseif $item.qty <= 1 && $item.qty_from_vendor <= 1}
                                               <div class="bg-danger text-white text-right py-2 ml-auto px-1" style="max-width: 250px">
                                                   <u class="count-item">Нет в наличии</u>
                                               </div>
                                            {/if}
                                            <input type="hidden" name="var_art_no" value=""/>
                                            <input type="hidden" name="add_to_cart_item_id" value="{$item.id}"/>

                                            <div id="dynamic"></div>

                                                <div class="text-right">
                                                    <img src="/templates/{template}/img/kaspired.jpg" class="kaspired"/>
                                                    <img src="/templates/{template}/img/visa.jpg" class="visa"/>
                                                    <div class="smallest">Kaspi Red 0% только в Караганде</div>
                                                </div>

                                        {/if}

                                    {/if}

                                {else}
                                    <div class="alert alert-warning">
                                        К сожалению, данный товар временно недоступен для заказа онлайн!
                                    </div>
                                {/if}
                                <div class="average text-right">{section name=foos start=1 loop=6 step=1}
                                    <span class="glyphicon glyphicon-star"{if $item.rating < $smarty.section.foos.index} style="color:lightgray"{/if}></span>{/section}
                                    <br/><a href="#cmms" class="cmmlink">({$item.rating_votes|spellcount:'отзыв':'отзыва':'отзывов'})</a>
                                </div>

                                <link itemprop="availability" href="http://schema.org/InStock"/>
                            </div>
                            <div class="col-12 order-0 col-sm-12 order-sm-0 col-md-12 order-md-0 col-lg-7 order-lg-5 col-xl-7 order-xl-5 pl-0 text--color-blue">
                                <div class="d-flex justify-content-between">
                                    <span class="">Артикул:</span>
                                    <span class="">{$item.art_no}</span>
                                </div>
                                {if $cfg.show_vendors && $item.vendor}
                                    <div class="d-flex justify-content-between">
                                        <span class="">Производство:</span>
                                        <span class="" itemprop="brand">{$item.vendor}</span>
                                    </div>
                                {/if}
                                {if $item.ves>0}
                                    <div class="d-flex justify-content-between">
                                        <span class="">Вес:</span>
                                        <span class="">{$item.ves} кг.</span>
                                    </div>
                                {/if}
                                {if $item.vol>0}
                                    <div class="d-flex justify-content-between">
                                        <span class="">Объём:</span>
                                        <span class="">{$item.vol} м<sup>3</sup></span>
                                    </div>
                                {/if}
                                {if $item.chars}
                                    {assign var=last_grp value=""}
                                    {foreach key=num item=char from=$item.chars}
                                        {if $char.value}
                                            {if !$char.is_custom}
                                                <div class="d-flex justify-content-between">
                                                    <span>{$char.title}:</span>
                                                    <span class="">{"|"|str_replace:', ':$char.value} {if $char.units}{$char.units}{/if}</span>
                                                </div>
                                            {else}
                                                <div class="d-flex justify-content-between">
                                                    <select name="chars[{$char.id}]">
                                                        {foreach key=c item=val from=$char.items}
                                                            <option value="{$val}">{$char.title}: {$val}</option>
                                                        {/foreach}
                                                    </select>
                                                </div>
                                            {/if}
                                        {/if}
                                    {/foreach}
                                {/if}
                                {if $item.description}
                                    <article class="item-description" itemprop="description">{$item.description}</article>
                                {/if}

                            </div>

                            {if $item.qty > 1 || $item.qty_from_vendor > 1}
                            <div class="mobile-tocart d-lg-none d-md-none d-sm-none">
                                <div class="mob-title">
                                    <img class="img-fluid" src="/images/photos/small/{$item.filename}"/> Товар: {$item.title}{if $iprice > 0} - {$iprice|number_format:0:" ":" "} {$cfg.currency}{/if}
                                </div>
                                <table width="100%" border="0">
                                    <tbody>
                                    <tr>
                                        <td width="50%">
                                            {if $iprice > 0}
                                                <button type="submit" class="btn btn-main btn-block{if $item.is_in_cart>0} btn-disabled{/if}" >{if $item.is_in_cart>0}В корзине{else}{if $item.qty!=0}В корзину{else}В корзину{/if}{/if}</button>
                                            {/if}
                                        </td>
                                        <td>
                                            <a class="btn btn-whapp btn-block" href="https://wa.me/77775409927?text=Я%20заинтересован%20в%20покупке%20товара%20№{$item.art_no}%20https://sanmarket.kz/shop/{$item.seolink}.html">Заказ через Whatsapp</a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
        </form>
        {if $sims}
            <div class="h3 main-color">С этим товаром также покупают:</div>
            <br/>
            <div class="row">
                {foreach key=tid item=sim from=$sims}
                    {if $smarty.session.user.group_id==10}{$sprice=$sim.opt}{else}{$sprice=$sim.price}{/if}
                    <div class="col-md-3 col-sm-6">
                        <div class="media">
                            <a class="pull-left" href="/shop/{$sim.seolink}.html" title="{$sim.title}"><img src="/images/photos/small/shop{$sim.id}.jpg" class="media-object" width="64" height="64" alt="{$sim.title}"/></a>
                            <div class="media-body">
                                <a class="media-heading" href="/shop/{$sim.seolink}.html" data-truncate="2">{$sim.title|truncate:50}</a>
                                <br/>

                                <p>{if $sim.old_price}
                                        <s>{$sim.old_price|number_format:0:" ":" "}</s>{/if} {$sprice|number_format:0:" ":" "} тг.
                                </p>
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>
        {/if}
        <div class="h3 main-color">Ещё в данной рубрике:</div>
        <br/>
        <div class="row">
            {foreach key=tid item=rel from=$rels}
                {if $smarty.session.user.group_id==10}{$sprice=$rel.opt}{else}{$sprice=$rel.price}{/if}
                <div class="col-md-3 col-sm-6">
                    <div class="media">
                        <a class="pull-left" href="/shop/{$rel.seolink}.html" title="{$rel.title}"><img src="/images/photos/small/shop{$rel.id}.jpg" class="media-object" width="64" height="64" alt="{$rel.title}"/></a>
                        <div class="media-body">
                            <a class="media-heading" href="/shop/{$rel.seolink}.html" data-truncate="2">{$rel.title|truncate:50}</a>
                            <br/>

                            <p>{if $rel.old_price}
                                    <s>{$rel.old_price|number_format:0:" ":" "}</s>{/if} {$sprice|number_format:0:" ":" "} тг.
                            </p>
                        </div>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
</div>
<script src="/templates/{template}/js/readmore.js"></script>
{literal}
<script>
    function change() {
        var temp = document.getElementById('qtyy').value;
        document.getElementById('results').innerHTML = temp * {/literal}{$iprice}{literal};
    }
</script>
<script>
    function change1() {
        var temp = document.getElementById('qtyy1').value;
        document.getElementById('results1').innerHTML = temp * {/literal}{$iprice}{literal};
    }
</script>
    <script>
        $('article').readmore({
            maxHeight: 240,
            moreLink: '<a href="#"><div>&darr; Раскрыть &darr;</div></a>',
            lessLink: '<a href="#"><div>&uarr; Скрыть &uarr;</div></a>'
        });
    </script>

{/literal}
<!-- Modal -->
<div class="modal" id="oneclicker" tabindex="-1" role="dialog" aria-labelledby="oneclickerLabel">
    <div class="modal-dialog modal-sm" role="document">
        <form action="" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="oneclickerLabel">{$item.title}</h4>
                </div>
                <div class="modal-body">
                    <img src="/images/photos/small/{$item.filename}" class="img-fluid" style="border:#dedede 1px solid;margin-bottom:15px;" alt="{$item.title|escape:'html'} - {$item.art_no} – интернет-магазин SanMarket" itemprop="image"/>
                    <table width="100%" border="0">
                        <tr>
                            <td valign="middle" width="80">
                                <input style="width:80px !important;" class="form-control" id="qtyy1" name="qtyy1" type="number" min="1" value="1" oninput="change1()"/>
                            </td>
                            <td valign="middle" class="text-right">
                                <strong><span id="results1">{$iprice|number_format:0:" ":" "}</span> {$cfg.currency}
                                </strong></td>
                        </tr>
                    </table>
                    <br/> <input type="hidden" class="form-control" name="price1" value="{$iprice}"/>
                    <input type="hidden" name="seolink" value="{$item.seolink}"/>
                    <input type="hidden" name="ttl" value="{$item.title}"/>
                    <input type="hidden" name="arts" value="{$item.art_no}"/>
                    <input type="hidden" name="seolink" value="/shop/{$item.seolink}.html"/>
                    <input class="form-control" type="text" name="yname" placeholder="Ваше имя" required/><br/>
                    <div>
                        {* city_input value=$item.city name="city" width="300px" *}

                        <input class="form-control" type="text" name="city" width="300px" placeholder="Город" style="color: #1A1A1A;" required>
                    </div>
                    <span class="red-text" style="font-size: 12px;">Укажите город для просчета стоимости доставки</span>
                    <br/> <input class="form-control" type="text"  name="email" placeholder="email"/><br/>
                    <input id="customer_phone" class="form-control" type="text"  name="ytel" placeholder="Ваш телефон" required/>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-whapp btn-block">Заказать</button>
                </div>
            </div>
        </form>
    </div>
</div>
