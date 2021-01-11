<div class="forum-list">
    <div class="row forum-list-title">
        <div class="col-sm-6 col-xs-12">{$LANG.THREADS}</div>
        <div class="col-sm-3 hidden-xs">{$LANG.FORUM_ACT}</div>
        <div class="col-sm-3 hidden-xs">{$LANG.LAST_POST}</div>
    </div>
{if $threads}
    {$row=1}
    {foreach key=id item=thread from=$threads}
    <div class="row {$class}">
	 {if $row % 2}{$class='row11'}{else}{$class='row2'}{/if}
		<div class="col-sm-6 col-xs-12 forum-name">
            {if $thread.pinned}
               <img class="forum-icon" alt="{$LANG.ATTACHED_THREAD}" src="/templates/{template}/images/icons/forum/pinned.png" border="0" title="{$LANG.ATTACHED_THREAD}" />
            {else}
                {if $thread.closed}
                    <img class="forum-icon" alt="{$LANG.THREAD_CLOSE}" src="/templates/{template}/images/icons/forum/closed.png" border="0" title="{$LANG.THREAD_CLOSE}" />
                {else}
                    {if $thread.is_new}
                        <img class="forum-icon" alt="{$LANG.HAVE_NEW_MESS}" src="/templates/{template}/images/icons/forum/new.png" border="0" title="{$LANG.HAVE_NEW_MESS}" />
                    {else}
                       <img class="forum-icon" alt="{$LANG.NOT_NEW_MESS}" src="/templates/{template}/images/icons/forum/old.png" border="0" title="{$LANG.NOT_NEW_MESS}" />
                    {/if}
                {/if}
            {/if}
            <div class="forum-link"><a href="/forum/thread{$thread.id}.html">{$thread.title}</a></div>
                    {if $thread.pages>1}
                        <div class="forum-subs" title="{$LANG.PAGES}"> 
                            {section name=foo start=1 loop=$thread.pages+1 step=1}
                                {if $smarty.section.foo.index > 5 && $thread.pages > 6}
                                    ...<a href="/forum/thread{$thread.id}-{$thread.pages}.html" title="{$LANG.LAST}">{$thread.pages}</a>
                                    {break}
                                {else}
                                    <a href="/forum/thread{$thread.id}-{$smarty.section.foo.index}.html" title="{$LANG.PAGE} {$smarty.section.foo.index}">{$smarty.section.foo.index}</a>
                                    {if $smarty.section.foo.index < $thread.pages}, {/if}
                                {/if}
                            {/section}
                        </div>
                    {/if}
                {if $thread.description}
                    <div class="forum-desc">{$thread.description}</div>
                {/if}
        </div>
        <div class="col-sm-3 col-xs-12">
			<div class="forum-serve">
		        <strong>{$LANG.AUTHOR}:</strong> <a rel="author" href="{profile_url login=$thread.login}">{$thread.nickname}</a><br />
                <strong>{$LANG.HITS}:</strong> {$thread.hits} | 
                <strong>{$LANG.REPLIES}:</strong> {$thread.answers}
			</div>
        </div>
        <div class="col-sm-3 col-xs-12">
			<div class="forum-serve">
                {if $thread.last_msg_array}
                    <a href="/forum/thread{$thread.last_msg_array.thread_id}-{$thread.last_msg_array.lastpage}.html#{$thread.last_msg_array.id}" title="{$LANG.GO_LAST_POST}"><img class="last_post_img" alt="{$LANG.GO_LAST_POST}" src="/templates/{template}/images/icons/anchor.png"></a>
                    <span class="hidden-lg hidden-md hidden-sm">{$LANG.LAST_POST} </span>{$LANG.FROM} {$thread.last_msg_array.user_link}<br/>
                    {$thread.last_msg_array.fpubdate}
                {else}
                    {$LANG.NOT_POSTS}
                {/if}
			</div>
        </div>
	</div>
        {$row=$row+1}
    {/foreach}

{else}
    <div class="row">
        <div class="col-lg-12">{$LANG.NOT_THREADS_IN_FORUM}.</div>
    </div>
{/if}
</div>
{$pagination}

{if $show_panel}
    {if $moderators}<p class="forum-moders">{$LANG.THIS_FORUM_MODERS}: {foreach key=id item=moderator from=$moderators}{if $q}, {/if}<a href="{profile_url login=$moderator.login}">{$moderator.nickname}</a>{$q="1"}{/foreach}</p>{/if}


<h4>{$LANG.OPTIONS_VIEW}</h4>
			<form action="" method="post">
				<div class="row forum-form">
                    <div class="col-md-3">
                          <div>{$LANG.THREAD_ORDER}</div>
                            <select name="order_by">
                              <option value="title" {if $order_by == 'title'}selected="selected"{/if}>{$LANG.TITLE}</option>
                              <option value="pubdate" {if $order_by == 'pubdate'}selected="selected"{/if}>{$LANG.ORDER_DATE}</option>
                              <option value="post_count" {if $order_by == 'post_count'}selected="selected"{/if}>{$LANG.ANSWER_COUNT}</option>
                              <option value="hits" {if $order_by == 'hits'}selected="selected"{/if}>{$LANG.HITS_COUNT}</option>
                            </select>
                    </div>
                    <div class="col-md-3">
                        <div>{$LANG.ORDER_TO}</div>
                        <select name="order_to">
                          <option value="asc" {if $order_to == 'asc'}selected="selected"{/if}>{$LANG.ORDER_ASC}</option>
                          <option value="desc" {if $order_to == 'desc'}selected="selected"{/if}>{$LANG.ORDER_DESC}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div>{$LANG.SHOW}</div>
                        <select name="daysprune">
                          <option value="1" {if $daysprune == 1}selected="selected"{/if}>{$LANG.SHOW_DAY}</option>
                          <option value="7" {if $daysprune == 7}selected="selected"{/if}>{$LANG.SHOW_W}</option>
                          <option value="30" {if $daysprune == 30}selected="selected"{/if}>{$LANG.SHOW_MONTH}</option>
                          <option value="365" {if $daysprune == 365}selected="selected"{/if}>{$LANG.SHOW_YEAR}</option>
                          <option value="all" {if !$daysprune}selected="selected"{/if}>{$LANG.SHOW_ALL}</option>
                        </select>
					</div>
                    <div class="col-md-3">
                        <div style="color:#fff;">-</div>
                        <input type="submit" value="{$LANG.SHOW_THREADS}">
                    </div>
				</div>
            </form>

{/if}