<div class="float_bar">{if $user_id}<a class="btn btn-default" href="/forum/my_activity.html">{$LANG.MY_ACTIVITY}</a> {/if}{if $do == 'latest_posts'}<a class="btn btn-default" href="/forum/latest_thread">{$LANG.NEW_THREADS}</a>{else}<a class="btn btn-default" href="/forum/latest_posts">{$LANG.LATEST_POSTS}</a>{/if} <a class="btn btn-default" href="/forum">{$LANG.FORUMS}</a>{if ($is_admin || $is_moderator) && !$my_profile} <a class="btn btn-default" href="javascript:" onclick="forum.clearAllPosts('{$user_id}', '{csrf_token}');">{$LANG.DELETE_ALL_USER_POSTS}</a>{/if}</div>
<h1 class="con_heading">{$pagetitle}</h1>
{if $sub_do == 'threads'}
    {include file='com_forum_view.tpl'}
{else}
    {if $post_count}
	{$num=1}
    <div class="thread-table">
        {$last_thread_id=''}
    {foreach key=pid item=post from=$posts}
    <div class="row thread-title">
        <div class="col-lg-12">
            <div class="post_date" style="float:left;">{if $post.pinned && $num > 1}<img src="/templates/{template}/images/icons/forum/sticky.png" width="14px;" alt="{$LANG.ATTACHED_MESSAGE}" title="{$LANG.ATTACHED_MESSAGE}" />  {/if}<a name="{$post.id}" href="/forum/thread{$thread.id}-{$page}.html#{$post.id}">#{$num}</a> - {$post.fpubdate}, {$post.wday}</div>
        </div>
    </div>
    <div class="row thread-body">
        <div class="col-md-2">
			<div class="thread-left">
            <div>
                <a class="thread-userlink" href="javascript:" onclick="addNickname(this);return false;" title="{$LANG.ADD_NICKNAME}" rel="{$post.nickname|escape:html}" >{$post.nickname|escape:html}</a>
            </div>
            <div class="thread-userrank">
                {if $post.userrank.group}
                    <span class="{$post.userrank.class}">{$post.userrank.group}</span>
                {/if}
                {if $post.userrank.rank}
                    <span class="{$post.userrank.class}">{$post.userrank.rank}</span>
                {/if}
            </div>
            <div class="thread-userimg">
                <a href="{profile_url login=$post.login}" title="{$LANG.GOTO_PROFILE}"><img border="0" src="{$post.avatar_url}" alt="{$post.nickname|escape:html}" /></a>
                {if $post.user_awards}
                    <div class="thread-userawards">
                        {foreach key=aid item=award from=$post.user_awards}
						<span class="glyphicon glyphicon-star" title="{$award.title|escape:html}"></span>
                        {/foreach}
                    </div>
                {/if}
            </div>
            <div class="thread-usermsgcnt">{$LANG.MESSAGES}: {$post.post_count}</div>
            {if $post.city}
                <div class="thread-usermsgcnt">г. {$post.city}</div>
            {/if}
            <div style="font-size:.8em;">{$post.flogdate}</div> 
			</div>
        </div>
        <div class="col-lg-10">
		<div class="thread-right">
        {if $thread.closed || !$user_id || $post.is_author || $post.is_voted}
            <div class="thread-votes_links pull-right">{$post.rating|rating}</div>
        {else}
            <div class="thread-votes_links pull-right" id="votes{$post.id}">
                <table border="0" cellpadding="0" cellspacing="0"><tr>
                <td>{$post.rating|rating}</td>
                <td><a href="javascript:void(0);" onclick="forum.votePost({$post.id}, -1);"><img border="0" alt="-" src="/templates/{template}/images/icons/comments/vote_down.gif" style="margin-left:8px"/></a></td>
                <td><a href="javascript:void(0);" onclick="forum.votePost({$post.id}, 1);"><img border="0" alt="+" src="/templates/{template}/images/icons/comments/vote_up.gif" style="margin-left:2px"/></a></td>
                </tr></table>
            </div>
        {/if}
            <div class="thread-post_content">
			<div class="thread-post_text">
			{$post.content_html}
			</div>
            {if $post.attached_files && $cfg.fa_on}
            <div id="attached_files_{$post.id}" class="thread-files">
                {include file='com_forum_attached_files.tpl'}
            </div>
            {/if}
            {if $post.edittimes}
            <div class="thread-post_editdate">{$LANG.EDITED}: {$post.edittimes|spellcount:$LANG.COUNT1:$LANG.COUNT2:$LANG.COUNT1} ({$LANG.LAST_EDIT}: {$post.peditdate})</div>
            {/if}
            {if $post.signature_html}
            <div class="thread-post_signature">{$post.signature_html}</div>
            {/if}			
			</div>
		</div>
        </div>
    </div>
    {$num=$num+1}
    {/foreach}
    </div>
    {$pagination}

    {else}
        <p>{$LANG.NOT_POST_BY_USER}</p>
    {/if}

{/if}