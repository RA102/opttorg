{if $subcats_list}
<div class="list-group">
    {$last_level=1}
    {foreach key=tid item=cat from=$subcats_list}
<a class="list-group-item{if $cat.seolink == $current_seolink} active{/if}" href="{$cat.url}">{if $cat.NSLevel > 1}&nbsp;&nbsp;&nbsp;&nbsp; {/if}{$cat.title} <span class="badge">{$cat.content_count}</span></a>
    {$last_level=$cat.NSLevel}
    {/foreach}
</div>
{/if}