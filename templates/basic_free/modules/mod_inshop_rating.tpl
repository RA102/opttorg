{if $items}
		<div class="row margin-bottom-row">
        {foreach key=tid item=item from=$items name=shpp}
				<div class="col-md-3 col-sm-6" align="center">
					<div class="item-gird mini-gird">
                    <a href="/shop/{$item.seolink}.html" title="{$item.title}"><img src="/images/photos/medium/{$item.filename}" class="item-object" /></a>
					<div class="item-gird-caption">
						<a href="/shop/{$item.seolink}.html" class="item-gird-title" data-truncate="1">{$item.title}</a><br />
						{if $item.vendor}<a href="/shop/vendors/{$item.vendor_id}" data-truncate="1" class="item-gird-vendor">{$item.vendor}</a>{else}<span class="item-gird-vendor">Произв. не указан</span>{/if}
					</div>
                    <div class="item-gird-table">
						<div class="table-left">
							<div class="gird-info">артикул:<br /> {$item.art_no}</div>
							<div class="gird-price">{$item.price} {$shop_cfg.currency}</div>
						</div>
						<div class="table-right text-center">
							<a class="gird-more" href="/shop/{$item.seolink}.html">Подробнее</a>
							<form action="/shop/addtocart" method="POST">
							<input type="hidden" name="add_to_cart_item_id" value="{$item.id}" />
							<a href="javascript:$('#form{$item.id}').submit();" class="add-basket" rel="{$item.id}">В корзину</a>
							</form>
						</div>
                    </div>
					<div class="corner">
					{if $item.is_hit}<span class="glyphicon glyphicon-star"></span>{/if}{if $item.old_price}<span class="percent">%</span>{/if}
					</div>
					<a href="/shop/compare/{$item.id}" title="Сравнить товар" class="glyphicon glyphicon-random vsrav-corner"></a>				
					</div>
				</div>
		{/foreach}
		</div>
{/if}