<div class="position-relative mb-5">
    <div class="visible-md visible-sm visible-xs hidden-lg mobile-menu">
        <div class="item-menu text-center">
            <a href="/shop">
                <img src="/templates/basic_free/images/menu-mobile/catalog.png" alt="" width="80">
                <span class="text-center d-block" style="font-size: 24px; line-height: 22px;">Каталог</span>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="/">
                <img src="/templates/basic_free/images/menu-mobile/stock.png" alt="" width="80">
                <span class="text-center d-block" style="font-size: 24px; line-height: 22px;">Акции</span>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="/shop/smesiteli">
                <img src="/templates/basic_free/images/menu-mobile/shower.png" alt="" width="80">
                <span class="text-center d-block" style="font-size: 24px; line-height: 22px;">Душевые</span>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="/shop/vanny">
                <img src="/templates/basic_free/images/menu-mobile/bath.png" alt="" width="80">
                <span class="text-center d-block" style="font-size: 24px; line-height: 22px;">Ванны</span>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="">
                <img src="/templates/basic_free/images/menu-mobile/pedestal.png" alt="" width="80">
                <span class="text-center d-block" style="font-size: 24px; line-height: 22px;">Мебель</span>
            </a>
        </div>

        <div class="item-menu text-center">
            <a href="">
                <img src="/templates/basic_free/images/menu-mobile/mixer.png" alt="" width="80">
                <span class="text-center d-block" style="font-size: 24px; line-height: 22px;">Смесители</span>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="">
                <img src="/templates/basic_free/images/menu-mobile/toilet.png" alt="" width="80">
                <span class="text-center d-block" style="font-size: 24px; line-height: 22px;">Унитазы<br />и биде</span>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="">
                <img src="/templates/basic_free/images/menu-mobile/sink.png" alt="" width="80">
                <span class="text-center d-block" style="font-size: 24px; line-height: 22px;">Раковины <br>для ванной</span>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="">
                <img src="/templates/basic_free/images/menu-mobile/sink-kitchen.png" alt="" width="80">
                <span class="text-center d-block" style="font-size: 24px; line-height: 22px;">Мойки <br>для куни</span>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="">
                <img src="/templates/basic_free/images/menu-mobile/heated-towel-rail.png" alt="" width="80">
                <p class="text-center d-block" style="font-size: 24px; line-height: 22px;">Полотенце<br> сушители</p>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="">
                <img src="/templates/basic_free/images/menu-mobile/accessories.png" alt="" width="80">
                <p class="text-center d-block" style="font-size: 24px; line-height: 22px;">Аксессуары</p>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="">
                <img src="/templates/basic_free/images/menu-mobile/boiler.png" alt="" width="80">
                <p class="text-center d-block" style="font-size: 24px; line-height: 22px;">Нагреватели</p>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="">
                <img src="/templates/basic_free/images/menu-mobile/yet.png" alt="" width="80">
                <p class="text-center d-block" style="font-size: 24px; line-height: 22px;">Еще</p>
            </a>
        </div>

    </div>
</div>

{foreach from=$listItems key=category item=items}
    <div class="row no-gutters">
        <div class="col-12">
            <h2 class="category-main-page">{$category}</h2>
        </div>

        {foreach from=$items item=item}
            <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
                <div class="thumb">
                    <a href="/shop/{$item->seolink}.html" title="{$item->title}" class="">
                        <img  src="/images/photos/small/shop{$item->id}.jpg" class="img-fluid list-item-img" alt="{$item->title}"/>
                    </a>
                    <div class="capt">
                        <a href="/shop/{$item->seolink}.html" title="{$item->title}" data-truncate="2" style="word-break: break-all;">{$item->title}</a>
                    </div>
                    <div class="pricer">
                        {if $item->old_price}
                            <s>{$item->old_price|number_format:0:' ':' '}</s>{/if}
                        <div{if $item->old_price} class="color_red"{/if}>{if $iprice>0}{$iprice|number_format:0:' ':' '} тг.{else}<span>{$item->price|number_format:0:' ':' '} тг.</span>{/if}</div>
                    </div>
                    <form action="/shop/addtocart" method="POST">
                        <input type="hidden" name="add_to_cart_item_id" value="{$item->id}"/>
                        <div class="text-center">
                            <button type="submit" class="btn btn-main add-basket{if $item->is_in_cart>0} btn-disabled {elseif $item->price==0}  btn-gray{/if}">{if $item->is_in_cart>0}В корзине{else}{if $item->qty!=0}В корзину{else}В корзину{/if}{/if}</button>
                        </div>
                    </form>
                </div>
            </div>
        {/foreach}
    </div>
{/foreach}
