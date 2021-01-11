{if $items}
    <div class="actions_list">
    {foreach key=n item=news from=$items}
            <div class="action_entry {cycle values="rowa1, rowa2"}"> 
                {if $cfg.show_date}<span class="pull-right action_date"><span class="glyphicon glyphicon-time"></span> {$news.pubdate}</span>{/if}
                <div class="action_title act_add_maps_news">
                    <span class="action_user"><a href="/maps/news/{$news.id}.html">{$news.title}</a> </span>
				</div>
				<div class="action_details">
{if $cfg.show_city}<span style="color:#666;" class="monospc"><span class="glyphicon glyphicon-map-marker"></span> {$news.obj_city}</span>{/if}				
            {if $cfg.show_object}
                <a class="monospc" href="/maps/{$news.obj_seolink}.html#tab_news" title="{$news.obj_title|escape:'html'}">&mdash; {$news.obj_title|escape:'html'}</a>
            {/if}
                </div>
            </div>
    {/foreach}
</div>

<div style="text-align: right;margin-top:20px;"><a class="btn btn-default" href="/maps/news">Все новости</a></div>

{else}

    <p>{$LANG.MAPS_NO_NEWS}</p>

{/if}