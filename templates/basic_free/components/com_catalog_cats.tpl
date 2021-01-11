<div class="list-group">
	{foreach key=tid item=cat from=$cats}
		<a href="/catalog/{$cat.id}" class="list-group-item">{$cat.title} <span class="badge">{$cat.content_count}</span></a>
	{/foreach}
</div>