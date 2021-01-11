{if $is_access}
                {if $is_member || $is_admin || $is_moder || $user_id}
                <div class="float_bar">
                    {if $user_id}
                        {if ($is_member || $is_admin || $is_moder) && $club.clubtype=='public'}
                        	<a class="btn btn-default" href="javascript:void(0)" onclick="clubs.intive({$club.id});return false;">{$LANG.INVITE}</a>
                        {/if}
                        {if $is_member}
                        	<a class="btn btn-default" href="javascript:void(0)" onclick="clubs.leaveClub({$club.id}, '{csrf_token}');return false;">{$LANG.LEAVE_CLUB}</a>
                        {elseif $club.admin_id != $user_id}
                        	<a class="btn btn-primary" href="javascript:void(0)" onclick="clubs.joinClub({$club.id});return false;">{$LANG.JOIN_CLUB}</a>
                        {/if}
                    {/if}
                    {if $is_admin}
                        <a class="btn btn-default" href="/clubs/{$club.id}/config.html" title="{$LANG.CONFIG_CLUB}"><span class="glyphicon glyphicon-cog"></span></a>
                    	<a class="btn btn-default" href="javascript:void(0)" onclick="clubs.sendMessages({$club.id});return false;" title="{$LANG.SEND_MESSAGE_TO_MEMBERS}"><span class="glyphicon glyphicon-envelope"></span></a>
                    {/if}					
                </div>
                {/if}
{/if}	

		<h1 class="con_heading{if $club.is_vip} text-warning{/if}">{if $club.is_vip}<span class="glyphicon glyphicon-bookmark"></span> {/if}{$club.title}</h1>
{if $is_access}
<div class="row">
	<div class="col-md-4 media-gird">
		<img src="/images/clubs/{$club.f_imageurl}" alt="{$club.title}" class="media-object" style="margin-bottom:20px;" />
	<div class="panel panel-{if $club.is_vip}warning{else}default{/if}">
		<div class="panel-heading">
			<h4 class="panel-title">{$LANG.CLUB_MEMBERS}</h4>
		</div>
		<div class="panel-body">
<div class="media">
  <a class="pull-left" href="{profile_url login=$club.login}">
    <img class="media-object" src="{$club.admin_avatar}" />
  </a>
  <div class="media-body">
	<h4 class="media-heading monospc"><a href="{profile_url login=$club.login}"><span title="{$LANG.CLUB_ADMIN}" class="glyphicon glyphicon-bookmark text-danger"></span> {$club.nickname}</a></h4>
	<div class="media-hinttext">{$club.flogdate}</div>
  </div>
</div>
{if $club.moderators}
{foreach key=tid item=moderator from=$club.moderators_list}
<div class="media">
  <a class="pull-left" href="{profile_url login=$moderator.login}">
    <img class="media-object" src="{$moderator.admin_avatar}" /> 
  </a>
  <div class="media-body">
	<h4 class="media-heading monospc"><a href="{profile_url login=$moderator.login}"><span title="{$LANG.MODERATOR}" class="glyphicon glyphicon-bookmark text-warning"></span> {$moderator.nickname}</a></h4>
	<div class="media-hinttext">{if $moderator.is_online}<span class="online" title="{$LANG.ONLINE}">{$LANG.ONLINE}</span>{/if}</div>
  </div>  
</div>		
{/foreach}			
{/if}					
{if $club.members_list}	
{foreach key=tid item=member from=$club.members_list}
<div class="media">
  <a class="pull-left" href="{profile_url login=$member.login}">
    <img class="media-object" src="{$member.admin_avatar}" />
  </a>
  <div class="media-body">
	<h4 class="media-heading monospc"><a href="{profile_url login=$member.login}">{$member.nickname}</a></h4>
	<div class="media-hinttext">{if $member.is_online}<span class="online" title="{$LANG.ONLINE}">{$LANG.ONLINE}</span>{/if}</div>
  </div>   
