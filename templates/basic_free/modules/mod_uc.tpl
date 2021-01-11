{if $cfg.showtype == 'thumb'}
{$coluc="1"}
    {foreach key=tid item=item from=$items name=ucc}
{if $coluc==1}<div class="row margin-bottom-row">{/if}
<div class="col-md-3 media-gird" align="center">
<a href="/catalog/item{$item.id}.html"><img alt="{$item.title|escape:'html'}" src="/images/catalog/small/{$item.imageurl}" class="media-object" /></a><h4 class="media-heading"><a href="/catalog/item{$item.id}.html">{$item.title|truncate:30}</a></h4>
{if $item.viewtype == 'shop'}<div class="media-hinttext">&mdash; {$item.price} {$LANG.CURRENCY}</div>{/if}
</div>
{if $coluc==4 || $smarty.foreach.ucc.last}</div>{$coluc="1"}{else}{$coluc=$coluc+1}{/if}		
    {/foreach}
{/if}

{if $cfg.showtype == 'list'}
        {foreach key=tid item=item from=$items}
            <div class="row {cycle values="rowa1,rowa2"}">
                <div class="col-md-3">
                    <a class="strong" href="/catalog/item{$item.id}.html">{$item.title|truncate:30}</a>
                </div>
                    {if $item.viewtype == 'shop'}
				<div class="col-md-4">
                {section name=customer start=0 loop=$cfg.showf step=1}
                    <small>{$item.fdata[$smarty.section.customer.index]}</small>
                {/section}
				</div>
                <div class="col-md-2"><em>&mdash; {$item.price} {$LANG.CURRENCY}</em></div>
					{else}
				<div class="col-md-6">
                {section name=customer start=0 loop=$cfg.showf step=1}
                    <small>{$item.fdata[$smarty.section.customer.index]}</small>
                {/section}
				</div>
                    {/if}
				<div class="col-md-3"><small>{$item.key}</small></div>						
            </div>
	
        {/foreach}
{/if}

{if $cfg.fulllink}
    <div style="margin-top:15px; text-align:right; clear:both"><a class="btn btn-default" href="/catalog">{$LANG.UC_MODULE_CATALOG} &rarr;</a></div>
{/if}