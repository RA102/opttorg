    {foreach key=id item=user from=$users}
<div class="media {cycle values="rowa1,rowa2"}">
  <a class="pull-left" href="{profile_url login=$user.login}#upr_awards" title="{$user.nickname|escape:'html'}"><img class="media-object" src="{$user.avatar}" /></a>
  <div class="media-body">
    <h5 class="media-heading"><a href="{profile_url login=$user.login}#upr_awards" title="{$user.nickname|escape:'html'}">{$user.nickname}</a></h5>
                    {if $cfg.show_awards}
                        <div style="margin-top:6px;font-size:1.5em;">
                            {foreach key=id item=award from=$user.awards}
                                <span class="glyphicon glyphicon-star text-danger" title="{$award.title|escape:'html'}"></span>
                            {/foreach}
                        </div>
                    {/if}
  </div>
</div>
    {/foreach}