{if $items}
    <div class="actions_list">
	{foreach key=tid item=item from=$items}
            <div class="action_entry {cycle values="rowa1,rowa2"}">
                <span class="pull-right action_date"><span class="glyphicon glyphicon-time"></span> {$item.fpubdate}</span>
                <div class="action_title act_add_board"{if $item.is_vip} style="color:orange;" title="VIP"{/if}>
                    <span class="action_user"><a href="/board/read{$item.id}.html">{$item.title}</a> {if $cfg.showcity}<span style="color:#666;">&mdash; {$item.city}</span>{/if}</span>
                </div>
            </div>
	{/foreach}
	</div>
{else}
<p class="text-info">{$LANG.LATESTBOARD_NOT_ADV}</p>
{/if}
