<div class="row no-gutters">
{foreach key=tid item=item from=$items name=shpv}
{if $smarty.session.user.group_id==10}{$iprice=$item.opt}{else}{$iprice=$item.price}{/if}
	<div class="col-md-3 col-sm-4 col-xs-6">
		<div class="thumb">
			<a href="/shop/{$item.seolink}.html" title="{$item.title}"><img src="/images/photos/small/{$item.filename}" class="img-resp" alt="{$item.title}" /></a>
			<div class="capt">
				<a href="/shop/{$item.seolink}.html" title="{$item.title}" data-truncate="2">{$item.title}</a>
			</div>
			<div class="pricer">
				{if $item.old_price}<s>{$item.old_price|number_format:0:' ':' '}</s>{/if}
				<div>{$iprice|number_format:0:' ':' '} {$shop_cfg.currency}</div>
			</div>
			<form action="/shop/addtocart" method="POST">
			<input type="hidden" name="add_to_cart_item_id" value="{$item.id}" />
			<div class="text-center"><button type="submit" class="btn btn-main add-basket{if $item.is_in_cart>0} btn-disabled{/if}">{if $item.is_in_cart>0}В корзине{else}{if $item.qty!=0}В корзину{else}Заказать{/if}{/if}</button></div>
			</form>
		</div>
	</div>
{/foreach}						
</div>