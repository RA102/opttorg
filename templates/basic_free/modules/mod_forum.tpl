    <div class="actions_list">
    {foreach key=tid item=thread from=$threads}
            <div class="action_entry {cycle values="rowa1,rowa2"}">
                <span class="pull-right action_date{if $thread.is_new} is_new{/if}"><span class="glyphicon glyphicon-time"></span> {$thread.last_msg_array.fpubdate}</span>
                <div class="action_title act_add_thread">
                    <span class="action_user">{$thread.last_msg_array.user_link} {if $thread.last_msg_array.post_count == 1}{$LANG.FORUM_START_THREAD}{else}{$LANG.FORUM_REPLY_THREAD}{/if} &laquo;{$thread.last_msg_array.thread_link}&raquo; {if $cfg.showforum} {$LANG.FORUM_ON_FORUM} &laquo;<a href="/forum/{$thread.forum_id}">{$thread.forum_title}</a>&raquo;{/if}</span>
                </div>
				{if $cfg.showtext}
				<div class="action_details">{$thread.last_msg_array.content_html|strip_tags|truncate:200}</div>   
				{/if}
            </div>
    {/foreach}
	</div>