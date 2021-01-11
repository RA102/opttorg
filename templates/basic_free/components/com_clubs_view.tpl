{if $can_create}
	<div class="float_bar club-bar">
		<a href="javascript:void(0)" class="btn btn-primary" onclick="clubs.create(this);return false;">{$LANG.TO_CREATE_NEW_CLUB}</a>
	</div>
{/if}
<h1 class="con_heading">{$pagetitle}</h1>
{if $clubs}
	{foreach key=tid item=club from=$clubs}
<div class="media {cycle values="rowb1,rowb2"}">
  <a class="pull-left" href="/clubs/{$club.id}" title="{$club.title|escape:'html'}"><img class="media-object" src="/images/clubs/small/{$club.imageurl}" alt="{$club.title|escape:'html'}" /></a>
  <div class="media-body">
    <h4 class="media-heading"><a href="/clubs/{$club.id}" class="{$club.clubtype}" {if $club.clubtype=='private'}title="{$LANG.PRIVATE}"{/if}>{if $club.is_vip}<span class="glyphicon glyphicon-bookmark text-danger"></span> {/if}{$club.title}</a></h4>
	<div class="media-description"><span class="glyphicon glyphicon-time"></span> {$club.fpubdate}</div>	
	<div class="media-hinttext">
<span class="monospc"><span class="glyphicon glyphicon-star"></span> {$LANG.RATING} {$club.rating}</span><span class="monospc"><span class="glyphicon glyphicon-user"></span> {$club.members_count|spellcount:$LANG.CLUB_USER:$LANG.CLUB_USER2:$LANG.CLUB_USER10}</span>
	</div>
  </div>
</div>
	{/foreach}
	{if $pagination}{$pagination}{/if}
{else}
	<p class="text-danger">{$LANG.NOT_ACTIVE_CLUBS}</p>
{/if}