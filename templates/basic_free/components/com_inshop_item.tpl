<div itemscope itemtype="http://schema.org/Product">
    {add_js file='components/shop/js/cart.js'}
    {if $smarty.session.user.group_id==10}{$iprice=$item.opt}{else}{$iprice=$item.price}{/if}
    <h1 class="con_heading" itemprop="name">
        <a href="#" class="history-back hidden-lg hidden-md" onclick="history.back();">&laquo;</a> {$item.title}</h1>
    <script src="/templates/basic_free/js/jquery.maskedinput.min.js"></script>
    {if $topbanner!=''}{$topbanner}{/if}
    <div class="good-wrp">
        <form action="/shop/addtocart" method="POST">
            <div class="row">
                <div class="col-md-4 col-sm-12">
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
                <div class="col-md-8 col-sm-12">
                    <div class="chars-wrp">
                        <div class="row">

                            <div class="col-md-5 col-5 order-7" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                {if $iprice > 0}
                                    {if $cfg.is_shop && !$item.hide_price}
                                        {if !$cfg.track_qty || $qty || $qty_from_vendor}
                                            {if $item.old_price > 0}
                                                <div class="old-price">
                                                <s>{$item.old_price|number_format:0:" ":" "} {$cfg.currency}</s>
                                                </div>{/if}
                                            <meta itemprop="price" content="{$iprice}"/>
                                            <meta itemprop="priceCurrency" content="KZT"/>
                                            <meta itemprop="priceValidUntil" content="2030-12-12"/>
                                            <meta itemprop="url" content="https://sanmarket.kz/shop/{$item.seolink}.html"/>
                                            <div class="new-price">
                                                <span id="results">{$iprice|number_format:0:" ":" "}</span> {$cfg.currency}
                                            </div>
                                            <div>
                                                {if $qty > 1 }
                                                    <p class="count-item">Есть в наличии</p>
                                                {elseif $qty_from_vendor}
                                                    <p class="count-item"> Под заказ</p>
                                                {/if}
                                            </div>
                                            {if $cfg.track_qty}

                                            {/if}

                                            {if $item.kaspikz}
                                                <div class="small mt10 text-center btn-kaspi">
                                                <a rel="nofollow" target="_blank" href="{$item.kaspikz}"><img src="/templates/basic_free/img/kaspykz.png" height="48"/></a>
                                                </div>{/if}
                                            <div id="dynamic"></div>
                                            <!--<div class="h4 text-right">Оплачивайте без риска</div>
                                            <p class="text-right text-small"><strong>Наличными при получении</strong><br /> предоплата не требуется, оплачиваете заказ во время доставки</p>
                                            <p class="text-right text-small"><strong>Онлайн-оплата картой</strong><br /> Epay KKB защищает ваши платежи картами Visa и MasterCard</p>-->
                                            <div class="h4 text-right">Код товара: {$item.art_no}{if $item.ven_code}
                                                    <br/>
                                                    Код производителя: {$item.ven_code}{/if}</div>
                                            <p class="text-right text-small">
                                                <strong>При заказе по телефону</strong><br/> назовите менеджеру данный код
                                            </p>
                                            <div class="text-right">
                                                <img src="/templates/{template}/img/kaspired.jpg" class="kaspired"/>
                                                <img src="/templates/{template}/img/visa.jpg" class="visa"/>
                                                <div class="smallest">Kaspi Red 0% только в Караганде</div>
                                            </div>
                                        {else}
                                            <div class="old_price"><span class="nazakaz">На заказ</span></div>
                                            <a class="btn-oneclick" href="#" data-toggle="modal" data-target="#oneclicker">Узнать о сроках поступления</a>
                                        {/if}
										<input type="hidden" name="var_art_no" value=""/>
										<input type="hidden" name="add_to_cart_item_id" value="{$item.id}"/>
										<table cellpadding="0" cellspacing="0" border="0" width="100%" class="price_table_tab">
											<tr>
												<td>
													<div id="add_to_cart_{$item.id}">
														{if $cfg.qty_mode != 'one'}
															<div class="qty">
																<table cellpadding="0" cellspacing="0" border="0" width="100%">
																	<tr>
																		<td valign="middle" width="100">
																			{if $cfg.qty_mode=='qty'}
																				{if $item.qty}
																					<select name="qty" class="vkorz">
																						{section name=qty loop=$item.qty step=1}
																							<option value="{$smarty.section.qty.index+1}" {if $smarty.section.qty.index+1 == $item.cart_qty}selected="selected"{/if}>{$smarty.section.qty.index+1}</option>
																						{/section}
																					</select>
																				{/if}
																			{/if}
																			{if $cfg.qty_mode=='any'}
																				<input id="qtyy" name="qty" type="number" min="1" class="qty-control" value="1" oninput="change()"/>
																			{/if}
																		</td>
																		<td valign="middle">
																			<button type="submit" class="btn-vkorz btn btn-main btn-block btn-lg{if $item.is_in_cart>0} btn-disabled{/if}">{if $item.is_in_cart>0}В корзине{else}{if $item.qty!=0}В корзину{else}В корзину{/if}{/if}</button>
																		</td>
																	</tr>
																</table>
															</div>
														{else}
															<input type="submit" class="add btn-vkorz" name="addtocart" value="{$LANG.SHOP_ADD_TO_CART}"/>
														{/if}
													</div>
												</td>
											</tr>
										</table>
										<a class="btn-oneclick" href="#" data-toggle="modal" data-target="#oneclicker">Заказать в один клик!</a>

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
                            <div class="col-md-7 order-5">
                                <div class="char-div">Артикул: <span class="pull-right">{$item.art_no}</span></div>
                                {if $cfg.show_vendors && $item.vendor}
                                    <div class="char-div">Производство:
                                    <span class="pull-right" itemprop="brand">{$item.vendor}</span></div>{/if}
                                {if $item.ves>0}
                                    <div class="char-div">Вес: <span class="pull-right">{$item.ves} кг.</span>
                                    </div>{/if}
                                {if $item.vol>0}
                                    <div class="char-div">Объём:
                                    <span class="pull-right">{$item.vol} м<sup>3</sup></span></div>{/if}
                                {if $item.chars}
                                    {assign var=last_grp value=""}
                                    {foreach key=num item=char from=$item.chars}
                                        {if $char.value}
                                            {if !$char.is_custom}
                                                <div class="char-div">
                                                    {$char.title}:
                                                    <span class="pull-right">{"|"|str_replace:', ':$char.value} {if $char.units}{$char.units}{/if}</span>
                                                </div>
                                            {else}
                                                <div class="char-div">
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
                                    <br/>
                                    <article class="item-description" itemprop="description">{$item.description}</article>
                                {/if}

                            </div>

                            <div class="mobile-tocart d-lg-none d-md-none d-sm-none">
                                <div class="mob-title">
                                    <img src="/images/photos/small/{$item.filename}"/> Товар: {$item.title}{if $iprice > 0} - {$iprice|number_format:0:" ":" "} {$cfg.currency}{/if}
                                </div>
                                <table width="100%" border="0">
                                    <tr>{if $iprice > 0}
                                        <td width="50%">
                                            <button type="submit" class="btn btn-main btn-block{if $item.is_in_cart>0} btn-disabled{/if}">{if $item.is_in_cart>0}В корзине{else}{if $item.qty!=0}В корзину{else}В корзину{/if}{/if}</button>
                                        </td>{/if}
                                        <td>
                                            <a class="btn btn-whapp btn-block" href="https://wa.me/77775409927?text=Я%20заинтересован%20в%20покупке%20товара%20№{$item.art_no}%20https://sanmarket.kz/shop/{$item.seolink}.html">Заказ через Whatsapp</a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
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
<div class="modal fade" id="oneclicker" tabindex="-1" role="dialog" aria-labelledby="oneclickerLabel">
    <div class="modal-dialog modal-sm" role="document">
        <form action="" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="oneclickerLabel">{$item.title}</h4>
                </div>
                <div class="modal-body">
                    <img src="/images/photos/small/{$item.filename}" class="img-resp" style="border:#dedede 1px solid;margin-bottom:15px;" alt="{$item.title|escape:'html'} - {$item.art_no} – интернет-магазин SanMarket" itemprop="image"/>
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
                    <input type="hidden" class="form-control" name="ttl" value="{$item.title}"/>
                    <input type="hidden" class="form-control" name="arts" value="{$item.art_no}"/>
                    <input type="text" class="form-control" name="yname" placeholder="Ваше имя" required/><br/>
                    <div>
                        {*				{city_input value=$item.city name="city" width="300px"}*}
                        <input type="text" name="city" width="300px" placeholder="Город" style="color: #1A1A1A;" required>
                    </div>
                    <span class="red-text" style="font-size: 12px;">Укажите город для просчета стоимости доставки</span>
                    <br/> <input type="text" class="form-control" name="email" placeholder="email"/><br/>
                    <input type="text" id="customer_phone" class="form-control" name="ytel" placeholder="Ваш телефон" required/>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-whapp btn-block">Заказать</button>
                </div>
            </div>
        </form>
    </div>
</div>