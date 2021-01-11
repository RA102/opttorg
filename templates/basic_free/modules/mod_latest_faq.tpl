{if $faq}
    <div class="actions_list">
{foreach key=aid item=quest from=$faq}
            <div class="action_entry {cycle values="rowa1,rowa2"}">
                <div class="action_title act_add_quest">
                    <span class="action_user">{$quest.date}</span>
                </div>
				<div class="action_details">
				{$quest.quest|truncate:$cfg.maxlen} <a href="{$quest.href}" class="monospc">&mdash;  {$LANG.LATEST_FAQ_DETAIL}...</a>
				</div>
            </div>
{/foreach}
	</div>
{else}
    <p>{$LANG.LATEST_FAQ_NOT_QUES}</p>
{/if}
