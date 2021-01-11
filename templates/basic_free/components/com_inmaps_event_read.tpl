{* ================================================================================ *}
{* ============================ Просмотр события объекта ========================== *}
{* ================================================================================ *}
<div class="row margin-bottom-row">
	<div class="col-md-4 media-gird">
                    <a href="/maps/{$item.seolink}.html">
                        <img src="/images/photos/small/{$item.filename}" class="media-object" alt="{$item.title}" />
                    </a>	
	</div>
	<div class="col-md-8">
            <h1 class="con_heading">
                {$event.title} &rarr; <a href="/maps/{$item.seolink}.html">{$item.title}</a>
            </h1>
            <div class="item_event_date">
                {if $event.is_today}<span class="today">{$LANG.MAPS_EVENT_TODAY}</span> {/if}
                {if $event.is_tomorrow}<span class="tomorrow">{$LANG.MAPS_EVENT_TOMORROW}</span> {/if}
                {if $event.days_to_start>1}  <span class="days_to">{$LANG.MAPS_EVENT_DAYS_TO} {$event.days_to_start|spellcount:$LANG.DAY:$LANG.DAY2:$LANG.DAY10}</span>{/if}
                {$event.date}
                <span style="margin-left:20px">
                    {$LANG.MAPS_ITEM_ADDED_BY}: <a href="{profile_url login=$event.user_login}">{$event.user_name}</a>
                </span>
            </div>	
	</div>
</div>
            <ul class="list-group">
				<li class="list-group-item"><span class="glyphicon glyphicon-map-marker"></span> {$item.map_address}</li>
                {if $item.contacts.phone || $item.contacts.fax || $item.contacts.url || $item.contacts.email || $item.contacts.icq || $item.contacts.skype}				
                {if $item.contacts.phone}<li class="list-group-item"><span class="glyphicon glyphicon-phone"></span> {$item.contacts.phone}</li>{/if}
                {if $item.contacts.fax}<li class="list-group-item"><span class="glyphicon glyphicon-print"></span> {$item.contacts.fax}</li>{/if}
                {if $item.contacts.url}<li class="list-group-item"><a href="{$item.contacts.url}" target="_blank"><span class="glyphicon glyphicon-link"></span> {$item.contacts.url_short}</a></li>{/if}
                {if $item.contacts.email}<li class="list-group-item"><a href="mailto:{$item.contacts.email}"><span class="glyphicon glyphicon-envelope"></span> {$item.contacts.email}</a></li>{/if}
                {if $item.contacts.icq}<li class="list-group-item"><span class="glyphicon glyphicon-hand-up"></span> {$item.contacts.icq}</li>{/if}
                {if $item.contacts.skype}<li class="list-group-item"><span class="glyphicon glyphicon-hand-up"></span> {$item.contacts.skype}</li>{/if}
                {/if}				
            </ul>	
            <div class="item-description">
                {$event.content}
            </div>

            {if $cfg.events_attend}
                <div class="well">
                    <strong>{$LANG.MAPS_EVENT_ATTEND_LIST}</strong>
                    <div>
                        {if !$event.attend_users}
                            {$LANG.MAPS_EVENT_NO_ATTEND}
                        {else}
                            {foreach key=u item=user from=$event.attend_users}
                                {$user}
                            {/foreach}
                        {/if}
                    </div>
                </div>
            {/if}

            {if $is_can_edit || ($cfg.events_attend && $is_user)}
                <p style="margin-top:15px">
                    {if $cfg.events_attend && $is_user}
                        {if !$event.is_user_attend}
                            <input type="button" class="btn btn-primary" id="attend" onclick="window.location.href='/maps/attend/event/{$event.id}'" value="{$LANG.MAPS_EVENT_ATTEND}" />
                        {else}
                            <input type="button" class="btn btn-default" id="unattend" onclick="window.location.href='/maps/unattend/event/{$event.id}'" value="{$LANG.MAPS_EVENT_UNATTEND}" />
                        {/if}
                    {/if}
                    {if $is_can_edit}
                        <input type="button" class="btn btn-default" name="edit" value="{$LANG.EDIT}" onclick="window.location.href='/maps/events/edit{$event.id}.html'" />
                        <input type="button" class="btn btn-default" name="delete" value="{$LANG.DELETE}" onclick="if (confirm('{$LANG.MAPS_DELETE_EVENT}?')) window.location.href='/maps/events/delete{$event.id}.html'; " />
                    {/if}
                </p>
            {/if}
