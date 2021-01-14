<div class="h3 text-center act_tovary hidden-md hidden-sm hidden-xs hidden-lg">Акционные товары</div>
<ul class="nav nav-tabs hidden-md hidden-sm hidden-xs hidden-lg menu-lg" role="tablist">
    <li role="presentation" class="active">
        <a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">{$cfg.esd1}</a>
    </li>
    <li role="presentation">
        <a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">{$cfg.esd2}</a>
    </li>
    <li role="presentation">
        <a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab">{$cfg.esd3}</a>
    </li>
    <li role="presentation">
        <a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab">{$cfg.esd4}</a>
    </li>
    <li role="presentation">
        <a href="#tab5" aria-controls="tab5" role="tab" data-toggle="tab">{$cfg.esd5}</a>
    </li>
</ul>
<div class="position-relative mb-5">
    <div class="visible-md visible-sm visible-xs hidden-lg mobile-menu">
        <div class="item-menu text-center">
            <a href="/shop">
                <img src="/templates/basic_free/images/menu-mobile/catalog_button.png" alt="" width="80">
                <p class="text-center" style="font-size: 24px;">Каталог</p>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="/akcii">
                <img src="/templates/basic_free/images/menu-mobile/stoсk_button.png" alt="" width="80">
                <p class="text-center" style="font-size: 24px;">Акции</p>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="/shop/smesiteli">
                <img src="/templates/basic_free/images/icon_menu/mixer.svg" alt="" width="80">
                <p class="text-center" style="font-size: 24px;">Смесители</p>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="/shop/vanny">
                <img src="/templates/basic_free/images/menu-mobile/bath_button.png" alt="" width="80">
                <p class="text-center" style="font-size: 24px;">Ванны</p>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="">
                <img src="/templates/basic_free/images/menu-mobile/toulet_bowl_button.png" alt="" width="80">
                <p class="text-center" style="font-size: 24px;">Унитазы</p>
            </a>
        </div>

        <div class="item-menu text-center">
            <a href="">
                <img src="/templates/basic_free/images/menu-mobile/catalog_button.png" alt="" width="80">
                <p class="text-center" style="font-size: 24px;">Каталог</p>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="">
                <img src="/templates/basic_free/images/menu-mobile/stoсk_button.png" alt="" width="80">
                <p class="text-center" style="font-size: 24px;">Акции</p>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="">
                <img src="/templates/basic_free/images/menu-mobile/fauсent_button.png" alt="" width="80">
                <p class="text-center" style="font-size: 24px;">Смесители</p>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="">
                <img src="/templates/basic_free/images/menu-mobile/bath_button.png" alt="" width="80">
                <p class="text-center" style="font-size: 24px;">Ванны</p>
            </a>
        </div>
        <div class="item-menu text-center">
            <a href="">
                <img src="/templates/basic_free/images/menu-mobile/toulet_bowl_button.png" alt="" width="80">
                <p class="text-center" style="font-size: 24px;">Унитазы</p>
            </a>
        </div>

    </div>
