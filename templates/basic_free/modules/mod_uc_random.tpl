{if $is_uc}
{$coluc="1"}
    {foreach key=tid item=item from=$items name=ucr}
{if $coluc==1}<div class="row margin-bottom-row">{/if}
<div class="col-md-3 media-gird" align="center">
<a href="/catalog/item{$item.id}.html"><img alt="{$item.title|escape:'html'}" src="/images/catalog/small/{$item.imageurl}" class="media-object" /></a><h4 class="media-heading"><a href="/catalog/item{$item.id}.html">{$item.title|truncate:30}</a></h4>
{if $item.viewtype == 'shop'}<div class="media-hinttext">&mdash; {$item.price} {$LANG.CURRENCY}</div>{/if}
</div>
{if $coluc==4 || $smarty.foreach.ucr.last}</div>{$coluc="1"}{else}{$coluc=$coluc+1}{/if}		
    {/foreach}
{else}
	<p>{$LANG.UC_RANDOM_NO_ITEMS}</p>
{/if}