</div>	
{/foreach}
{/if}
		</div>
		<div class="panel-footer"><a class="monospc" href="/clubs/{$club.id}/members-1">{$LANG.CLUB_MEMBERS} ({$club.members})</a></div>	
	</div>
    {if $club.enabled_blogs}			
        <div class="panel panel-{if $club.is_vip}warning{else}default{/if}">
			<div class="panel-heading">
				<h4 class="panel-title">{$LANG.CLUB_BLOG}</h4>
			</div>
            <div class="panel-body">
{if $club.blog_posts}
{foreach key=id item=post from=$club.blog_posts}			
<div class="{cycle values="rowa1,rowa2"}" style="padding:10px;"><span class="glyphicon glyphicon-list-alt"></span> <a href="{$post.url}" title="{$post.title|escape:'html'}" class="club_post_title">{$post.title}</a><div class="media-hinttext"><a href="{profile_url login=$post.login}" class="club_post_author">{$post.author}</a>, {if !$post.published}<span style="color:#CC0000">{$LANG.ON_MODERATE}</span>{else}{$post.fpubdate}{/if}{if ($post.comments_count > 0)}, {$post.comments_count|spellcount:$LANG.COMMENT:$LANG.COMMENT2:$LANG.COMMENT10}{/if}</div></div>
{/foreach}
{else}
{$LANG.NO_BLOG_POSTS}. {if $is_admin || $is_moder || $is_blog_karma_enabled}<a href="/clubs/{$club.id}/newpost.html" title="{$LANG.NEW_POST}">{$LANG.NEW_POST}.</a>{/if}
{/if}
            </div>
			<div class="panel-footer"><a href="/clubs/{$club.id}_blog" class="monospc" title="{$LANG.POSTS_RSS} ({$club.total_posts})">Все ({$club.total_posts})</a>{if $is_admin || $is_moder || $is_blog_karma_enabled} <a href="/clubs/{$club.id}/newpost.html" class="monospc" title="{$LANG.NEW_POST}">{$LANG.NEW_POST}</a>{/if}</div>				
        </div>
    {/if}	
	</div>
	<!-- РАЗДЕЛЕНИЕ КОЛОНОК -->
	<div class="col-md-8">
	<div class="panel panel-{if $club.is_vip}warning{else}default{/if}">
		<div class="panel-heading">
			<h4 class="panel-title">                    {if $club.is_vip}
            <span class="monospc"><span class="glyphicon glyphicon-bookmark"></span> {$LANG.VIP_CLUB}</span> 
                    {else}
            <span class="monospc"><span class="glyphicon glyphicon-star"></span> {$club.rating}</span> 
                    {/if}
            <span class="monospc"><span class="glyphicon glyphicon-user"></span> {$club.members}</span> 
            <span class="monospc"><span class="glyphicon glyphicon-time"></span> {$club.fpubdate}</span></h4>
		</div>
		<div class="panel-body">
	{if $club.description}
	{$club.description}
	{/if}	
		</div>
	</div>	
	{if $club.enabled_photos}
	<div class="panel panel-{if $club.is_vip}warning{else}default{/if}">
		<div class="panel-heading">
			<h4 class="panel-title">{$LANG.PHOTOALBUMS}</h4>
		</div>
		<div class="panel-body" id="album_list">{include file='com_clubs_albums.tpl'}</div>
		<div class="panel-footer">{if $club.all_albums > 1}<a class="monospc" href="/clubs/{$club.id}/photoalbums" title="{$LANG.ALL_ALBUMS} ({$club.all_albums})">{$LANG.ALL_ALBUMS} ({$club.all_albums})</a>{/if} {if $is_admin || $is_moder || $is_photo_karma_enabled}<a class="monospc" href="javascript:void(0)" onclick="clubs.addAlbum({$club.id});" title="{$LANG.ADD_PHOTOALBUM}">{$LANG.ADD_PHOTOALBUM}</a>{/if}</div>	
	</div>
	{/if}
				{if $plugins}
                    {foreach key=id item=plugin from=$plugins}
                    	{if !is_array($plugin.html) }
                        	<div id="plugin_{$plugin.name}" class="panel panel-{if $club.is_vip}warning{else}default{/if}">{$plugin.html}</div>
                        {/if}
                    {/foreach}
                {/if}

		<div class="panel panel-{if $club.is_vip}warning{else}default{/if}"> 
            <div class="panel-heading">
				<h4 class="panel-title">{$LANG.CLUB_WALL}</h4>
			</div>
            <div class="panel-body">
                	<div class="wall_body">{$club.wall_html}</div>
            </div>
			<div class="panel-footer"><a href="javascript:void(0)" id="addlink" onclick="addWall('clubs', '{$club.id}');return false;">{$LANG.WRITE_ON_WALL}</a></div>		
        </div>

	</div>
</div>
{else}
    <p class="text-danger">{$LANG.CLUB_PRIVATE}</p>
    <p>{$LANG.CLUB_ADMIN}: <a href="{profile_url login=$club.login}">{$club.nickname}</a></p>
{/if}