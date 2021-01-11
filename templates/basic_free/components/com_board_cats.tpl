{if $category.is_can_add || $root_id==$category.id}
<div class="float_bar">
<a href="/board/{if $root_id!=$category.id}{$category.id}/{/if}add.html" class="btn btn-primary">{$LANG.ADD_ADV}</a>
</div>
{/if}
<h1 class="con_heading">{$category.title} <a href="/rss/board/{if $root_id==$category.id}all{else}{$category.id}{/if}/feed.rss" title="{$LANG.RSS}"><span class="glyphicon glyphicon-signal"></span></a></h1>
{if $cats}
{if $maxcols>=4}{$maxcols="4"}{$columns="3"}{else}{$columns=12/$maxcols}{/if}
{$col="1"}
		{foreach key=tid item=cat from=$cats name=counter}
{if $col==1}<div class="row margin-bottom-row cats-list">{/if}
				<div class="col-md-{$columns}">
<div class="media">
	<a class="pull-left" href="/board/{$cat.id}"><img src="/upload/board/cat_icons/{$cat.icon}" class="media-object" /></a>
  <div class="media-body">
    <h4 class="media-heading"><a href="/board/{$cat.id}">{$cat.title}</a> ({$cat.content_count})</h4>
		{if $cat.description}
			<div class="media-description">{$cat.description|truncate:100}</div>
		{/if}
		<div class="media-hinttext">{$cat.ob_links}</div>
  </div>
</div>  
				</div>
{if $col==$maxcols || $smarty.foreach.counter.last}</div>{$col="1"}{else}{$col=$col+1}{/if}
		{/foreach}
{/if}
{if $category.description}
    <div class="item-description">{$category.description}</div>
{/if}