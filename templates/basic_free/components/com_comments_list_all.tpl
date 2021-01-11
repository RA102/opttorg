<h1 class="con_heading">{$page_title} ({$comments_count})</h1>
{if $comments_count}
	{foreach key=cid item=comment from=$comments}
<div class="cmm-entry {cycle values="rowa2,rowa1"}">
	<div class="cmm-heading">
				{if $comment.is_profile}
		<a href="{profile_url login=$comment.author.login}" class="pull-left"><img class="cmm-avatar" src="{$comment.user_image}" /></a>
				{else}
		<a href="#" class="pull-left"><img class="cmm-avatar" src="/images/users/avatars/small/nopic.jpg" /></a>
				{/if}
		<div class="cmm-title">
                        <span class="pull-right cmm_votes">
                        {if $comment.rating>0}
                            <span style="color:green;">+{$comment.rating}</span>
                        {elseif $comment.rating<0}
                            <span style="color:red;">{$comment.rating}</span>
                        {else}
                            {$comment.rating}
                        {/if}
                        </span>
 	
					{if !$comment.is_profile}
						<span class="monospc">{$comment.author} {if $is_admin && $comment.ip}({$comment.ip}){/if}</span>
					{else}
						<span class="monospc"><a href="{profile_url login=$comment.author.login}">{$comment.author.nickname}</a> {if $is_admin && $comment.ip}({$comment.ip}){/if}</span>
					{/if}
                    <a href="#c{$comment.id}" title="{$LANG.LINK_TO_COMMENT}">#</a>
                    <div class="monospc small-italic">{if $comment.published}{$comment.fpubdate}{else}<span style="color:#F00">{$LANG.WAIT_MODERING}</span>{/if} &rarr; <a href="{$comment.target_link}#c{$comment.id}" title="{$LANG.LINK_TO_COMMENT}">{$comment.target_title}</a></div>
		</div>
	</div>	
	<div class="cmm-body">
                	<div class="cmm-mess" id="cm_msg_{$comment.id}">
					{if $comment.show}
						{$comment.content}
					{else}
						<a href="javascript:void(0)" onclick="expandComment({$comment.id})" id="expandlink{$comment.id}">{$LANG.SHOW_COMMENT}</a>
						<div id="expandblock{$comment.id}" style="display:none">{$comment.content}</div>
					{/if}
                    </div>
	</div>
</div>	
	{/foreach}
{$pagebar}
{else}
	<p class="text-danger">{$LANG.NOT_COMMENT_TEXT}</p>
{/if}
