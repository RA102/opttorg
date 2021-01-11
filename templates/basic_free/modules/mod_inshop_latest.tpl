{if $items}
		{$colshpl="1"}
		{if $cfg.cols>=4}{$cfg.cols="4"}{$columns="3"}{else}{$columns=12/$cfg.cols}{/if}
        {foreach key=tid item=item from=$items name=shpl}
        {if $colshpl==1}<div class="row margin-bottom-row">{/if}
				<div class="media-gird col-md-{$columns}" align="center">
                    <a href="/shop/{$item.seolink}.html" title="{$item.title}"><img src="/images/photos/small/{$item.filename}" class="media-object" {if $cfg.show_hit_img && $item.is_hit}style="border-color:#D44950;"{/if} /></a>
                            {if $shop_cfg.is_shop && $item.price}
					<h4{if $cfg.show_hit_img && $item.is_hit} class="text-danger"{/if}>{$item.price} {$shop_cfg.currency}</h4>
                            {/if}
					{if $cfg.show_title}<div class="media-hinttext"><a href="/shop/{$item.seolink}.html">{$item.title}</a></div>{/if}
				</div>
		{if $colshpl==$cfg.cols || $smarty.foreach.shpl.last}</div>{$colshpl="1"}{else}{$colshpl=$colshpl+1}{/if}
		{/foreach}
{/if}