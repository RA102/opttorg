{if $can_create}
	<div class="pull-right" style="margin-top:3px;">
		{$LANG.YOU_CAN} <a href="javascript:void(0)" onclick="clubs.create(this);return false;">{$LANG.TO_CREATE_NEW_CLUB}</a>
	</div>
    <script type="text/javascript" src="/components/clubs/js/clubs.js"></script>
{/if}

<h3 style="margin:0">{$LANG.USER_CLUBS}</h3>

{if $clubs}
	{foreach key=tid item=club from=$clubs}
<div class="media">
	<a href="/clubs/{$club.id}" title="{$club.title|escape:'html'}" class="pull-left {$club.clubtype}"><img class="media-object" src="/images/clubs/small/{$club.imageurl}" alt="{$club.title|escape:'html'}"/></a>
  <div class="media-body">
    <h4 class="media-heading"><a href="/clubs/{$club.id}" class="{$club.clubtype}" {if $club.clubtype=='private'}title="{$LANG.PRIVATE}"{/if}>{if !$club.role}<span class="glyphicon glyphicon-bookmark text-danger" title="{$LANG.CLUB_ADMIN}"></span> 
{elseif $club.role != 'member'}<span class="glyphicon glyphicon-bookmark text-info" title="{$LANG.MODERATOR}"></span> {/if}{$club.title}</a></h4> 
				<div class="media-hinttext">
                    {if $club.is_vip}
                        <span class="monospc"><span class="glyphicon glyphicon-bookmark"></span> {$LANG.VIP_CLUB}</span>
                    {/if}
    				<span class="monospc"><span class="glyphicon glyphicon-star"></span> {$LANG.RATING} {$club.rating}</span> 
					<span class="monospc"><span class="glyphicon glyphicon-user"></span> {$club.members_count|spellcount:$LANG.CLUB_USER:$LANG.CLUB_USER2:$LANG.CLUB_USER10}</span>
                    <span class="monospc"><span class="glyphicon glyphicon-time"></span> {$club.fpubdate}</span>
				</div>
  </div>
</div>
	{/foreach}
	{if $pagination}{$pagination}{/if}
{else}
    {if $my_profile}
    	<p style="clear:both">{$LANG.YOU_NOT_IN_CLUBS}</p>
    {else}
        <p style="clear:both"><strong>{$user.nickname}</strong> {$LANG.USET_NOT_IN_CLUBS}</p>
    {/if}
{/if}
