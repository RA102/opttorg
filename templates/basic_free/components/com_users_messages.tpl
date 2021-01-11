{if $friends || $is_admin}
    <div class="float_bar">
        <a href="javascript:void(0)" class="btn btn-primary" onclick="users.sendMess(0, 0, this);return false;" title="{$LANG.NEW_MESS}:">{$LANG.WRITE}</a> {if ($opt!='history') && $msg_count>0}
<a href="javascript:void(0)" class="btn btn-default" onclick="users.cleanCat('/users/{$id}/delmessages-{$opt}.html');return false;">{$LANG.CLEAN_CAT} ({$msg_count})</a>
{/if}
    </div>
{/if}
<h1 class="con_heading">{$LANG.MY_MESS} ({$msg_count})</h1>
<div class="well">
{if $opt=='history'}
    <div class="float_bar" style="margin-top:0 !important;">
        <form action="" id="history" method="post">
            <select name="with_id" id="with_id" style="width:100%;max-width:300px;" onchange="changeFriend();">
                <option value="0">{$LANG.FRIEND_FOR_DIALOGS}</option>
                {if $interlocutors}
                    {$interlocutors}
                {/if}
            </select>
        </form>
    </div>
{/if}
<div class="usr_msgmenu_tabs">
    {if $opt == 'in'}
        <span class="btn btn-primary">{$page_title} {if $new_messages.messages}({$new_messages.messages}){/if}</span>
        <a class="btn btn-default" href="/users/{$id}/messages-sent.html">{$LANG.SENT}</a>
        <a class="btn btn-default" href="/users/{$id}/messages-notices.html">{$LANG.NOTICES} {if $new_messages.notices}({$new_messages.notices}){/if}</a>
        <a class="btn btn-default" href="/users/{$id}/messages-history.html">{$LANG.DIALOGS}</a>
    {elseif $opt == 'out'}
        <a class="btn btn-default" href="/users/{$id}/messages.html">{$LANG.INBOX} {if $new_messages.messages}({$new_messages.messages}){/if}</a>
        <span class="btn btn-primary">{$page_title}</span>
        <a class="btn btn-default" href="/users/{$id}/messages-notices.html">{$LANG.NOTICES} {if $new_messages.notices}({$new_messages.notices}){/if}</a>
        <a class="btn btn-default" href="/users/{$id}/messages-history.html">{$LANG.DIALOGS}</a>
    {elseif $opt == 'notices'}
        <a class="btn btn-default" href="/users/{$id}/messages.html">{$LANG.INBOX} {if $new_messages.messages}({$new_messages.messages}){/if}</a>
        <a class="btn btn-default" href="/users/{$id}/messages-sent.html">{$LANG.SENT}</a>
        <span class="btn btn-primary">{$page_title} {if $new_messages.notices}({$new_messages.notices}){/if}</span>
        <a class="btn btn-default" href="/users/{$id}/messages-history.html">{$LANG.DIALOGS}</a>
    {elseif $opt == 'history'}
        <a class="btn btn-default" href="/users/{$id}/messages.html">{$LANG.INBOX} {if $new_messages.messages}({$new_messages.messages}){/if}</a>
        <a class="btn btn-default" href="/users/{$id}/messages-sent.html">{$LANG.SENT}</a>
        <a class="btn btn-default" href="/users/{$id}/messages-notices.html">{$LANG.NOTICES} {if $new_messages.notices}({$new_messages.notices}){/if}</a>
        <span class="btn btn-primary">{$page_title}</span>
    {/if}
</div>
</div>
{if $records}
    {foreach key=tid item=record from=$records}
    <div class="media {cycle values="rowa1,rowa2"}" style="padding:10px;margin:0;" id="usr_msg_entry_id_{$record.id}">
                {if $record.sender_id > 0}
                    <a class="pull-left" style="text-align:center;" href="{profile_url login=$record.author_login}"><img class="media-object" src="{$record.user_img}"  /></a>
                {else}
                     <a class="pull-left"><img class="media-object" src="{$record.user_img}" /></a>
                {/if}	
  <div class="media-body">
   {if $record.sender_id > 0}<span class="pull-right">{$record.online_status}</span>{/if}
    <h4 class="media-heading">{$record.authorlink}, {$record.fpubdate}</h4>
	<div class="media-description">{$record.message}</div>
        <div class="media-hinttext">
            {if $record.is_new}
                {if $opt=='in' || $opt == 'notices'}
                    <span class="text-danger">{$LANG.NEW}!</span>&nbsp;&nbsp;
                {else}
                    <a href="javascript:void(0)" onclick="users.deleteMessage('{$record.id}')">{$LANG.CANCEL_MESS}</a>&nbsp;&nbsp;
                {/if}
            {/if}
            {if $opt=='in'}
                {if $record.sender_id>0}
                    <a href="javascript:void(0)" onclick="users.sendMess('{$record.from_id}', '{$record.id}', this);return false;" title="{$LANG.NEW_MESS}: {$record.author|escape:'html'}">{$LANG.REPLY}</a>&nbsp;&nbsp;
                    <a href="/users/{$id}/messages-history{$record.from_id}.html">{$LANG.HISTORY}</a>&nbsp;&nbsp;
                {/if}
            {/if}
            {if $opt == 'in' || (in_array($opt, array('out','history','notices')) && !$record.is_new)}
               <a href="javascript:void(0)" onclick="users.deleteMessage('{$record.id}')">{$LANG.DELETE}</a>&nbsp;&nbsp;
            {/if}
        </div>
  </div>
    </div>
    {/foreach}
    {$pagebar}
{/if}

<script type="text/javascript">
    function changeFriend(){
        fr_id = $("#with_id option:selected").val();
        if(fr_id != 0) {
            $("#history").attr("action", '/users/{$id}/messages-history'+fr_id+'.html');
            $('#history').submit();
        }
    }
</script>