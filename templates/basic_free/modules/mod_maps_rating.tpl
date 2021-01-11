{if $items}
    <div class="actions_list">
		{foreach key=id item=item from=$items}
            <div class="action_entry {cycle values="rowa1, rowa2"}">
                <span class="pull-right action_date" title="{$item.rating}">{$item.rating_img}</span>
                <div class="action_title act_add_maps_obj">
                    <span class="action_user"><a href="/maps/{$item.seolink}.html">{$item.title}</a></span>
                </div>
{if $item.address}<div class="media-hinttext">&mdash; {$item.address}</div>{/if}				
            </div>
		{/foreach}
	</div>
{else}
	<p>Нет объектов для отображения</p>
{/if}
