{if $items}
    <div class="actions_list">
    {foreach key=n item=event from=$items}
            <div class="action_entry {cycle values="rowa1, rowa2"}"> 
                <span class="pull-right action_date">{if $cfg.show_date || $cfg.show_city}{if $event.is_today}<span class="event-today"><span class="glyphicon glyphicon-time"></span> {$LANG.MAPS_EVENT_TODAY}</span> {/if}{if $event.is_tomorrow}<span class="event-tomorrow"><span class="glyphicon glyphicon-time"></span> {$LANG.MAPS_EVENT_TOMORROW}</span> {/if}{if $event.days_to_start>1}<span class="event-days_to"><span class="glyphicon glyphicon-time"></span> {$LANG.MAPS_EVENT_DAYS_TO} {$event.days_to_start|spellcount:$LANG.DAY:$LANG.DAY2:$LANG.DAY10}</span>{/if}{/if}</span>
                <div class="action_title act_add_maps_event">
                    <span class="action_user"><a href="/maps/events/{$event.id}.html">{$event.title}</a></span>
                </div>
				<div class="action_details">
				 {if $cfg.show_city}<span style="color:#666;" class="monospc"><span class="glyphicon glyphicon-map-marker"></span> {$event.obj_city}</span>{/if}
			{if $cfg.show_object}
                <a href="/maps/{$event.obj_seolink}.html#tab_events" title="{$event.obj_title|escape:'html'}">&mdash; {$event.obj_title|escape:'html'}</a>
            {/if}				
				</div>
            </div>	
    {/foreach}
</div>
<div style="text-align: right;margin-top:20px;"><a class="btn btn-default" href="/maps/events">Все события</a></div>

{else}

    <p>{$LANG.MAPS_NO_EVENTS}</p>

{/if}