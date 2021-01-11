{if $actions}
    <div class="actions_list">
        {foreach key=aid item=action from=$actions}
            <div class="action_entry {cycle values="rowa1,rowa2"}">
                <span class="pull-right action_date{if $action.is_new && $user_id != $action.user_id} is_new{/if}"><span class="glyphicon glyphicon-time"></span> {$action.pubdate} {$LANG.BACK}</span>
                <div class="action_title act_{$action.name}">
                    <a href="{$action.user_url}" class="action_user">{$action.user_nickname}</a>
                    {if $action.message}
                        {$action.message}{if $action.description}:{/if}
                    {else}
                        {if $action.description}
                            &rarr; {$action.description}
                        {/if}
                    {/if}
                </div>
                {if $action.message}
                    {if $action.description}
                <div class="action_details">{$action.description}</div>
                    {/if}
                {/if}
            </div>
        {/foreach}
    </div>
    {if $cfg.show_link}
<br />
        <a class="btn btn-default" href="/actions" class="mod_act_all">{$LANG.ALL_ACTIONS}</a>

    {/if}
{/if}