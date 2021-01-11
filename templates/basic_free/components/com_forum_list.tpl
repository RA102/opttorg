<div class="float_bar">
	{if $user_id}
		{if $forum.id}
	<a href="/forum/{$forum.id}/newthread.html" class="btn btn-primary">{$LANG.NEW_THREAD}</a>
		{/if} 
	<a href="/forum/my_activity.html" class="btn btn-default">{$LANG.MY_ACTIVITY}</a>
	<a href="/forum/latest_posts" class="btn btn-default">{$LANG.LATEST_POSTS}</a>
	<a href="/forum/latest_thread" class="btn btn-default">{$LANG.NEW_THREADS}</a>
	{else}
	<a href="/forum/latest_posts" class="btn btn-default">{$LANG.LATEST_POSTS}</a> 
	<a href="/forum/latest_thread" class="btn btn-default">{$LANG.NEW_THREADS}</a>
	{/if}
</div>
<h1 class="con_heading">{$pagetitle}{if $cfg.is_rss} <a href="/rss/forum/{if $forum}{$forum.id}{else}all{/if}/feed.rss"><span class="glyphicon glyphicon-signal"></span></a>{/if}</h1>
{if $forums}
<div class="forum-list">
    {$row=1}
    {foreach key=fid item=forum from=$forums}
        {if $forum.cat_title != $last_cat_title}
    <div class="row forum-list-title">
        <div class="col-sm-6 col-xs-12"><a href="/forum/{$forum.cat_seolink}">{$forum.cat_title}</a></div>
        <div class="col-sm-3 hidden-xs">{$LANG.FORUM_ACT}</div>
        <div class="col-sm-3 hidden-xs">{$LANG.LAST_POST}</div>
    </div>
        {/if}	
	<div class="row {$class}">
        {if $row % 2}{$class='row11'}{else}{$class='row2'}{/if}
            <div class="col-sm-6 col-xs-12 forum-name">
				<img src="{$forum.icon_url}" class="forum-icon" border="0" />
                <div class="forum-link"><a href="/forum/{$forum.id}">{$forum.title}</a></div>
                <div class="forum-desc">{$forum.description}</div>
                {if $forum.sub_forums}
                    <div class="forum-subs"><span class="forum-subs-title">{$LANG.SUBFORUMS}: </span>
                        {foreach key=sid item=sub_forum from=$forum.sub_forums}
                            {if $comma}, {/if}
                            <a href="/forum/{$sub_forum.id}" class="forum-subs-link" title="{$sub_forum.description|escape:'html'}">{$sub_forum.title}</a>
                            {$comma=1}
                        {/foreach}
                        {$comma=0}
                    </div>
                {/if}
            </div>
            <div class="col-sm-3 col-xs-12">
				<div class="forum-serve">
                {if $forum.thread_count}
                    <strong>{$LANG.THREADS}:</strong> {$forum.thread_count}
                {else}
                    {$LANG.NOT_THREADS}
                {/if}
                <br/><strong>{$LANG.MESSAGES}:</strong> {$forum.post_count}
				</div>
            </div>
            <div class="col-sm-3 col-xs-12">
				<div class="forum-serve">			
                {if $forum.last_msg_array}
                    <strong><span class="hidden-lg hidden-md hidden-sm">{$LANG.LATEST_POSTS} </span>{$LANG.IN_THREAD}: {$forum.last_msg_array.thread_link}</strong><br/>
                    {$forum.last_msg_array.fpubdate} {$LANG.FROM} {$forum.last_msg_array.user_link}
                {else}
                    {$LANG.NOT_POSTS}
                {/if}
				</div>				
            </div>
        {$last_cat_title=$forum.cat_title}
        {$row=$row+1}
	</div>
    {/foreach}
</div>
{/if}