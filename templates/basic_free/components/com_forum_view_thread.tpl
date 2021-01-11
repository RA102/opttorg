{if $user_id}
<div class="float_bar">
        {include file='com_forum_toolbar.tpl'}
</div>
{/if}
<h1 class="con_heading" id="thread_title">{$thread.title}</h1>
<div id="thread_description" class="item-description" {if !$thread.description}style="display: none"{/if}>{$thread.description}</div>
<div class="thread-table">
    {foreach key=pid item=post from=$posts name=thread}
    <div class="row thread-title">
        <div class="col-lg-12">
            <div class="post_date" style="float:left;">{if $post.pinned && $num > 1}<img src="/templates/{template}/images/icons/forum/sticky.png" width="14px;" alt="{$LANG.ATTACHED_MESSAGE}" title="{$LANG.ATTACHED_MESSAGE}" />  {/if}<a name="{$post.id}" href="/forum/thread{$thread.id}-{$page}.html#{$post.id}">#{$num}</a> - {$post.fpubdate}, {$post.wday}</div>
            {if $user_id && !$thread.closed}
                <div class="msg_links" style="float:right;">
                    <a href="javascript:" onclick="forum.addQuoteText(this);return false;" rel="{$post.nickname|escape:html}" class="ajaxlink" title="{$LANG.ADD_SELECTED_QUOTE}">{$LANG.ADD_QUOTE_TEXT}</a> | <a href="/forum/thread{$thread.id}-quote{$post.id}.html" title="{$LANG.REPLY_FULL_QUOTE}">{$LANG.REPLY}</a>
                    {if $is_admin || $is_moder || $post.is_author_can_edit}
                        | <a href="/forum/editpost{$post.id}-{$page}.html">{$LANG.EDIT}</a>
                        {if $num > 1}
                            {if $is_admin || $is_moder}
                                | <a href="javascript:" onclick="forum.movePost('{$thread.id}','{$post.id}');return false;" class="ajaxlink" title="{$LANG.MOVE_POST}">{$LANG.MOVE}</a>
                                {if !$post.pinned}
                                | <a href="/forum/pinpost{$thread.id}-{$post.id}.html">{$LANG.PIN}</a>
                                {else}
                                | <a href="/forum/unpinpost{$thread.id}-{$post.id}.html">{$LANG.UNPIN}</a>
                                {/if}
                            {/if}
                            | <a href="javascript:" class="ajaxlink" onclick="forum.deletePost({$post.id}, '{csrf_token}', {$page});">{$LANG.DELETE}</a>
                        {/if}
                    {/if}
                </div>
            {/if}
        </div>
    </div>
    <div class="row thread-body">
        <div class="col-md-2 col-sm-3">
			<div class="well">
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
            <div>{$post.flogdate}</div>
			</div>
        </div>
        <div class="col-md-10 col-sm-9">
		<div class="thread-right">
{if $thread_poll && $smarty.foreach.thread.first}
<div id="thread_poll" class="bb_quote" style="margin-top:0;margin-bottom:20px;">{include file='com_forum_thread_poll.tpl'}</div>
{/if}			
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
{if $page == $lastpage}<a name="new"></a>{/if}

<div class="thread-bottom clearfix row margin-bottom-row">
    <div class="col-md-5">
	<a class="btn btn-default" href="#" title="{$LANG.GOTO_BEGIN_PAGE}">&uarr;</a>
	{if $prev_thread}
<a href="/forum/thread{$prev_thread.id}.html" class="btn btn-default" title="{$prev_thread.title}">&larr; {$LANG.PREVIOUS_THREAD}</a>
    {/if}
    {if $next_thread}
<a href="/forum/thread{$next_thread.id}.html" class="btn btn-default" title="{$next_thread.title}">{$LANG.NEXT_THREAD} &rarr;</a>
    {/if}
	</div>	
	<div class="col-md-3">
	        <select name="goforum" id="goforum" onchange="window.location.href = '/forum/' + $(this).val();">
            {foreach key=fid item=item from=$forums}
                {if $item.cat_title != $last_cat_title}
                    {if $last_cat_title}</optgroup>{/if}
                    <optgroup label="{$item.cat_title|escape:html}">
                {/if}
                <option value="{$item.id}" {if $item.id == $forum.id} selected="selected" {/if}>{$item.title}</option>
                {if $item.sub_forums}
                    {foreach key=sid item=sub_forum from=$item.sub_forums}
                        <option value="{$sub_forum.id}" {if $sub_forum.id == $forum.id} selected="selected" {/if}>--- {$sub_forum.title}</option>
                    {/foreach}
                {/if}
                {$last_cat_title=$item.cat_title}
            {/foreach}
            </optgroup>
            </select>	
	</div>
	{if $user_id}
    <div class="col-md-4 for-tul">
        {include file='com_forum_toolbar.tpl'}
    </div>
	{/if}
</div>

<div style="text-align:center;">{$pagebar}</div>

{if $cfg.fast_on && !$thread.closed}
<div class="thread-fast">
<div class="panel panel-default">
	<div class="panel-heading">
    <h4 class="panel-title"><span class="glyphicon glyphicon-pencil"></span> {$LANG.FAST_ANSWER}</h4>
	</div>
	<div class="panel-body">
    {if $user_id && $is_can_add_post}
	<div class="thread-form">
        {if $cfg.fast_bb}
            <div class="usr_msg_bbcodebox">
                {$bb_toolbar}
            </div>
            {$smilies}
        {/if}
        <div class="forum_fast_form">
            <form action="/forum/reply{$thread.id}.html" method="post" id="msgform">
                <input type="hidden" name="gosend" value="1" />
                <input type="hidden" name="csrf_token" value="{csrf_token}" />
                <div class="cm_editor">
                    <textarea id="message" name="message" rows="7"></textarea>
                </div>
				<div class="pull-right" style="padding:10px 0 20px 0;">
                {if $is_admin || $is_moder || $thread.is_mythread}
                 <label><input type="checkbox" name="fixed" value="1" /> {$LANG.TOPIC_FIXED_LABEL}</label>
                {/if}				
                <input type="button" value="{$LANG.SEND}" style="margin-left:10px;" class="copa-button navy-button nano-button" onclick="$(this).prop('disabled', true);$('#msgform').submit();" />
				</div>
            </form>
        </div>
	</div>
    {else}
        <div style="padding:5px">{$LANG.FOR_WRITE_ON_FORUM}.</div>
    {/if}
	</div>
</div>
</div>
{/if}

{if $user_id}
<script type="text/javascript" language="JavaScript">
    $(document).ready(function(){
        $('.msg_links').css({ opacity:0.4, filter:'alpha(opacity=40)' });
        $('.thread-title').hover(
            function() {
                $(this).prev().find('.msg_links').css({ opacity:1.0, filter:'alpha(opacity=100)' });
            },
            function() {
                $(this).prev().find('.msg_links').css({ opacity:0.4, filter:'alpha(opacity=40)' });
            }
        );
        $('.msg_links').hover(
            function() {
                $(this).css({ opacity:1.0, filter:'alpha(opacity=100)' });
            },
            function() {
                $(this).css({ opacity:0.4, filter:'alpha(opacity=40)' });
            }
        );
    });
</script>
{/if}