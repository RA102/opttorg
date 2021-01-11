<div class="float_bar">{if !$ownertype}<span class="btn btn-primary">{$LANG.POSTS_RSS} ({$total})</span>{else}<a class="btn btn-default" href="/blogs">{$LANG.POSTS_RSS}</a>{/if} {if $ownertype == 'all'}<span class="btn btn-primary">{$LANG.ALL_BLOGS}  ({$total})</span>{else}<a class="btn btn-default" href="/blogs/all.html">{$LANG.ALL_BLOGS}</a>{/if} {if $ownertype == 'single'}<span class="btn btn-primary">{$LANG.PERSONALS}  ({$total})</span>{else}<a class="btn btn-default" href="/blogs/single.html">{$LANG.PERSONALS}</a>{/if} {if $ownertype == 'multi'}<span class="btn btn-primary">{$LANG.COLLECTIVES}  ({$total})</span>{else}<a class="btn btn-default" href="/blogs/multi.html">{$LANG.COLLECTIVES}</a>{/if}</div>
<h1 class="con_heading">{$LANG.BLOGS}</h1>

{if $blogs}
<ul class="list-group">
		{foreach key=tid item=blog from=$blogs}
            <li class="list-group-item">
			<div class="row">
                <div class="col-md-6"><a href="{$blog.url}"><span class="glyphicon glyphicon-book"></span> {$blog.title}</a></div>
                {if $blog.ownertype =='single'}
                    <div class="col-md-3"><a href="{profile_url login=$blog.login}"><span class="glyphicon glyphicon-user"></span> {$blog.nickname}</a></div>
                {else}
                    <div class="col-md-3">&nbsp;</div>
                {/if}
                <div class="col-md-3">
				<span class="monospc"><span class="glyphicon glyphicon-list-alt"></span> {$blog.records}</span>
				<span class="monospc"><span class="glyphicon glyphicon-share-alt"></span> {$blog.comments_count}</span>
				<span class="monospc"><span class="glyphicon glyphicon-star"></span> {$blog.rating|rating}</span>
				{if $cfg.rss_one}
				<a class="pull-right" href="/rss/blogs/{$blog.id}/feed.rss"><span class="glyphicon glyphicon-signal"></span></a>
                {/if}				
				</div>
			</div>
			</li>
		{/foreach}
</ul>
	{if $cfg.rss_all}
		<div style="margin-top:20px;">
			<a class="btn btn-default" href="/rss/blogs/all/feed.rss">{$LANG.BLOGS_RSS}</a>
		</div>
	{/if}
	{$pagination}
{else}
	<p class="error-txt">{$LANG.NOT_ACTIVE_BLOGS}</p>
{/if}