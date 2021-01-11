{if $total}
<div class="list-group">
		{foreach key=id item=article from=$articles}
<a href="{$article.url}" class="list-group-item"><span class="glyphicon glyphicon-list-alt"></span> {$article.title}</a>
		{/foreach}
</div>
{else}
	<p>{$LANG.PU_USER_NO_ADD_ART}</p>
{/if}