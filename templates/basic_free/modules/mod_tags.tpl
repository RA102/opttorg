<div style="position:relative;width:100%;display:inline-block;">
{foreach key=tid item=tag from=$tags}<a class="label label-{if $cfg.colors}{cycle values=$cfg.colors}{else}default{/if}" title="{$tag.num|spellcount:$LANG.TAG_ITEM1:$LANG.TAG_ITEM2:$LANG.TAG_ITEM10}" href="/search/tag/{$tag.tag|urlencode}" style="float:left;margin:0 2px 2px 0;{if $tag.fontsize} font-size: {$tag.fontsize}px;{/if}">{$tag.tag|icms_ucfirst}</a>{/foreach} 
</div>