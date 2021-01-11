<div class="float_bar">
    <a href="/content/add.html" class="btn btn-primary">{$LANG.ADD_ARTICLE}</a>
</div>
<h1 class="con_heading">{$LANG.MY_ARTICLES} ({$total})</h1>

{if $articles}
<div class="table-responsive">
<table class="table table-striped">
		<tr>
			<td style="width:100px !important;"><strong>{$LANG.DATE}</strong></td>
			<td><strong>{$LANG.ARTICLE}</strong></td>
			<td align="center" style="width:56px !important;"><strong>{$LANG.STATUS}</strong></td>
			<td style="width:56px !important;">&nbsp;</td>
			<td style="width:100px !important;"><strong>{$LANG.CAT}</strong></td>
			<td align="center"><strong>{$LANG.ACTION}</strong></td>
		</tr>
	{foreach key=tid item=article from=$articles}
		<tr>
			<td style="width:100px !important;"><img src="/templates/{template}/images/icons/article.png" border="0"> {$article.fpubdate}</td>
			<td><a href="{$article.url}">{$article.title}</a></td>
			<td align="center" style="width:56px !important;">
            	{if $article.published}
                	<span style="color:green">{$LANG.PUBLISHED}</span>
                {else}
                	<span style="color:#CC0000">{$LANG.NO_PUBLISHED}</span>
                 {/if}
            </td>
			<td style="width:56px !important;"><img src="/templates/{template}/images/icons/comments.png" border="0"> {$article.comments}</td>
			<td style="width:100px !important;"><a href="{$article.cat_url}">{$article.cat_title}</a></td>
			<td align="center">
				<a href="/content/edit{$article.id}.html" title="{$LANG.EDIT}"><img src="/templates/{template}/images/icons/edit.png" border="0"/></a>
				{if $user_can_delete}
					<a href="/content/delete{$article.id}.html" title="{$LANG.DELETE}"><img src="/templates/{template}/images/icons/delete.png" border="0"/></a>
				{/if}
			</td>
		</tr>
	{/foreach}
</table>
</div>
{$pagebar}
{else}
	<p class="text-danger">{$LANG.NO_YOUR_ARTICL_ON_SITE}</p>
{/if}