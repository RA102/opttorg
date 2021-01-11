{$item.plugins_output_before}
<div class="float_bar">
{if $item.moderator}<a href="/board/edit{$item.id}.html" class="btn btn-default" title="{$LANG.EDIT}">{$LANG.EDIT}</a> {if !$item.published && ($is_admin || $is_moder)}<a href="/board/publish{$item.id}.html" class="btn btn-default" title="{$LANG.PUBLISH}">{$LANG.PUBLISH}</a> {/if}<a href="/board/delete{$item.id}.html" class="btn btn-default" title="{$LANG.DELETE}">{$LANG.DELETE}</a>{/if}
</div>
<h1 class="con_heading">{if $item.is_vip}<span class="glyphicon glyphicon-bookmark text-danger" title="{$LANG.VIP_ITEM}"></span> {/if}{$item.title}</h1>
<div class="row margin-bottom-row">
	{if $item.file && $cfg.photos}
		<div class="col-sm-4 media-gird">
			<img src="/images/board/medium/{$item.file}" class="media-object" alt="{$item.title|escape:'html'}" />
		</div>
		<div class="col-sm-8">
	{else}
		<div class="col-sm-12">
	{/if}	
    {if $formsdata}
		<div class="well">
        {foreach key=tid item=form from=$formsdata}
        {if $form.field}
            <div class="row">
                <div class="col-md-6 no-margin-bottom">
                     {$form.title}
                </div>
                <div class="col-md-6 no-margin-bottom">
                    &mdash; {$form.field}
                </div>
            </div>
        {/if}
        {/foreach}
		</div>
    {/if}
	<div class="media-description">{$item.content}</div>
	<div class="media-hinttext">
		<span class="monospc"><span class="glyphicon glyphicon-time"></span> {$item.pubdate}</span>
		<span class="monospc"><span class="glyphicon glyphicon-eye-open"></span> {$item.hits}</span>
		{if $item.city}
		<span class="monospc"><a href="/board/city/{$item.enc_city}"><span class="glyphicon glyphicon-globe"></span> {$item.city}</a></span>
		{/if}
		{if $item.user}
		<span class="monospc"><a href="{profile_url login=$item.user_login}"><span class="glyphicon glyphicon-user"></span> {$item.user}</a></span>
		{else}
		<span class="monospc">{$LANG.BOARD_GUEST}</span>
		{/if}
		{if $item.is_overdue}
		<span class="monospc text-danger">{$LANG.ADV_IS_EXTEND}</span>
		{/if}
	</div>			
	{if $user_id}
	<br />		
		{if $item.user && !$item.user_is_deleted && $item.user_id != $user_id}
            {add_js file='components/users/js/profile.js'}
			<a class="btn btn-default" title="{$LANG.WRITE_MESS_TO_AVTOR}" href="javascript:void(0)" onclick="users.sendMess('{$item.user_id}', 0, this);return false;">{$LANG.WRITE_MESS_TO_AVTOR}</a>
		{/if}
		<a class="btn btn-default" href="/board/by_user_{$item.user_login}">{$LANG.ALL_AVTOR_ADVS}</a>
	{/if}
		</div>
</div>
{$item.plugins_output_after}
{if $cfg.comments}
    {$can_delete = ($item.user_id == $user_id)}
    {comments target='boarditem' target_id=$item.id can_delete=$can_delete}
{/if}