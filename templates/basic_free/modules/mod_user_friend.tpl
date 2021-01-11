<div class="panel panel-{if $mod.css_prefix}{$mod.css_prefix}{else}default{/if}">
<div class="panel-heading">
    <h4 class="panel-title">{$LANG.FRIEND_ON_SITE} ({$total})</h4>
</div>
    <div class="panel-body">
        {if $total}
            {if $cfg.view_type == 'table'}
                {foreach key=tid item=frien from=$friends}
<div class="media {cycle values="rowa1,rowa2"}">
  <a class="pull-left" href="{profile_url login=$frien.login}">
    <img class="media-object" src="{$frien.avatar}" />
  </a>
  <div class="media-body">
    <h4 class="media-heading">{$frien.user_link}</h4>
  </div>
</div>
                {/foreach}
             {/if}
             {if $cfg.view_type == 'list'}
                {$now="0"}
                    {foreach key=tid item=frien from=$friends}
                        {$frien.user_link}
                        {$now=$now+1}
                        {if $now==$total}{else}, {/if}
                    {/foreach}
             {/if}
        {else}
            <div>{$LANG.FRIEND_NO_SITE}</div>
        {/if}	
	</div>
</div>