<div class="clearfix"></div>

{$col="1"}
{$cols="1"}
<div class="row no-gutters">
    {foreach key=tid item=item from=$items name=shpv}
        {if $cols==3}
            {if $itembanner!=''}{$itembanner}{/if}
        {/if}
        {if $smarty.session.user.group_id==10}{$iprice=$item.opt}{else}{$iprice=$item.price}{/if}
        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 list-item-card">
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
                    <img src="/images/photos/small/{$item.filename}" class="img-fluid" alt="{$item.title}"/>
                    {if $item.old_price>0}
                        {assign var="disco" value=((100-($iprice*100/$item.old_price))|ceil)}
                        <div class="ribbon-lt"><span>Скидка 1 {$disco}%</span></div>{/if}
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
                {if $item.qty > 1 || $item.qty_from_vendor > 1}
                <form action="/shop/addtocart" method="POST">
                    <input type="hidden" name="add_to_cart_item_id" value="{$item.id}"/>
                    <div class="text-center">
                        <button type="submit" class="btn btn-main add-basket{if $item.is_in_cart>0} btn-disabled{elseif $item.price==0}  btn-gray{/if}">{if $item.is_in_cart>0}В корзине{else}{if $item.price==0}Цену уточняйте{else}В корзину{/if}{/if}</button>
                    </div>
                    <a class="btn-oneclick" href="#" data-toggle="modal" data-target="#oneclicker">В один клик!</a>
                </form>
                {else}
                    <a class="btn-oneclick" href="#" data-toggle="modal" data-target="#oneclicker">Узнать о сроках поступления</a>
                {/if}
            </div>
        </div>
        {$cols=$cols+1}
    {/foreach}
</div>


{if $pages>1}
    {$pagebar}
{/if}

