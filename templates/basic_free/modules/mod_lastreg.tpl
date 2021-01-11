{if $cfg.view_type == 'table'}
  {foreach key=aid item=usr from=$usrs}
<div class="media">
  <a class="pull-left" href="{profile_url login=$usr.login}">
    <img class="media-object" src="{$usr.avatar}" />
  </a>
  <div class="media-body">
    <h5 class="media-heading"><a href="{profile_url login=$usr.login}">{$usr.nickname}</a></h5>
  </div>
</div>
  {/foreach}
{/if}

{if $cfg.view_type == 'hr_table'}
    {$col="1"}
    <table cellspacing="5" border="0" width="100%" style="margin-top:15px;">
          {foreach key=aid item=usr from=$usrs}
            {if $col==1} <tr> {/if}
                    <td align="center" valign="middle"><a href="{profile_url login=$usr.login}" title="{$usr.nickname|escape:'html'}"><img style="border-radius:0px;" class="media-object" src="{$usr.avatar}" /></a><div><h4 class="media-heading"><a class="monospc" href="{profile_url login=$usr.login}">{$usr.nickname|truncate:8}</a></h4></div>
                    <br /></td>
            {if $col==$cfg.maxcool} </tr> {$col="1"} {else} {$col=$col+1} {/if}
          {/foreach}
    </table>
{/if}

{if $cfg.view_type == 'list'}
    {$now="0"}
        {foreach key=aid item=usr from=$usrs}
            <a href="{profile_url login=$usr.login}">{$usr.nickname}</a>{$now=$now+1}{if $now==$total}{else}, {/if}
        {/foreach}<br />
        <strong>{$LANG.LASTREG_TOTAL}:</strong> {$total_all}
{/if}