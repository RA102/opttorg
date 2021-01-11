<h1 class="con_heading"><a href="{profile_url login=$usr.login}">{$usr.nickname}</a> &rarr; {$LANG.FRIENDS} ({$total})</h1>
<div class="users_list">
    {if $friends}
    {foreach key=tid item=friend from=$friends}
<div class="media {cycle values="rowa1,rowa2"}" id="friend_id_{$friend.id}">
  <a class="pull-left" href="{profile_url login=$friend.login}">
    <img class="media-object" src="{$friend.avatar}" />
  </a>
  <div class="media-body">
           <div class="pull-right">
          	{$friend.flogdate}
          </div> 
    <h4 class="media-heading"><a href="{profile_url login=$friend.login}">{$friend.nickname}</a></h4>
	<div class="media-body" style="font-style:italic;"><a href="javascript:void(0)" class="ajaxlink" onclick="users.sendMess('{$friend.id}', 0, this);return false;" title="{$LANG.WRITE_MESS}: {$friend.nickname|escape:'html'}">{$LANG.WRITE_MESS}</a> {if $myprofile} | <a href="javascript:void(0)" title="{$friend.nickname|escape:'html'}" onclick="users.delFriend('{$friend.id}', this);return false;" class="ajaxlink">{$LANG.STOP_FRIENDLY}</a>{/if}</div>
          {if $friend.status}
          <div class="media-hinttext"><span class="glyphicon glyphicon-volume-up"></span> {$friend.status}</div>
          {/if} 
  </div>
</div>		
    {/foreach}
    {/if}
</div>
{$pagebar}