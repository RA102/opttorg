{foreach key=tid item=usr from=$users}
<div class="media {cycle values="rowa1,rowa2"}">
  <a class="pull-left" href="{profile_url login=$usr.login}"><img class="media-object" src="{$usr.avatar}" /></a>
  <div class="media-body">
                {if $cfg.view_type == 'rating'}
                    <div class="pull-right rating">{$usr.rating|rating}</div>
                {else}
                    <div class="pull-right karma">{$usr.karma|rating}</div>
                {/if}  
    <h4 class="media-heading">{$usr.user_link}</h4>
                {if $usr.microstatus}
                	<div class="media-hinttext">{$usr.microstatus}</div>
                {/if}
  </div>
</div>
{/foreach}