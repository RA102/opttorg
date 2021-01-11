<h1 class="con_heading">{$LANG.ARTICLES_RATING}</h1>
{if $articles}
		{foreach key=tid item=article from=$articles name=artis}
<div class="media {cycle values="rowb1,rowb2"}">
	{if $article.showdesc}
		{if $article.image}
  <a class="pull-left" href="{$article.url}" title="{$article.title|escape:'html'}"><img class="media-object" src="/images/photos/{if $cat.maxcols==1}medium{else}small{/if}/{$article.image}" alt="{$article.title|escape:'html'}" /></a>
		{/if}
	{/if}  
  <div class="media-body">
	<span class="pull-right" style="font-weight:700;">{$article.rating|rating}</span>
    <h3 class="media-heading"><a href="{$article.url}" title="{$article.title|escape:'html'}">{$article.title}</a></h3>
	{if $article.showdesc}
		<div class="media-description">{$article.description|truncate:400}</div>
    {/if}	
	<div class="media-hinttext">
		<span class="monospc"><a href="{$article.cat_url}"><span class="glyphicon glyphicon-folder-open"></span>  &nbsp;{$article.cat_title}</a></span> 
		{if $article.showdate}<span class="monospc"><span class="glyphicon glyphicon-time"></span> {$article.fpubdate}</span> <span class="monospc"><a href="{profile_url login=$article.user_login}"><span class="glyphicon glyphicon-user"></span> {$article.author}</a></span>{/if}{if $article.showcomm} <span class="monospc"><span class="glyphicon glyphicon-share-alt"></span> {$article.comments|spellcount:$LANG.COMMENT1:$LANG.COMMENT2:$LANG.COMMENT10}</span> <span class="monospc"><span class="glyphicon glyphicon-eye-open"></span> {$article.hits|spellcount:$LANG.HIT:$LANG.HIT2:$LANG.HIT10}</span>{/if}{if $article.tagline} <span><span class="glyphicon glyphicon-tag"></span> {$article.tagline}</span>{/if}
	</div>
  </div>
</div>
		{/foreach}
{else}
	<p class="text-danger">{$LANG.NO_ARTICLES_PUBL_ON_SITE}</p>
{/if}
