<h1 class="con_heading">{$pagetitle}</h1>
{if $actions}
    <div class="actions_list">
        {foreach key=aid item=action from=$actions}
            {if $action.item_date}
                <h5 class="action-item-date"><span class="glyphicon glyphicon-calendar"></span> {$action.item_date}</h5>
            {/if}
            <div class="action_entry {cycle values="rowa2,rowa1"}">
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
    {$pagebar}
{else}
<p class="error-txt">{$LANG.EVENTS_NOT_FOUND}</p>
{/if}