{foreach key=tid item=club from=$clubs}
<div class="media">
    <a href="/clubs/{$club.id}" title="{$club.title|escape:'html'}" class="{$club.clubtype} pull-left">
        <img src="/images/clubs/small/{$club.imageurl}" class="media-object" />
    </a>
  <div class="media-body">
    <h5 class="media-heading"><a href="/clubs/{$club.id}" class="{$club.clubtype}" {if $club.clubtype=='private'}title="{$LANG.PRIVATE}"{/if}>{if $club.is_vip}<span title="{$LANG.VIP_CLUB}" class="glyphicon glyphicon-bookmark" style="color:orange;"></span> {/if}{$club.title}</a></h5>
            <div class="media-hinttext">
<span class="monospc" title="{$LANG.RATING}"><span class="glyphicon glyphicon-star"></span> {$club.rating}</span>
<span class="monospc" title="{$club.members_count|spellcount:$LANG.CLUB_USER:$LANG.CLUB_USER2:$LANG.CLUB_USER10}"><span class="glyphicon glyphicon-user"></span> {$club.members_count}</span> <span><span class="glyphicon glyphicon-time"></span>{$club.fpubdate}</span>			
            </div>
  </div>
</div>
{/foreach}