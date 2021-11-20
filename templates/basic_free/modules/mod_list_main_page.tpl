{* Мобильное меню (убрать) *}
<div class="position-relative mb-5">
    <div class="d-block d-sm-block d-md-block d-lg-block d-xl-none mobile-menu">
        <div class="item-menu text-center">
            <a href="/shop">
                <img src="/templates/basic_free/images/menu-mobile/catalog.png" alt="" width="60">
                <span class="text-center d-block" style="font-size: 24px; line-height: 22px;">Каталог</span>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="/shop/akcii">
                <img src="/templates/basic_free/images/menu-mobile/stock.png" alt="" width="60">
                <span class="text-center d-block" style="font-size: 24px; line-height: 22px;">Акции</span>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="/shop/smesiteli">
                <img src="/templates/basic_free/images/menu-mobile/shower.png" alt="" width="60">
                <span class="text-center d-block" style="font-size: 24px; line-height: 22px;">Душевые</span>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="/shop/vanny">
                <img src="/templates/basic_free/images/menu-mobile/bath.png" alt="" width="60">
                <span class="text-center d-block" style="font-size: 24px; line-height: 22px;">Ванны</span>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="/shop/mebel-dlja-vannoi">
                <img src="/templates/basic_free/images/menu-mobile/pedestal.png" alt="" width="60">
                <span class="text-center d-block" style="font-size: 24px; line-height: 22px;">Мебель<br />для ванной</span>
            </a>
        </div>

        <div class="item-menu text-center">
            <a href="/shop/smesiteli">
                <img src="/templates/basic_free/images/menu-mobile/mixer.png" alt="" width="60">
                <span class="text-center d-block" style="font-size: 24px; line-height: 22px;">Смесители</span>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="/shop/aksessuary">
                <img src="/templates/basic_free/images/menu-mobile/accessories.png" alt="" width="60">
                <p class="text-center d-block" style="font-size: 24px; line-height: 22px;">Аксессуары</p>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="/shop/unitazy-i-bide">
                <img src="/templates/basic_free/images/menu-mobile/toilet.png" alt="" width="60">
                <span class="text-center d-block" style="font-size: 24px; line-height: 22px;">Унитазы<br />и биде</span>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="/shop/umyvalniki-dlja-vannoi">
                <img src="/templates/basic_free/images/menu-mobile/sink.png" alt="" width="60">
                <span class="text-center d-block" style="font-size: 24px; line-height: 22px;">Умывальники <br>для ванной</span>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="/shop/moiki-dlja-kuhni">
                <img src="/templates/basic_free/images/menu-mobile/sink-kitchen.png" alt="" width="60">
                <span class="text-center d-block" style="font-size: 24px; line-height: 22px;">Мойки<br>для кухни</span>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="/shop/polotencesushiteli">
                <img src="/templates/basic_free/images/menu-mobile/heated-towel-rail.png" alt="" width="60">
                <p class="text-center d-block" style="font-size: 24px; line-height: 22px;">Полотенце<br> сушители</p>
            </a>
        </div>

        <div class="item-menu text-center">
            <a href="/shop/vodonagrevateli">
                <img src="/templates/basic_free/images/menu-mobile/boiler.png" alt="" width="60">
                <p class="text-center d-block" style="font-size: 24px; line-height: 22px;">Нагреватели</p>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="/shop/komplektuyuschie">
                <img src="/templates/basic_free/images/menu-mobile/yet.png" alt="" width="60">
                <p class="text-center d-block" style="font-size: 24px; line-height: 22px;">Компле<br />ктующие</p>
            </a>
        </div>

    </div>
