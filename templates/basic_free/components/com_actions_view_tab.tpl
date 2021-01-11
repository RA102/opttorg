{if $actions}
{include file='com_actions_friends.tpl'}

{include file='com_actions_tab.tpl'}

{else}
    <p class="error-txt">{$LANG.FEED_DESC}</p>
    <p class="error-txt">{$LANG.FEED_EMPTY_TEXT}</p>
{/if}