{if $actions}
    <div class="actions_list">
        {foreach key=aid item=action from=$actions}
            <div class="action_entry {cycle values="rowa2,rowa1"}">
               <span class="pull-right action_date{if $action.is_new} is_new{/if}"><span class="glyphicon glyphicon-time"></span> {$action.pubdate} {$LANG.BACK}</span>
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
{else}
<p class="text-danger">{$LANG.NOT_USER_ACTIONS}</p>
{/if}