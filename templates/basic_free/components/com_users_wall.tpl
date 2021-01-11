<input type="hidden" name="target_id" value="{$target_id}" />
<input type="hidden" name="component" value="{$component}" />
{if $total}
    {foreach key=id item=record from=$records}
<div class="cmm-entry {cycle values="rowa2,rowa1"}" id="wall_entry_{$record.id}">
  <div class="cmm-heading">
	<a href="{profile_url login=$record.author_login}" class="pull-left"><img class="cmm-avatar" src="{$record.avatar}" /></a>
	<div class="cmm-title">
		{if $my_profile || $record.author_id==$user_id || $is_admin}<span class="pull-right"><a href="javascript:void(0)" onclick="deleteWallRecord('{$component}', '{$target_id}', '{$record.id}', '{csrf_token}');return false;" title="{$LANG.DELETE}"><span class="glyphicon glyphicon-trash"></span></a></span>{/if}	
		<a href="{profile_url login=$record.author_login}">{$record.author}</a><div class="monospc small-italic">{$record.fpubdate}{if $record.is_today} {$LANG.BACK}{/if}</div> 
	</div>
  </div>
  <div class="cmm-body">
    {$record.content}
  </div>		
</div>
    {/foreach}
	{$pagebar}
{else}
    <p>{$LANG.NOT_POSTS_ON_WALL_TEXT}</p>
{/if}