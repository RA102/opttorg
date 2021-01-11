{foreach key=tid item=post from=$posts}
<div class="media">
            {if !$post.fileurl}
                <a class="pull-left" href="{profile_url login=$post.login}" title="{$post.author|escape:'html'}"><img class="media-object" src="{$post.author_avatar}" alt="{$post.author|escape:'html'}" /></a>
            {else}
                <a class="pull-left" href="{$post.url}"><img class="media-object" src="{$post.fileurl}" alt="{$post.title|escape:'html'}" /></a>
            {/if}
  <div class="media-body">
    <h4 class="media-heading"><a href="{$post.url}" title="{$post.title|escape:'html'}">{$post.title}</a></h4>

            <div class="media-hinttext">
                <span class="monospc">{$post.fpubdate}</span> <a class="monospc" href="{$post.url}#c" title="{$post.comments_count|spellcount:$LANG.COMMENT1:$LANG.COMMENT2:$LANG.COMMENT10}"><span class="glyphicon glyphicon-share-alt"></span> {$post.comments_count}</a> <span class="monospc"><span class="glyphicon glyphicon-star"></span> {$post.rating|rating}</span> <a href="{$post.blog_url}"><span class="glyphicon glyphicon-user"></span> {$post.blog_title}</a> 
            </div>
  </div>
</div>
{/foreach}

{if $cfg.showrss}
    <div style="margin-top:15px;">
        <a href="/rss/blogs/all/feed.rss" class="btn btn-default">{$LANG.RSS}</a>
    </div>
{/if}