</div>
{*Товары на главной*}
<div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="tab1">
        <div class="row no-gutters">
            {foreach key=tid item=sd from=$sd1}
                {if $smarty.session.user.group_id==10}
                    {$iprice=$sd.opt}
                {else}
                    {$iprice=$sd.price}
                {/if}
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <div class="thumb">
                        <a href="/shop/{$sd.seolink}.html" title="{$sd.title}" class="imgthumb">
                            <img src="/images/photos/small/shop{$sd.id}.jpg" class="img-resp" alt="{$sd.title}"/>
                            {if $sd.old_price>0}
                                {assign var="disco" value=((100-($iprice*100/$sd.old_price))|ceil)}
                                <div class="ribbon-lt"><span>Скидка {$disco}%</span></div>{/if}
                            {if $sd.novinka==1}
                                <div class="ribbon-rt"><span>Новинка</span></div>
                            {/if}
                            {if $sd.is_hit}
                                <div class="ribbon-rb"><span>Хит</span></div>
                            {/if}
                            {if $sd.is_spec}
                                <div class="ribbon-lb"><span>Акция</span></div>
                            {/if}
                            {if $sd.kaspikz}
                                <img src="/templates/basic_free/img/bankaspiski1.png" class="bankaspiski"/>
                            {/if}
                        </a>
                        <div class="capt"><a href="/shop/{$sd.seolink}.html" title="{$sd.title}"
                                             data-truncate="2">{$sd.title}</a></div>
                        <div class="pricer">                        {if $sd.old_price}
                                <s>{$sd.old_price|number_format:0:' ':' '}</s>{/if}
                            <div{if $sd.old_price} class="color_red"{/if}>{if $iprice>0}{$iprice|number_format:0:' ':' '} тг.{else}&nbsp;{/if}</div>
                        </div>
                        <form action="/shop/addtocart" method="POST">
                            <input type="hidden" name="add_to_cart_item_id" value="{$sd.id}"/>
                            <div class="text-center">
                                <button type="submit" class="btn btn-main add-basket{if $sd.is_in_cart>0} btn-disabled {elseif $sd.price==0}  btn-gray{/if}">{if $sd.is_in_cart>0}В корзине{else}{if $sd.qty!=0}В корзину{else}В корзину{/if}{/if}</button>
                            </div>
                        </form>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="tab2">
        <div class="row no-gutters">        {foreach key=tid item=sd from=$sd2}        {if $smarty.session.user.group_id==10}{$iprice=$sd.opt}{else}{$iprice=$sd.price}{/if}
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <div class="thumb"><a href="/shop/{$sd.seolink}.html" title="{$sd.title}" class="imgthumb"><img
                                    src="/images/photos/small/shop{$sd.id}.jpg" class="img-resp" alt="{$sd.title}"/>
                            {if $sd.old_price>0}
                                {assign var="disco" value=((100-($iprice*100/$sd.old_price))|ceil)}
                                <div class="ribbon-lt"><span>Скидка {$disco}%</span></div>{/if}
                            {if $sd.novinka==1}
                                <div class="ribbon-rt"><span>Новинка</span></div>
                            {/if}
                            {if $sd.is_hit}
                                <div class="ribbon-rb"><span>Хит</span></div>
                            {/if}
                            {if $sd.is_spec}
                                <div class="ribbon-lb"><span>Акция</span></div>
                            {/if}
                            {if $sd.kaspikz}
                                <img src="/templates/basic_free/img/bankaspiski1.png" class="bankaspiski"/>
                            {/if}
                        </a>
                        <div class="capt"><a href="/shop/{$sd.seolink}.html" title="{$sd.title}"
                                             data-truncate="2">{$sd.title}</a></div>
                        <div class="pricer">                        {if $sd.old_price}
                                <s>{$sd.old_price|number_format:0:' ':' '}</s>{/if}
                            <div{if $sd.old_price} class="color_red"{/if}>{if $iprice>0}{$iprice|number_format:0:' ':' '} тг.{else}&nbsp;{/if}</div>
                        </div>
                        <form action="/shop/addtocart" method="POST"><input type="hidden" name="add_to_cart_item_id"
                                                                            value="{$sd.id}"/>
                            <div class="text-center">
                                <button type="submit" class="btn btn-main add-basket{if $sd.is_in_cart>0} btn-disabled{elseif $sd.price==0}  btn-gray{/if}">{if $sd.is_in_cart>0}В корзине{else}{if $sd.qty!=0}В корзину{else}В корзину{/if}{/if}</button>
                            </div>
                        </form>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="tab3">
        <div class="row no-gutters">
            {foreach key=tid item=sd from=$sd3}
                {if $smarty.session.user.group_id==10}
                    {$iprice=$sd.opt}
                {else}
                    {$iprice=$sd.price}
                {/if}
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <div class="thumb"><a href="/shop/{$sd.seolink}.html" title="{$sd.title}" class="imgthumb"><img
                                    src="/images/photos/small/shop{$sd.id}.jpg" class="img-resp" alt="{$sd.title}"/>
                            {if $sd.old_price>0}
                                {assign var="disco" value=((100-($iprice*100/$sd.old_price))|ceil)}
                                <div class="ribbon-lt"><span>Скидка {$disco}%</span></div>{/if}
                            {if $sd.novinka==1}
                                <div class="ribbon-rt"><span>Новинка</span></div>
                            {/if}
                            {if $sd.is_hit}
                                <div class="ribbon-rb"><span>Хит</span></div>
                            {/if}
                            {if $sd.is_spec}
                                <div class="ribbon-lb"><span>Акция</span></div>
                            {/if}
                            {if $sd.kaspikz}
                                <img src="/templates/basic_free/img/bankaspiski1.png" class="bankaspiski"/>
                            {/if}
                        </a>
                        <div class="capt"><a href="/shop/{$sd.seolink}.html" title="{$sd.title}"
                                             data-truncate="2">{$sd.title}</a></div>
                        <div class="pricer">                        {if $sd.old_price}
                                <s>{$sd.old_price|number_format:0:' ':' '}</s>{/if}
                            <div{if $sd.old_price} class="color_red"{/if}>{if $iprice>0}{$iprice|number_format:0:' ':' '} тг.{else}&nbsp;{/if}</div>
                        </div>
                        <form action="/shop/addtocart" method="POST"><input type="hidden" name="add_to_cart_item_id"
                                                                            value="{$sd.id}"/>
                            <div class="text-center">
                                <button type="submit"
                                        class="btn btn-main add-basket{if $sd.is_in_cart>0} btn-disabled{elseif $sd.price==0}  btn-gray{/if}">{if $sd.is_in_cart>0}В корзине{else}{if $sd.qty!=0}В корзину{else}В корзину{/if}{/if}</button>
                            </div>
                        </form>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="tab4">
        <div class="row no-gutters">
            {foreach key=tid item=sd from=$sd4}
                {if $smarty.session.user.group_id==10}
                    {$iprice=$sd.opt}
                {else}
                    {$iprice=$sd.price}
                {/if}
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <div class="thumb"><a href="/shop/{$sd.seolink}.html" title="{$sd.title}" class="imgthumb"><img
                                    src="/images/photos/small/shop{$sd.id}.jpg" class="img-resp" alt="{$sd.title}"/>
                            {if $sd.old_price>0}
                                {assign var="disco" value=((100-($iprice*100/$sd.old_price))|ceil)}
                                <div class="ribbon-lt"><span>Скидка {$disco}%</span></div>{/if}
                            {if $sd.novinka==1}
                                <div class="ribbon-rt"><span>Новинка</span></div>
                            {/if}
                            {if $sd.is_hit}
                                <div class="ribbon-rb"><span>Хит</span></div>
                            {/if}
                            {if $sd.is_spec}
                                <div class="ribbon-lb"><span>Акция</span></div>
                            {/if}
                            {if $sd.kaspikz}
                                <img src="/templates/basic_free/img/bankaspiski1.png" class="bankaspiski"/>
                            {/if}
                        </a>
                        <div class="capt"><a href="/shop/{$sd.seolink}.html" title="{$sd.title}"
                                             data-truncate="2">{$sd.title}</a></div>
                        <div class="pricer">                        {if $sd.old_price}
                                <s>{$sd.old_price|number_format:0:' ':' '}</s>{/if}
                            <div{if $sd.old_price} class="color_red"{/if}>{if $iprice>0}{$iprice|number_format:0:' ':' '} тг.{else}&nbsp;{/if}</div>
                        </div>
                        <form action="/shop/addtocart" method="POST"><input type="hidden" name="add_to_cart_item_id"
                                                                            value="{$sd.id}"/>
                            <div class="text-center">
                                <button type="submit"
                                        class="btn btn-main add-basket{if $sd.is_in_cart>0} btn-disabled{elseif $sd.price==0}  btn-gray{/if}">{if $sd.is_in_cart>0}В корзине{else}{if $sd.qty!=0}В корзину{else}В корзину{/if}{/if}</button>
                            </div>
                        </form>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="tab5">
        <div class="row no-gutters">
            {foreach key=tid item=sd from=$sd5}
                {if $smarty.session.user.group_id==10}
                    {$iprice=$sd.opt}
                {else}
                    {$iprice=$sd.price}{/if}
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <div class="thumb"><a href="/shop/{$sd.seolink}.html" title="{$sd.title}" class="imgthumb"><img
                                    src="/images/photos/small/shop{$sd.id}.jpg" class="img-resp" alt="{$sd.title}"/>
                            {if $sd.old_price>0}
                                {assign var="disco" value=((100-($iprice*100/$sd.old_price))|ceil)}
                                <div class="ribbon-lt"><span>Скидка {$disco}%</span></div>{/if}
                            {if $sd.novinka==1}
                                <div class="ribbon-rt"><span>Новинка</span></div>
                            {/if}
                            {if $sd.is_hit}
                                <div class="ribbon-rb"><span>Хит</span></div>
                            {/if}
                            {if $sd.is_spec}
                                <div class="ribbon-lb"><span>Акция</span></div>
                            {/if}
                            {if $sd.kaspikz}
                                <img src="/templates/basic_free/img/bankaspiski1.png" class="bankaspiski"/>
                            {/if}
                        </a>
                        <div class="capt"><a href="/shop/{$sd.seolink}.html" title="{$sd.title}"
                                             data-truncate="2">{$sd.title}</a></div>
                        <div class="pricer">                        {if $sd.old_price}
                                <s>{$sd.old_price|number_format:0:' ':' '}</s>{/if}
                            <div{if $sd.old_price} class="color_red"{/if}>{if $iprice>0}{$iprice|number_format:0:' ':' '} тг.{else}&nbsp;{/if}</div>
                        </div>
                        <form action="/shop/addtocart" method="POST"><input type="hidden" name="add_to_cart_item_id"
                                                                            value="{$sd.id}"/>
                            <div class="text-center">
                                <button type="submit"
                                        class="btn btn-main add-basket{if $sd.is_in_cart>0} btn-disabled{elseif $sd.price==0}  btn-gray{/if}">{if $sd.is_in_cart>0}В корзине{else}{if $sd.qty!=0}В корзину{else}В корзину{/if}{/if}</button>
                            </div>
                        </form>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
</div>