{if $is_img}
		<div class="media-gird" align="center"><a href="/photos/photo{$item.id}.html"><img class="media-object" src="/images/photos/medium/{$item.file}" border="0" /></a>
		{if $cfg.showtitle}
			<h4 class="media-heading"><a href="/photos/photo{$item.id}.html">{$item.title}</a></h4>
		{/if}
		</div>
{/if}