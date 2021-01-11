<br /><div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title">{$LANG.P_TITLE}</h4>
</div>
<div class="panel-body">
		{foreach item=post from=$posts name=blsim}
<div class="media {cycle values="rowa1,rowa2"}">
<a href="{$post.url}" title="{$post.title|escape:'html'}" class="pull-left"><img src="{$post.fileurl}" alt="{$post.title|escape:'html'}" class="media-object" /></a>
<div class="media-body">
<h4 class="media-heading"><a href="{$post.url}">{$post.title}</a></h4>
<div class="media-description">{$post.content}</div>
</div>
</div>
		{/foreach}
</div>
</div> 