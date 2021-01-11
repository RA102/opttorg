<h1 class="con_heading">{$LANG.CLUB_MEMBERS} - {$club.title} ({$total_members+1})</h1>
{if $page==1}
<div class="media rowa2">
  <a class="pull-left"  href="{profile_url login=$club.login}"><img class="media-object" src="{$club.admin_avatar}" /></a>
  <div class="media-body">
        {if $club.is_online}
            <span class="online pull-right">{$LANG.ONLINE}</span>
        {else}
            <span class="offline pull-right">{$club.logdate}</span>
        {/if}
		<h4 class="media-heading"> 
		<a href="{profile_url login=$club.login}" title="{$LANG.CLUB_ADMIN}"><span class="glyphicon glyphicon-bookmark text-danger" title="{$LANG.CLUB_ADMIN}"></span> {$club.nickname}</a>
		<span title="{$LANG.KARMA}" style="{if $club.karma > 0}color:green;{/if}{if $club.karma < 0}color:red;{/if}">{if $club.karma > 0}+{/if}{$club.karma}</span>
		</h4>
		{if $club.status}
		<div class="media-hinttext"><span class="glyphicon glyphicon-volume-up"></span> {$club.status}</div>
		{/if} 	
  </div>
</div>	
{/if}
  {foreach key=tid item=usr from=$members}
 <div class="media {cycle values="rowa1,rowa2"}">
  <a class="pull-left"  href="{profile_url login=$usr.login}"><img class="media-object" src="{$usr.admin_avatar}" /></a>
  <div class="media-body">
        {if $usr.is_online}
            <span class="online pull-right">{$LANG.ONLINE}</span>
        {else}
            <span class="offline pull-right">{$usr.logdate}</span>
        {/if}
		<h4 class="media-heading">
		<a href="{profile_url login=$usr.login}">{if $usr.role=='moderator'}<span class="glyphicon glyphicon-bookmark text-warning" title="{$LANG.MODERATOR}"></span>{/if} {$usr.nickname}</a>
		<span title="{$LANG.KARMA}" style="{if $usr.karma > 0}color:green;{/if}{if $usr.karma < 0}color:red;{/if}">{if $usr.karma > 0}+{/if}{$usr.karma}</span>
		</h4>
		{if $usr.status}
		<div class="media-hinttext"><span class="glyphicon glyphicon-volume-up"></span> {$usr.status}</div>
		{/if} 	
  </div>
</div> 
  {/foreach}	 
{$pagebar}