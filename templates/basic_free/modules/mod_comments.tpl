{foreach key=aid item=comment from=$comments}
	<div class="media">
		<span class="pull-left"><img src="/templates/basic_free/img/user.png" class="media-object" width="48" height="48" /></span>
		<div class="media-body">
			<p>{if !$comment.is_profile}{$comment.author}{else}{$comment.author.nickname}{/if}, {$comment.pubdate|date_format:"%d/%m/%y"}</p>
			<p>{$comment.content|strip_tags}</p>
		</div>
	</div>
{/foreach}