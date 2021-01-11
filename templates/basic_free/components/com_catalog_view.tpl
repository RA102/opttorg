<div class="float_bar" id="shop_toollink_div">
	{if $cat.view_type=='shop'} {$shopcartlink}	{/if}
	<a class="btn btn-default" id="shop_searchlink" href="/catalog/{$cat.id}/search.html" title="{$LANG.SEARCH_BY_CAT}"><span class="glyphicon glyphicon-search"></span></a> {if $is_can_add}<a class="btn btn-default" href="/catalog/{$cat.id}/add.html">{$LANG.ADD_ITEM}</a>
    {/if}
</div>
<h1 class="con_heading">{$cat.title}{if $cfg.is_rss} <a href="/rss/catalog/{$cat.id}/feed.rss" title="{$LANG.RSS}"><span class="glyphicon glyphicon-signal"></span></a>{/if}</h1>
{if $cat.description}
	<div class="item-description">{$cat.description}</div>
{/if}
{if $subcats}
	{$subcats}
{/if}
{if $alphabet} {$alphabet} {/if}
{if $cat.showsort} {$orderform} {/if}
{if $itemscount>0}
	{if $search_details} {$search_details} {/if}
			{if $cat.view_type=='list' || $cat.view_type=='shop'}
		{foreach key=tid item=item from=$items}	
<div class="row margin-bottom-row {cycle values="rowb1,rowb2"}">
{if $item.imageurl}
<div class="col-md-4 media-gird">
  <a class="lightbox-enabled" title="{$item.title|escape:'html'}" rel="lightbox" href="/images/catalog/{$item.imageurl}"><img class="media-object" alt="{$item.title|escape:'html'}" src="/images/catalog/small/{$item.imageurl}" /></a>
</div>
<div class="col-md-8">
{else}
<div class="col-xs-12">
{/if}
  <div class="media-body">
	{if $cat.is_ratings}<div class="pull-right">{$item.rating}</div>{/if}  
    <h3 class="media-heading">{if $item.is_new}<span class="glyphicon glyphicon-bookmark text-danger"></span> {/if}<a href="/catalog/item{$item.id}.html">{$item.title}</a>{if $item.can_edit} <a href="/catalog/edit{$item.id}.html" title="{$LANG.EDIT}"><span class="glyphicon glyphicon-edit text-warning"></span></a>{/if}</h3>
	<div class="media-description">
	<ul class="list-group">
		{foreach key=field item=value from=$item.fields}
            {if $value}
                {if !strstr($field, '/~l~/')}
                    <li class="list-group-item"><strong>{$field}</strong>: {$value}</li>
                {else}
                    <li class="list-group-item">{$value}</li>
                {/if}
            {/if}
		{/foreach}	
{if $item.tagline && $cat.showtags}
	<li class="list-group-item"><strong>{$LANG.TAGS}:</strong> {$item.tagline}</li>
{/if}		
	</ul>
	</div>	
	<div class="well">
	{if $cat.view_type=='list'}
		{if $cat.showmore}
		<a href="/catalog/item{$item.id}.html" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> {$LANG.DETAILS}</a>
		{/if}
	{else}
		<a href="/catalog/item{$item.id}.html" title="{$LANG.DETAILS}" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> {$LANG.DETAILS}</a>
		<a href="/catalog/addcart{$item.id}.html" rel="nofollow" title="{$LANG.ADD_TO_CART}" class="btn btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span> {$item.price} {$LANG.CURRENCY}</a>
	{/if}	
	</div>
  </div>
</div>
</div>
		{/foreach}
			{/if}
			{if $cat.view_type=='thumb'}
{$col="1"}
{foreach key=tid item=item from=$items name=uccount}			
{if $col==1}<div class="row margin-bottom-row">{/if}			
				<div class="col-md-4 col-sm-6 media-gird">
					<a rel="nofollow" href="/catalog/item{$item.id}.html">{if $item.imageurl}<img alt="{$item.title|escape:'html'}" src="/images/catalog/small/{$item.imageurl}" class="media-object" />{else}<img alt="{$item.title|escape:'html'}" src="/images/catalog/small/nopic.jpg" class="media-object" />{/if}</a>
					<h3 class="monospc media-heading"><a href="/catalog/item{$item.id}.html" title="{$item.title|escape:'html'}">{$item.title}</a></h3>
				</div>
{if $col==4 || $smarty.foreach.uccount.last}</div>{$col="1"}{else}{$col=$col+1}{/if}				
{/foreach}				
			{/if}
		{$pagebar}
{/if}