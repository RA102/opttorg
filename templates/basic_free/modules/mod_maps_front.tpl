{if !$items}
    <p>{$LANG.MAPS_FRONT_EMPTY}</p>
{/if}
{if $items}
		{$colmapv="1"}
		{if $cfg.cols>=4}{$cfg.cols="4"}{$columns="3"}{else}{$columns=12/$cfg.cols}{/if}
        {foreach key=tid item=item from=$items name=mapv}
        {if $colmapv==1}<div class="row margin-bottom-row">{/if}
			<div class="media-gird col-md-{$columns}" align="center">
                <a href="/maps/{$item.seolink}.html" title="{$item.title|htmlspecialchars}"><img src="/images/photos/small/{$item.filename}" class="media-object" alt="{$item.title|htmlspecialchars}" /></a>
				{if $cfg.show_title}
                 <h4 class="media-heading"><a href="/maps/{$item.seolink}.html" title="{$item.title|htmlspecialchars}">{$item.title|htmlspecialchars}</a></h4>
                {/if}
			</div>
		{if $colmapv==$cfg.cols || $smarty.foreach.mapv.last}</div>{$colmapv="1"}{else}{$colmapv=$colmapv+1}{/if}
			{/foreach}
{/if}