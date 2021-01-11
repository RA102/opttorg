{$colpht="1"}
{if $cfg.maxcols>=4}{$cfg.maxcols="4"}{$columns="3"}{else}{$columns=12/$cfg.maxcols}{/if}
    {foreach key=tid item=photo from=$photos name=pht}
        {if $colpht==1}<div class="row margin-bottom-row">{/if}
            <figure class="media-gird col-md-{$columns}">
                <a href="/images/photos/medium/{$photo.file}" class="lightbox-enabled" rel="lightbox" title="{$photo.title|escape:'html'}"><img src="/images/photos/small/{$photo.file}" alt="{$photo.title|escape:'html'}" /></a>
        	</figure>
{if $colpht==$cfg.maxcols || $smarty.foreach.pht.last}</div>{$colpht="1"}{else}{$colpht=$colpht+1}{/if}
    {/foreach}
