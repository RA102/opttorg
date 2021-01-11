<h1 class="con_heading">{$title}{if $cfg.is_rss} <a href="/rss/catalog/all/feed.rss" title="{$LANG.RSS}"><span class="glyphicon glyphicon-signal"></span></a>{/if}</h1>
{if $cats_html}
    {$cats_html}
{else}
    <p class="text-danger">{$LANG.NO_CAT_IN_CATALOG}</p>
{/if}