</div>
{* end mobile menu *}
{foreach from=$listItems key=category item=items}
    <section class="row no-gutters">
        <div class="col-12">
            <h2 class="category-main-page">{$category}</h2>
        </div>

        {foreach from=$items item=item}
            <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3 item mb-3">
                <div class="thumb">
                    <a href="/shop/{$item->seolink}.html" title="{$item->title}" class="">
                        <img class="img-fluid img-thumbnail list-item-img" style="height: auto; max-width: 100%; object-fit: cover;" src="/images/photos/small/shop{$item->id}.jpg"  alt="{$item->title}"/>
                    </a>
                    <div class="capt">
                        <a href="/shop/{$item->seolink}.html" title="{$item->title}" data-truncate="2" style="word-break: break-all;">{$item->title}</a>
                    </div>
                    <div class="pricer">
                        {if $item->old_price}
                            <s>{$item->old_price|number_format:0:' ':' '}</s>{/if}
                        <div{if $item->old_price} class="color_red"{/if}>
                            {if $iprice>0}{$iprice|number_format:0:' ':' '} тг.
                            {else}<span>{$item->price|number_format:0:' ':' '} тг.</span>
                            {/if}
                        </div>
                    </div>
{*                    <form action="/shop/addtocart" method="POST">*}
{*                        <input type="hidden" name="add_to_cart_item_id" value="{$item->id}"/>*}
{*                        <div class="text-center">*}
{*                            <button type="submit" class="btn btn-main add-basket{if $item->is_in_cart>0} btn-disabled {elseif $item->price==0}  btn-gray{/if}">{if $item->is_in_cart>0}В корзине{else}{if $item->qty!=0}В корзину{else}В корзину{/if}{/if}</button>*}
{*                        </div>*}
{*                    </form>*}
                    <div class="flex flex-column justify-content-center align-items-center">
                        {if $item->qty > 1 || $item->qty_from_vendor > 1}
                            <form action="/shop/addtocart" method="GET">
                                <input type="hidden" name="add_to_cart_item_id" value="{$item->id}" />
                                <div class="text-center">
                                    <button type="submit" class="btn btn-main add-basket{if $item->is_in_cart>0} btn-disabled{elseif $item->price==0}  btn-gray{/if}">{if $item->is_in_cart>0}В корзине{else}{if $item->price==0}Цену уточняйте{else}В корзину{/if}{/if}</button>
                                </div>
                                <a class="btn-oneclick text-nowrap px-2" href="#" data-toggle="modal" data-target="#oneclicker" data-art-no="{$item->art_no}" data-title="{$item->title}" data-seolink="/shop/{$item->seolink}.html" data-img="/images/photos/small/shop{$item->id}.jpg" data-price="{$item->price|number_format:0:' ':' '} тг">Заказ в один клик!</a>
                            </form>
                        {else}
                            <a class="btn-oneclick" href="#" data-toggle="modal" data-target="#oneclicker" data-art-no="{$item->art_no}" data-title="{$item->title}" data-seolink="/shop/{$item->seolink}.html" data-img="/images/photos/small/shop{$item->id}.jpg" data-price="{$item->price|number_format:0:' ':' '} тг">Узнать о сроках поступления</a>
                        {/if}
                    </div>
                </div>
            </div>
        {/foreach}
    </section>
{/foreach}

{* Modal One'cLick *}
<div class="modal fade" id="oneclicker" tabindex="-1" role="dialog" aria-labelledby="oneclickerLabel">
    <div class="modal-dialog modal-sm" role="document">
        <form id="form-order-oneclick" action="/" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="oneclickerLabel">{$item->title}</h4>
                </div>
                <div class="modal-body">
                    <img id="oneClickImg" class="img-fluid" src="/images/photos/small/shop{$item->id}.jpg" style="border:#dedede 1px solid;margin-bottom:15px;" alt="{$item->title|escape:'html'} - {$item->art_no} – интернет-магазин SanMarket" itemprop="image"/>
                    <table width="100%" border="0">
                        <tr>
                            <td valign="middle" width="80">
                                <input style="width:80px !important;" class="form-control" id="qtyy1" name="qtyy1" type="number" min="1" value="1" oninput="change1()"/>
                            </td>
                            <td valign="middle" class="text-right">
                                <strong><span id="results1">{$iprice|number_format:0:" ":" "}</span> {$cfg->currency}
                                </strong></td>
                        </tr>
                    </table>
                    <br/> <input type="hidden" class="form-control" name="price1" value="{$iprice}"/>
                    <input type="hidden" name="seolink" value="{$item->seolink}">
                    <input type="hidden" name="ttl" value="{$item->title}"/>
                    <input type="hidden" name="arts" value="{$item->art_no}"/>
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
                    <button id="btn-order-submit" class="btn btn-whapp btn-block" type="submit" >Заказать</button>
                </div>
            </div>
        </form>
    </div>
</div>

{* End modal One click *}

