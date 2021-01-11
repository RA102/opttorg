<h1 class="con_heading">{$pagetitle}</h1>
{if $items}
    {foreach key=id item=item from=$items}
<div class="media {cycle values="rowb1,rowb2"}">
        {if $item.showdesc && $item.description}
            {if $item.image}
  <a class="pull-left" href="{$item.url}" title="{$item.title|escape:'html'}"><img class="media-object" src="/images/photos/small/{$item.image}" alt="{$item.title|escape:'html'}" /></a>
            {/if}
        {/if}  
  <div class="media-body">
    <h3 class="media-heading"><a href="{$item.url}" title="{$item.title|escape:'html'}">{$item.title}</a></h3>
        {if $item.showdesc && $item.description}
	<div class="media-description">{$item.description|truncate:300}</div>
        {/if}
<div class="media-hinttext"><a href="/arhive/{$item.year}/{$item.month}/{$item.day}" class="monospc" title="{$item.fpubdate}"><span class="glyphicon glyphicon-time"></span> {$item.fpubdate}</a> <a href="{$item.category_url}" class="monospc" title="{$item.cat_title}"><span class="glyphicon glyphicon-folder-open"></span> &nbsp;{$item.cat_title}</a></div> 		
  </div>
</div>
    {/foreach}
{else}
    <p class="error-txt">{$LANG.ARHIVE_NO_MATERIALS}</p>
{/if}