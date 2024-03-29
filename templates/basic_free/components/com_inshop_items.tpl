<div class="clearfix"></div>

{$col="1"}
{$cols="1"}
<div class="row">
    {foreach key=tid item=item from=$items name=shpv}
        {if $cols==3}
            {if $itembanner!=''}{$itembanner}{/if}
        {/if}
        {if $smarty.session.user.group_id==10}{$iprice=$item.opt}{else}{$iprice=$item.price}{/if}
        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4 list-item-card">
            {literal}
            <script>
                ids.push("{/literal}{$item.id}{literal}");
            </script>
            {/literal}
            <div class="thumb ids{$item.id}">
                <!--
			{if $item.is_hit==1 || $item.is_front==1 || $item.is_new==1 || $item.old_price>0}
				<div class="spec-points">
					{if $item.is_front==1}<span class="spec-act">Акция!</span><br />{/if}
					{if $item.old_price>0}
						{assign var="disco" value=((100-($iprice*100/$item.old_price))|ceil)}
						<span class="spec-skid">-{$disco}%</span><br />
					{/if}					 
					{if $item.is_hit==1}<span class="spec-hit">Хит!</span><br />{/if}							
					{if $item.is_new==1}<span class="spec-date">Новинка!</span><br />{/if}
				</div>
			{/if}
			-->
                <a href="/shop/{$item.seolink}.html" title="{$item.title}" class="imgthumb">
                    <img class="img-fluid" src="/images/photos/small/{$item.filename}" data-art-no="{$item.art_no}" alt="{$item.title}"/>
                    {if $item.old_price>0}
                        {assign var="disco" value=((100-($iprice*100/$item.old_price))|ceil)}
                        <div class="ribbon-lt"><span>Скидка{$disco}%</span></div>{/if}
                    {if $item.novinka==1}
                        <div class="ribbon-rt"><span>Новинка</span></div>
                    {/if}
                    {if $item.is_hit}
                        <div class="ribbon-rb"><span>Хит</span></div>
                    {/if}
                    {if $item.is_spec}
                        <div class="ribbon-lb"><span>Акция</span></div>
                    {/if}
                    {if $item.kaspikz}<img src="/templates/basic_free/img/bankaspiski1.png" class="bankaspiski"/>{/if}
                </a>
                <div class="capt">
                    <a href="/shop/{$item.seolink}.html" title="{$item.title}" data-truncate="2" id="title{$item.id}">{$item.title}</a>
                </div>
                <div class="pricer">
                    {if $item.price == 0}
                        <div>&nbsp;</div>
                    {else}
                        {if $item.old_price|number_format}<s>{$item.old_price|number_format:0:' ':' '}</s>{/if}
                        <div {if $item.old_price|number_format} class="color_red"{/if}>{$iprice|number_format:0:' ':' '} {$cfg.currency}</div>
                    {/if}
                </div>
                {if $item.qty > 1 && $item.sell_warehouse}
                <form action="/shop/addtocart" method="POST">
                    <input type="hidden" name="add_to_cart_item_id" value="{$item.id}"/>
                    <div class="text-center">
                        <button type="submit" class="btn btn-main add-basket{if $item.is_in_cart>0} btn-disabled{elseif $item.price==0}  btn-gray{/if}">{if $item.is_in_cart>0}В корзине{else}{if $item.price==0}Цену уточняйте{else}В корзину{/if}{/if}</button>
                    </div>
                    <a class="btn-oneclick" href="#" data-toggle="modal" data-target="#oneclicker" data-art-no="{$item.art_no}" data-title="{$item.title}" data-seolink="/shop/{$item.seolink}.html" data-img="/images/photos/small/{$item.filename}" data-price="{$iprice|number_format:0:' ':' '}">Заказ в один клик!</a>
                </form>
                {elseif $item.qty_from_vendor > 1 && $item.sell_to_order}
                    <div class="d-flex justify-content-center align-items-center" style="height: 38px;">
                        <a class="text-green" href="#">Срок поставки: {$item.time_delivery}
                            {if $item.time_delivery == 1}
                                день.
                            {elseif $item.time_delivery == 2 || $item.time_delivery == 3 || $item.time_delivery == 4}
                                дня.
                            {else}
                                дней.
                            {/if}
                        </a>
                    </div>
                    <a class="btn-oneclick" href="#" data-toggle="modal" data-target="#oneclicker" data-art-no="{$item.art_no}" data-title="{$item.title}" data-seolink="/shop/{$item.seolink}.html" data-img="/images/photos/small/{$item.filename}">Заказ в один клик</a>
                {/if}
            </div>
        </div>
        {$cols=$cols+1}
    {/foreach}
</div>


{if $pages>1}
    {$pagebar}
{/if}

{* modal order one click *}
<div class="modal fade" id="oneclicker" tabindex="-1" role="dialog" aria-labelledby="oneclickerLabel">
    <div class="modal-dialog modal-sm" role="document">
        <form action="" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="oneclickerLabel"></h4>
                </div>
                <div class="modal-body">
                    <img id="oneClickImg" src="" class="img-fluid" style="border:#dedede 1px solid;margin-bottom:15px;" itemprop="image"/> {*alt="{$item.title|escape:'html'} - {$item.art_no} – интернет-магазин SanMarket" *}
                    <table width="100%" border="0">
                        <tr>
                            <td valign="middle" width="80">
                                <input style="width:80px !important;" class="form-control" id="qtyy1" name="qtyy1" type="number" min="1" value="1" oninput="change1()"/>
                            </td>
                            <td valign="middle" class="text-right">
                                <strong><span id="results1"></span>
                                    <span class="text--color-blue"> тг.</span>
                                </strong></td>
                        </tr>
                    </table>
                    <br/>
                    <input type="hidden" name="price1" value=""/>
                    <input type="hidden" name="seolink" value=""/>
                    <input type="hidden" name="ttl" value=""/>
                    <input type="hidden" name="arts" value=""/>
                    <input type="text" class="form-control" name="yname" placeholder="Ваше имя" required/><br/>
                    <div>
                        {* {city_input value=$item.city name="city" width="300px"} *}
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