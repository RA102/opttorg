{if $myblog || $is_writer || $is_admin}
    <div class="float_bar">
	{if $myblog || $is_admin}
<div class="btn-group">
<a class="btn btn-default" href="{$blog.add_post_link}">{$LANG.NEW_POST}</a>
				{if $on_moderate}
<a class="btn btn-default" href="{$blog.moderate_link}">{$LANG.MODERATING} ({$on_moderate})</a>
				{/if}  
                {if $is_config}
<a class="btn btn-default" href="javascript:void(0)" title="{$LANG.CONFIG}" onclick="{component}.editBlog({$blog.id});return false;"><span class="glyphicon glyphicon-cog"></span></a>
                {/if}
<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{$LANG.CATS} 
    <span class="caret"></span>
    <span class="sr-only">Открыть</span>
</button>
<ul class="dropdown-menu pull-right">
    <li><a class="ajaxlink" href="javascript:void(0)" onclick="{component}.addBlogCat({$blog.id});return false;">{$LANG.NEW_CAT}</a></li>
        {if $cat_id>0}
    <li><a class="ajaxlink" href="javascript:void(0)" onclick="{component}.editBlogCat({$cat_id});return false;">{$LANG.RENAME_CAT}</a></li>
    <li><a class="ajaxlink" href="javascript:void(0)" onclick="{component}.deleteCat({$cat_id}, '{csrf_token}');return false;">{$LANG.DEL_CAT}</a></li>
        {/if}
</ul>
</div>
	{elseif $is_writer}
<a class="btn btn-default" href="{$blog.add_post_link}">{$LANG.NEW_POST}</a>
	{/if}
    </div>
{/if}

<h1 class="con_heading">{$blog.title}</h1>

<div class="well">
	{if $blog.ownertype == 'single'}
<span class="monospc" title="{$LANG.BLOG_AVTOR}"><span class="glyphicon glyphicon-user"></span> {$blog.author}</span>
	{else}
<span class="monospc" title="{$LANG.BLOG_ADMIN}"><span class="glyphicon glyphicon-user"></span> {$blog.author}{if $blog.forall}, {$LANG.BLOG_OPENED_FOR_ALL}{/if}</span>
	{/if}
<span class="monospc"><span class="glyphicon glyphicon-time"></span> {$blog.pubdate}</span>
<span class="monospc"><span class="glyphicon glyphicon-star"></span> {$blog.rating|rating}</span>
<a class="monospc" href="/rss/{component}/{$blog.id}/feed.rss"><span class="glyphicon glyphicon-signal"></span> {$LANG.RSS}</a>
</div>

{if $blogcats}
<div class="blog-cats">
	{if $cat_id}
	<a class="blog-cat" href="{$blog.blog_link}">{$LANG.ALL_CATS} ({$all_total})</a> <span style="color:#666666"></span></td>
	{else}
	<span class="blog-cat">{$LANG.ALL_CATS} ({$total})</span>
	{/if}
	{foreach key=tid item=cat from=$blogcats}
	{if $cat_id!=$cat.id}
	<a class="blog-cat" href="{$blog.blog_link}/cat-{$cat.id}">{$cat.title} ({$cat.post_count})</a>
	{else}
	<span class="blog-cat">{$cat.title} ({$cat.post_count})</span>
    {$cur_cat=$cat}
	{/if}
	{/foreach}
</div>

{if $cur_cat.description}
	<div class="item-description">{$cur_cat.description|nl2br}</div>
{/if}
{/if}

{if $posts}
		{foreach key=tid item=post from=$posts}
<div class="cmm-entry {cycle values="rowb1,rowb2"}">
  <div class="cmm-body">
    <h4 class="media-heading"><a href="{$post.url}" title="{$post.title|escape:'html'}">{$post.title}</a></h4>
	<div class="cmm-mess short-description">{$post.content_html}</div>
	<div class="media-hinttext"><a class="monospc" rel="author" href="{profile_url login=$post.login}"><span class="glyphicon glyphicon-user"></span> {$post.author}</a><span class="monospc"><span class="glyphicon glyphicon-time"></span> {if !$post.published}<span style="color:#CC0000">{$LANG.ON_MODERATE}</span>{else}{$post.fpubdate}{/if}</span><span class="monospc"><span class="glyphicon glyphicon-star"></span> {$post.rating|rating}</span><span class="monospc"><span class="glyphicon glyphicon-eye-open"></span> {$post.hits}</span>{if ($post.comments_count > 0)}<a class="monospc" href="{$post.url}#c"><span class="glyphicon glyphicon-share-alt"></span> {$post.comments_count|spellcount:$LANG.COMMENT:$LANG.COMMENT2:$LANG.COMMENT10}</a>{else}<a class="monospc" href="{$post.url}#c"><span class="glyphicon glyphicon-share-alt"></span> {$LANG.NOT_COMMENTS}</a>{/if}{if $post.tagline != false}<span><span class="glyphicon glyphicon-tag"></span> {$post.tagline}</span>{/if}
	</div>
  </div>
</div>
		{/foreach}
	{$pagination}
{else}
	<p class="error-txt">{$LANG.NOT_POSTS}</p>
{/if}