<div class="float_bar">
    <div class="news_cat_select">
        <select name="cat_id" onchange="window.location.href='/maps/news/'+$(this).val()">
            <option value="all" {if $cat_id=='all'}selected="selected"{/if}>{$LANG.MAPS_ALL_CATS}</option>
            {foreach key=i item=c from=$cats}
                <option value="{$c.id}" {if $cat_id==$c.id}selected="selected"{/if}>
                    {math equation="(x-1) * 3" x=$c.NSLevel assign="pad"}
                    {'-'|str_repeat:$pad} {$c.title}
                </option>
            {/foreach}
        </select>
    </div>
</div>

<h1 class="con_heading">
    {if !$item && !$cat}{$LANG.MAPS_NEWS_ALL}{/if}
    {if $item}{$LANG.MAPS_NEWS} &rarr; {$item.title}{/if}
    {if $cat}{$LANG.MAPS_NEWS} &rarr; {$cat.title}{/if}
</h1>

{if $items}

    {foreach key=n item=news from=$items}
	<div class="media {cycle values="rowa1,rowa2"}">
        <a class="pull-left" href="/maps/{$news.obj_seolink}.html#tab_news" title="{$news.obj_title|escape:'html'}"><img src="/images/photos/small/{$news.filename}" class="media-object" /></a>
                <div class="media-body">
                    <h4 class="media-heading"><a href="/maps/news/{$news.id}.html">{$news.title}</a></h4>
                    <div class="media-hinttext">
                        <span class="glyphicon glyphicon-time"></span> {$news.pubdate} &mdash;
                        <a href="/maps/{$news.obj_seolink}.html#tab_news" title="{$news.obj_title|escape:'html'}"><span class="glyphicon glyphicon-map-marker"></span> {$news.obj_title|escape:'html'}</a>
                    </div>
                </div>
    </div>
    {/foreach}

{if $pagebar}{$pagebar}{/if}
{else}
    <p class="text-danger">{$LANG.MAPS_NO_NEWS}</p>
{/if}