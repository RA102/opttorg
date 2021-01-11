{add_js file='includes/jqueryui/jquery-ui.min.js'}
{add_js file='includes/jqueryui/jquery.ui.datepicker-ru.min.js'}
{add_css file='includes/jqueryui/css/smoothness/jquery-ui.min.css'}

<div class="float_bar">
        <select name="cat_id" onchange="window.location.href='/maps/events/'+$(this).val()">
            <option value="all" {if $cat_id=='all'}selected="selected"{/if}>{$LANG.MAPS_ALL_CATS}</option>
            {foreach key=i item=c from=$cats}
                <option value="{$c.id}" {if $cat_id==$c.id}selected="selected"{/if}>
                    {math equation="(x-1) * 3" x=$c.NSLevel assign="pad"}
                    {'-'|str_repeat:$pad} {$c.title}
                </option>
            {/foreach}
        </select>
</div>

<h1 class="con_heading">
    {if !$item && !$cat}{$LANG.MAPS_EVENTS_ALL}{/if}
    {if $item}{$item.title}: {$LANG.MAPS_EVENTS}{/if}
    {if $cat}{$cat.title}: {$LANG.MAPS_EVENTS}{/if}
</h1>

<div class="well no-padding-bottom">
    <form action="{if !$item}/maps/events/{$cat_id}{else}/maps/events-by/{$item.id}{/if}" method="post">
	<div class="row margin-bottom-row">
	<div class="col-md-4">
        <input name="date_start" class="text-input" type="text" id="event_date_start" value="{$date_start|escape:'html'}" />
	</div>
	<div class="col-md-4">	
        <input name="date_end" class="text-input" type="text" id="event_date_end" value="{$date_end|escape:'html'}" />
	</div>
	<div class="col-md-4">
        <input type="submit" class="btn btn-default btn-block" name="submit" value="Показать" />
	</div>
	</div>
    </form>
</div>

<script type="text/javascript">
    {literal}
    $(document).ready(function(){
        var datePickerOptions = {showStatus: true, showOn: "both", showButton: true};
        $('#event_date_start').datepicker(datePickerOptions);
        $('#event_date_end').datepicker(datePickerOptions);
    });
    {/literal}
</script>
{if $items}
    {foreach key=n item=event from=$items}
        <div class="media {cycle values="rowa1,rowa2"}">
            <a class="pull-left" href="/maps/{$event.obj_seolink}.html#tab_events" title="{$event.obj_title|escape:'html'}"><img src="/images/photos/small/{$event.filename}" class="media-object" /></a>
                <div class="media-body">
                    <h4 class="media-heading item_event_date">
					{if $event.is_today}<span class="today">{$LANG.MAPS_EVENT_TODAY}</span> {/if}
                    {if $event.is_tomorrow}<span class="tomorrow">{$LANG.MAPS_EVENT_TOMORROW}</span> {/if}
                    {if $event.days_to_start>1}  <span class="days_to">{$LANG.MAPS_EVENT_DAYS_TO} {$event.days_to_start|spellcount:$LANG.DAY:$LANG.DAY2:$LANG.DAY10}</span>{/if}					
					<a href="/maps/events/{$event.id}.html">{$event.title}</a>
					</h4>
                    <div class="media-hinttext">
                        <span class="glyphicon glyphicon-time"></span> {$event.date} &mdash; <a href="/maps/{$event.obj_seolink}.html#tab_events" title="{$event.obj_title|escape:'html'}"><span class="glyphicon glyphicon-map-marker"></span> {$event.obj_title|escape:'html'}</a>
                    </div>
                </div>

        </div>
    {/foreach}
{if $pagebar}{$pagebar}{/if}
{else}
    <p class="text-warning">{$LANG.MAPS_NO_EVENTS}</p>
{/if}