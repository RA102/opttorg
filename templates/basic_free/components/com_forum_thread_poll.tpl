<div class="row">
    <div class="col-md-8">
		<div class="thread-poll-title"><h3>{$thread_poll.title}</h3></div>
		<div class="thread-poll-desc">{$thread_poll.description}</div>
		{if !$user_id && ($thread_poll.options.result == 1 || ($thread_poll.options.result == 2 && !$thread_poll.is_closed))}
			<p>{$LANG.GUESTS_NOT_VOTE}</p>
		{else}		
            <div class="forum_poll_param"><b>{$LANG.TOTAL_VOTES}:</b> {$thread_poll.vote_count}</div>
            {if is_string($thread_poll.is_user_vote)}
                <div class="forum_poll_param"><b>{$LANG.YOUR_ANSWER}:</b> {$thread_poll.is_user_vote}</div>
            {/if}
            {if !$thread_poll.is_closed && !$thread.closed}
                <div class="forum_poll_param"><b>{$LANG.END_DATE_POLL}:</b> {$thread_poll.fenddate}</div>
                <div class="forum_poll_param"><b>{$LANG.RESULTS}:</b> {$thread_poll.options.result_text}</div>
                <div class="forum_poll_param"><b>{$LANG.ANSWER_CHANGING}:</b> {$thread_poll.options.change_text}</div>

                {if !$thread_poll.is_user_vote && !$thread_poll.options.result}
                    {if $do == 'thread'}
                        <div class="forum_poll_param"><a href="javascript:" onclick="forum.loadForumPoll({$thread.id}, 1);">{$LANG.RESULT_POLL}</a> </div>
                    {elseif $do == 'view_poll'}
                        <div class="forum_poll_param"><a href="javascript:" onclick="forum.loadForumPoll({$thread.id}, 0);">{$LANG.REMOVE_RESULT}</a> </div>
                    {/if}
                {/if}

                {if is_string($thread_poll.is_user_vote) && $thread_poll.options.change}
                     <div class="forum_poll_param"><a href="javascript:" onclick="forum.revotePoll({$thread.id});">{$LANG.CHANGE_VOTE}</a> </div>
                {/if}

                {if $is_admin || $is_moder}
                    <div class="forum_poll_param"><a href="javascript:" onclick="forum.deletePoll({$thread.id}, '{csrf_token}');">{$LANG.DELETE_POLL}</a> </div>
                {/if}

            {else}
                <div class="forum_poll_param" style="color:#660000"><b>{$LANG.POLL_FINISHED}</b></div>
            {/if}

            {if $user_id && !$thread.closed}
                <div class="forum_poll_param"><a href="/forum/reply{$thread.id}.html">{$LANG.COMMENT_POLL}</a></div>
            {/if}
		{/if}
    </div>
    <div class="col-md-4">
        {if !$thread_poll.show_result && $thread.closed && $thread_poll.options.result == 1 && !$thread_poll.is_user_vote}
            {$LANG.YOU_IS_NOT_VOTE_IN_CLOSED}
        {elseif !$thread_poll.show_result && is_string($thread_poll.is_user_vote) && $thread_poll.options.result == 2 && !$thread_poll.is_closed && !$thread.closed}
            {$LANG.YOU_IS_VOTE}
        {elseif !$thread_poll.show_result && !$thread_poll.is_user_vote && !$thread.closed && !$thread_poll.is_closed}
            <form action="/forum/vote_poll" method="post" id="forum_poll_submit_form">
                <input type="hidden" name="csrf_token" value="{csrf_token}" />
                <input type="hidden" name="poll_id" value="{$thread_poll.id}" />
                <input type="hidden" name="id" id="thread_id" value="{$thread.id}" />
                <table class="table table-striped">
                {foreach key=answer item=num from=$thread_poll.answers}
                    <tr>
                      <td class="mod_poll_answer">
                          <label>
                              <input name="answer" type="radio" value="{$answer|escape:'html'}" /> {$answer}
                          </label>
                      </td>
                    </tr>
                 {/foreach}
                 </table>
                 <div class="forum_poll_submit"><input id="forum_poll_submit" type="button" value="{$LANG.VOTING}" onclick="threadPollSubmit();" class="btn btn-default" /></div>
             </form>
             <script type="text/javascript" src="/includes/jquery/jquery.form.js"></script>
            <script type="text/javascript">
                var LANG_ATTENTION = '{$LANG.ATTENTION}';
            function threadPollSubmit(){
                $('#forum_poll_submit').prop('disabled', true);
                var options = {
                    success: loadForumPoll
                };
                $('#forum_poll_submit_form').ajaxSubmit(options);
            }
            function loadForumPoll(result, statusText, xhr, $form){
                if(statusText == 'success'){
                    if(result.error == false){
                        thread_id = $('#thread_id').val();
                        $.post('/forum/viewpoll'+thread_id, { }, function(data){
                            $('#thread_poll').html(data);
                        });
                    } else {
                        core.alert(result.text, LANG_ATTENTION);
                        $('#forum_poll_submit').prop('disabled', false);
                    }
                }

            }
            </script>
        {else}
            {foreach key=answer item=num from=$thread_poll.answers}

                {$percent = $num/$thread_poll.vote_count*100}

                <span class="poll_gauge_title">{$answer|truncate:50} <i class="pull-right">{$num}</i></span>
                {if $percent > 0}
                 <div class="pollgauge"><table class="mod_poll_gauge" width="{$percent|ceil}%"><tr><td></td></tr></table></div>
                {else}
                 <div class="pollgauge"><table class="mod_poll_gauge" width="5"><tr><td></td></tr></table></div>
                {/if}

            {/foreach}
        {/if}
    </div>	
</div>