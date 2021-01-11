<div class="com-content">
{if !$is_homepage}
        <h1 class="con_heading">{$pagetitle}{if $cat.showrss} <a href="/rss/content/{$cat.id}/feed.rss" title="{$LANG.RSS}"><span class="glyphicon glyphicon-signal"></span></a>{/if}</h1>
        {if $cat.description}
        <div class="item-description">{$cat.description}</div>
    {/if}
{/if}

{if $subcats}
	<div class="list-group">
		{foreach key=tid item=subcat from=$subcats}
            <a href="{$subcat.url}" class="list-group-item">
                <h4>{$subcat.title}<span class="badge pull-right">{$subcat.content_count}</span></h4>
                <div class="hint">{$subcat.description}</div>
            </a>
		{/foreach}
	</div>
{/if}

{if $cat_photos}
<div class="panel panel-default">
    {if $cat_photos.album.title}
	<div class="panel-heading">
    <h4 class="panel-title">{$cat_photos.album.title}</h4>
	</div>
    {/if}
	<div class="panel-body">
    <div class="row">
{foreach key=tid item=con from=$cat_photos.photos}
            <div class="col-md-3 col-sm-4 col-xs-6 media-gird">
                <a class="lightbox-enabled" rel="lightbox-galery" href="/images/photos/medium/{$con.file}" title="{$con.title|escape:'html'}"><img src="/images/photos/small/{$con.file}" class="media-object" alt="{$con.title|escape:'html'}" /></a><h4 class="monospc media-heading"><a href="/photos/photo{$con.id}.html" title="{$con.title|escape:'html'}">{$con.title}</a></h4>
			</div>
{/foreach}
   </div>
   </div>
</div>
{/if}
{if $articles}
{if $cat.maxcols==1}
{foreach key=tid item=article from=$articles name=artis}
<article class="media {cycle values="rowb1,rowb2"}">
	{if $cat.showdesc}
		{if $article.image}
  <a class="pull-left" href="{$article.url}" title="{$article.title|escape:'html'}"><img class="media-object" src="/images/photos/small/{$article.image}" alt="{$article.title|escape:'html'}" /></a>
		{/if}
	{/if}  
  <div class="media-body">
    <h4 class="media-heading"><a href="{$article.url}" title="{$article.title|escape:'html'}">{$article.title}</a></h4>
	{if $cat.showdesc}
		<div class="media-description">{$article.description|strip_tags|truncate:400}</div>
    {/if}	
	<div class="media-hinttext">
		{if $showdate}<span class="monospc"><span class="glyphicon glyphicon-time"></span> {$article.fpubdate}</span> <span class="monospc"><a href="{profile_url login=$article.user_login}"><span class="glyphicon glyphicon-user"></span> {$article.author}</a></span>{/if}{if $cat.showcomm} <span class="monospc"><span class="glyphicon glyphicon-share-alt"></span> {$article.comments|spellcount:$LANG.COMMENT1:$LANG.COMMENT2:$LANG.COMMENT10}</span> <span class="monospc"><span class="glyphicon glyphicon-eye-open"></span> {$article.hits|spellcount:$LANG.HIT:$LANG.HIT2:$LANG.HIT10}</span>{/if}
		{if $cat.showtags && $article.tagline}<span class="media-tagline"><span class="glyphicon glyphicon-tag"></span> {$article.tagline}</span>{/if}
	</div>
  </div>
</article>
{/foreach}
{else}
{$col="1"}
{if $cat.maxcols>=4}{$cat.maxcols="4"}{$columns="3"}{else}{$columns=12/$cat.maxcols}{/if}
		{foreach key=tid item=article from=$articles name=artis}
{if $col==1}<div class="row margin-bottom-row">{/if} 
    <article class="col-md-{$columns} media-gird">
	{if $cat.showdesc}
		{if $article.image}
        <div>
            <a href="{$article.url}" title="{$article.title|escape:'html'}"><img src="/images/photos/medium/{$article.image}" alt="{$article.title|escape:'html'}" class="media-object" /></a>
        </div>
		{/if}
	{/if}
        <h4 class="media-heading"><a href="{$article.url}" title="{$article.title|escape:'html'}">{$article.title}</a></h4>
			{if $cat.showdesc}
		<div class="media-description">{$article.description|strip_tags|truncate:400}</div>
            {/if}		
		<div class="media-hinttext">
			{if $showdate}<span class="monospc"><span class="glyphicon glyphicon-time"></span> {$article.fpubdate}</span> <span class="monospc"><a href="{profile_url login=$article.user_login}"><span class="glyphicon glyphicon-user"></span> {$article.author}</a></span>{/if}{if $cat.showcomm} <span class="monospc"><span class="glyphicon glyphicon-share-alt"></span> {$article.comments}</span> <span class="monospc"><span class="glyphicon glyphicon-eye-open"></span> {$article.hits}</span>{/if}{if $cat.showtags && $article.tagline}<span class="media-tagline"><span class="glyphicon glyphicon-tag"></span> {$article.tagline}</span>{/if}
		</div>
    </article>
{if $col==$cat.maxcols || $smarty.foreach.artis.last}</div>{$col="1"}{else}{$col=$col+1}{/if}
		{/foreach}
{/if}
	{$pagebar}
{/if}
</div>