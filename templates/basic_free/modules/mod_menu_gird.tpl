<aside class="top-aside">
{foreach key=key item=item from=$items}
	<a href="{$item.link}" target="{$item.target}"title="{$item.title|escape:'html'}" class="top-aside-cell">{if $item.iconurl}<img src="/images/menuicons/{$item.iconurl}" alt="{$item.title|escape:'html'}" />{/if}<br />{$item.title}</a>
{/foreach}
</aside>