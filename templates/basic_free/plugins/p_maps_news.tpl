{* ================================================================================ *}
{* ================ Вкладка "Новости" в профиле пользователя ====================== *}
{* ================================================================================ *}

{if $items}
    <div class="actions_list">
    {foreach key=id item=item from=$items}
            <div class="action_entry {cycle values="rowa1, rowa2"}"> 
                <div class="action_title act_add_maps_news">
                    <span class="action_user"><a href="/maps/news/{$item.id}.html">{$item.title}</a> </span>
				</div>
				<div class="action_details">
				<span style="color:#666;" class="monospc"><span class="glyphicon glyphicon-map-marker"></span> {$item.obj_city}, {$item.obj_prefix} {$item.obj_street}, {$item.obj_house}</span>			
                <a class="monospc" href="/maps/{$item.obj_seolink}.html#tab_news" title="{$item.obj_title|escape:'html'}">&mdash; {$item.obj_title}</a>
                </div>
            </div>
    {/foreach}
</div>
{else} 
	<p class="text-danger">Пользователь не добавлял новости для объектов на карте.</p>  
{/if}
