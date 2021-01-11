<div class="row">
{foreach key=aid item=article from=$articles}
<div class="col-md-6">
<div class="arttab">
	<div class="art-table">
		<div class="art-left text-center">
			<img src="/images/photos/small/{$article.image}" alt="{$article.title|escape:'html'}" />
			<div class="art-time">{$article.pubdate|date_format:"%d %b"}<br />{$article.pubdate|date_format:"%Y"} г.</div>
		</div>
		<div class="art-right text-center">
			<h4 class="art-heading" data-truncate="1">{$article.title|truncate:45}</h4>
			<span class="art-desc" data-truncate="5">{$article.description|strip_tags|truncate:200}</span>
		</div>		
	</div>
</div>
</div>
{/foreach}
</div>