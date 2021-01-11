<div class="breadcrumb clearfix" itemscope itemtype="http://schema.org/BreadcrumbList">
{$pw="1"}
{foreach key=tid item=path from=$pathway name='pathway'}
{if $path.is_last}
<span class="current-page">{$path.title}</span>
{else}
<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="{$path.link}" class="current-page" itemprop="item"><span itemprop="name">{$path.title}</span></a><meta itemprop="position" content="{$pw}" /></span>{/if}{if !$smarty.foreach.pathway.last}<span> / </span>{/if}
{$pw=$pw+1}
{/foreach}
</div>