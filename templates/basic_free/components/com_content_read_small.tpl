<h1 class="con_heading">{$article.title}</h1>
<div class="body-page">
<div class="con_text">
<div class="item-description" style="overflow:hidden">	
    {if $article.image}
        <figure class="item-mainthumbnail">
            <img src="/images/photos/small/{$article.image}" alt="{$article.title|escape:html}" />
        </figure>
    {/if}
    {$article.content}
</div>
<div class="media-hinttext">
{if $article.showdate}
<span class="monospc"><span class="glyphicon glyphicon-time"></span> {if !$article.published}{$LANG.NO_PUBLISHED}{else}<time datetime="{$article.pubdate}">{$article.pubdate}</time>{/if}</span> <span class="monospc"><a href="{profile_url login=$article.user_login}" rel="author"><span class="glyphicon glyphicon-user"></span> <span>{$article.author}</span></a></span>
{/if} <span class="monospc"><span class="glyphicon glyphicon-eye-open"></span> {$article.hits|spellcount:$LANG.HIT:$LANG.HIT2:$LANG.HIT10}</span> {if $tagbar}<span class="glyphicon glyphicon-tag"></span> {$tagbar}{/if}
</div>
{if $cfg.rating && $article.canrate}<br />
	<div id="con_rating_block" class="well no-margin-bottom">
			<strong>{$LANG.RATING}: </strong><span id="karmapoints">{$karma_points}</span>
			<span style="padding:0 10px;color:#999"><strong>{$LANG.VOTES}:</strong> {$karma_votes}</span>
		{if $karma_buttons}
            <span id="karmactrl"><strong>{$LANG.RAT_ARTICLE}: </strong> {$karma_buttons}</span>
		{/if}
	</div>
{/if}
</div>
{$article.plugins_output_after}
</div>