<div class="float_bar">{if !$ownertype}<span class="btn btn-primary">{$LANG.POSTS_RSS} ({$total})</span>{else}<a class="btn btn-default" href="/blogs">{$LANG.POSTS_RSS}</a>{/if} {if $ownertype == 'all'}<span class="btn btn-primary">{$LANG.ALL_BLOGS}</span>{else}<a class="btn btn-default" href="/blogs/all.html">{$LANG.ALL_BLOGS}</a>{/if} {if $ownertype == 'single'}<span class="btn btn-primary">{$LANG.PERSONALS}</span>{else}<a class="btn btn-default" href="/blogs/single.html">{$LANG.PERSONALS}</a>{/if} {if $ownertype == 'multi'}<span class="btn btn-primary">{$LANG.COLLECTIVES}</span>{else}<a class="btn btn-default" href="/blogs/multi.html">{$LANG.COLLECTIVES}</a>{/if}</div>
<h1 class="con_heading">{$pagetitle}</h1>
{if $posts}
		{foreach key=tid item=post from=$posts}
<div class="cmm-entry {cycle values="rowb1,rowb2"}">
  <div class="cmm-body">
    <h4 class="media-heading"><a href="{$post.url}" title="{$post.title|escape:'html'}">{$post.title}</a>{if $post.blog_url} &rarr; <a href="{$post.blog_url}" title="{$post.blog_title|escape:'html'}">{$post.blog_title|truncate:32}</a>{/if}</h4>
	<div class="cmm-mess short-description">{$post.content_html}</div>
	<div class="media-hinttext"><a class="monospc" rel="author" href="{profile_url login=$post.login}"><span class="glyphicon glyphicon-user"></span> {$post.author}</a><span class="monospc"><span class="glyphicon glyphicon-time"></span> {if !$post.published}<span style="color:#CC0000">{$LANG.ON_MODERATE}</span>{else}{$post.fpubdate}{/if}</span><span class="monospc"><span class="glyphicon glyphicon-star"></span> {$post.rating|rating}</span><span class="monospc"><span class="glyphicon glyphicon-eye-open"></span> {$post.hits}</span>{if ($post.comments_count > 0)}<a class="monospc" href="{$post.url}#c"><span class="glyphicon glyphicon-share-alt"></span> {$post.comments_count}</a>{/if}{if $post.tagline != false}<span><span class="glyphicon glyphicon-tag"></span> {$post.tagline}</span>{/if}
	</div>
  </div>
</div>
		{/foreach}
	{$pagination}
{else}
	<p class="error-txt">{$LANG.NOT_POSTS}</p>
{/if}
