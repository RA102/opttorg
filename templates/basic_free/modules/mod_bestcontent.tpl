{if $articles}
{foreach key=tid item=article from=$articles}
<div class="media">
        {if $article.image}
    <a class="pull-left" title="{$article.title|escape:'html'}" href="{$article.url}"><img src="/images/photos/small/{$article.image}" class="media-object" alt="{$article.title|escape:'html'}"/></a>
        {/if}
  <div class="media-body">
    <h4 class="media-heading"><a href="{$article.url}">{$article.title}</a></h4>
        {if $cfg.showdesc}
            <div class="media-description">
                {$article.description|strip_tags|truncate:300}
            </div>
        {/if} 	
            <div class="media-hinttext">
                <span class="monospc"><span class="glyphicon glyphicon-time"></span>  {$article.fpubdate}</span> <a class="monospc" href="{profile_url login=$article.user_login}"><span class="glyphicon glyphicon-user"></span> {$article.author}</a> <span class="monospc"><span class="glyphicon glyphicon-star"></span> {$article.rating|rating}</span>
            </div>
  </div>
</div>
{/foreach}
{if $cfg.showlink neq 0}
		<div style="margin-top:15px;">
			<a href="/content/top.html" class="btn btn-default">{$LANG.BESTCONTENT_FULL_RATING}</a>
		</div>
{/if}
{else}
<p class="text-info">{$LANG.BESTCONTENT_NOT_ARTICLES}</p>
{/if}