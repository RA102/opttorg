{$post.plugins_output_before}

{if $myblog || $is_admin || ($is_writer && $is_author)}
    <div class="float_bar">
        {if !$post.published && ($is_admin)}<a class="btn btn-default" href="javascript:void(0)" onclick="{component}.publishPost({$post.id});return false;">{$LANG.PUBLISH}</a>{/if} <a class="btn btn-default" href="/{component}/editpost{$post.id}.html">{$LANG.EDIT}</a> <a class="btn btn-default" href="javascript:void(0)" onclick="{component}.deletePost({$post.id}, '{csrf_token}');return false;">{$LANG.DELETE}</a>
    </div>
{/if}
<article>
<h1 class="con_heading">{$post.title}</h1>
<div class="well no-padding-bottom">
<div class="row">
	<div class="col-md-2">
<div class="blog-header-author">
		<a rel="nofollow" href="{profile_url login=$post.author_login}" title="{$LANG.AVTOR} - {$post.author_nickname}"><img border="0" width="80" src="{$post.author_avatar}" alt="{$LANG.AVTOR} - {$post.author_nickname}" /></a>
		<a rel="author" href="{profile_url login=$post.author_login}" title="{$LANG.AVTOR} - {$post.author_nickname}"><span>{$post.author_nickname}</span></a>
</div>
	</div>
	<div class="col-md-8">
			<ul class="list-group">
				<li class="list-group-item"><strong>{$LANG.PUBLISHED}:</strong> {if !$post.published}<span id="pub_wait" style="color:#F00;">{$LANG.ON_MODERATE}</span><span id="pub_date" style="display:none;">{$post.fpubdate}</span>{else}<time datetime="{$post.fpubdate}">{$post.fpubdate}</time>{/if}</li>
				<li class="list-group-item"><strong>{$LANG.BLOG}:</strong> <a href="/{component}/{$blog.seolink}">{$blog.title}</a></li>
				{if $blog.showcats && $cat}
					<li class="list-group-item"><strong>{$LANG.CAT}:</strong> <a href="/{component}/{$blog.seolink}/cat-{$cat.id}">{$cat.title}</a></li>
				{/if}
				{if $post.edit_times}
					<li class="list-group-item"><strong>{$LANG.EDITED}:</strong> {$post.edit_times|spellcount:$LANG.TIME1:$LANG.TIME2:$LANG.TIME10} &mdash; {if $post.edit_times>1}{$LANG.LATS_TIME}{/if} {$post.feditdate}</li>
				{/if}
				{if $post.feel}
					<li class="list-group-item"><strong>{$LANG.MOOD}:</strong> {$post.feel}</li>
				{/if}
				{if $post.music}
					<li class="list-group-item"><strong>{$LANG.PLAYING}:</strong> {$post.music}</li>
				{/if}
			</ul>	
	</div>
	<div class="col-md-2"><div class="blog-header-karma">{$karma_form}<p><span class="glyphicon glyphicon-eye-open"></span> {$post.hits}</p></div></div>
</div> 
</div>
<div class="blog-body">{$post.content_html}{if $post.tags}<div class="media-hinttext"><span class="glyphicon glyphicon-tag"></span> {$post.tags}</div>{/if}</div>
{if $navigation && ($navigation.prev || $navigation.next)}
	<div class="blog-post-nav">
    	{if $navigation.prev}<a href="{$navigation.prev.url}" class="btn btn-default">&larr; {$navigation.prev.title}</a>{/if}
        {if $navigation.next}<a href="{$navigation.next.url}" class="btn btn-default">{$navigation.next.title} &rarr;</a>{/if}
    </div>
{/if}
</article>
{$post.plugins_output_after}