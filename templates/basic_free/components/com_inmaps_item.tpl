
<div class="float_bar">
{if $cfg.ratings}
    {add_js file='components/maps/js/rating/jquery.MetaData.js'}
    {add_js file='components/maps/js/rating/jquery.rating.js'}
    {add_css file='components/maps/js/rating/jquery.rating.css'}
    <div class="item_rating">
        <form action="/maps/rate" method="POST">
            <input type="hidden" name="item_id" value="{$item.id}" />
            <input type="hidden" name="points" value="{$item.id}" />
            {section name=rate start=1 loop=6 step=1}
                <input name="rate" type="radio" class="star" value="{$smarty.section.rate.index}" {if $item.rating>=$smarty.section.rate.index}checked="checked"{/if} {if !$is_user || $item.user_voted}disabled="disabled"{/if} />
            {/section}
        </form>
        {if $item.rating}
            <small>{$item.rating} / <span style="color:gray">{$item.rating_votes|spellcount:$LANG.MAPS_VOTES:$LANG.MAPS_VOTES2:$LANG.MAPS_VOTES10}</span></small>
        {/if}
    </div>
{/if}
</div>
<h1 class="con_heading">{$item.title}{if $item.on_moderate} <small class="text-danger">{$LANG.MSG_ITEM_PENDING}</small>{/if}</h1>
<div class="row margin-bottom-row">
	<div class="col-md-4">
		<div class="media-gird"><img src="/images/photos/medium/{$item.filename}" class="media-object" /></div>
        {if $item.images}
			<div class="additional-gird">
				<ul class="additional-gird-list">
            {foreach key=num item=file from=$item.images}
					<li>
						<a href="/images/photos/medium/{$file}" class="lightbox-enabled" rel="lightbox-galery" title="{$item.title|escape:'html'} ({$LANG.SHOP_PHOTO} {$num+1})"><img src="/images/photos/small/{$file}" class="media-object" /></a>
					</li>			
            {/foreach}
				</ul>
            </div>
        {/if}			
        {if sizeof($item.addresses) > 1}
        <div id="marker_select">
            <select id="map_marker" onchange="changeMap()">
                {foreach key=addr_id item=address from=$item.addresses}
                <option value="{$address.lat}|{$address.lng}" {if $addr_id==$item.current_marker.id}selected="selected"{/if}>{$address.short}</option>
                {/foreach}
            </select>
        </div>
		<br />
		{/if}
        <div id="map_wrapper" style="z-index: 199">
            <div id="citypanel">
                <div id="fullscreen_link">
                    <a href="#" onclick="toggleMapSize('#placemap')" class="maximize_button"><span class="glyphicon glyphicon-fullscreen"></span></a>
                </div>
            </div>
            <div id="placemap"></div>
        </div>
	</div>
	<div class="col-md-8">
		<ul class="list-group">
			{if $item.addresses}
				{foreach key=m item=address from=$item.addresses}
					<li class="list-group-item"><strong>Адрес:</strong> 
						{if $cfg.mode=='world'}
						{$address.full}
						{else}
						{$address.short}
						{/if}
					</li>
				{/foreach}
			{else}
					<li class="list-group-item"><strong>Адрес:</strong> 
						{if $cfg.mode=='world'}
							{$item.map_address}
						{else}
						{$item.address}
						{/if}
					</li>
			{/if}
			{if $cfg.show_user}
                <li class="list-group-item">
                     <strong>{$LANG.MAPS_ITEM_ADDED_BY}:</strong>
                    <a href="{profile_url login=$item.user_login}">{$item.user_name}</a>
				</li>
			{/if}
			{if $cfg.show_cats}
                <li class="list-group-item">
                    <strong>{$LANG.MAPS_ITEM_CATS}:</strong>
                    {foreach key=num item=cat from=$item.cats}
                    <a href="/maps/{$item.cats_data[$num].seolink}">{$item.cats_data[$num].title}</a>{if $num<sizeof($item.cats)-1}, {/if}
                    {/foreach}
				</li>
			{/if}
			{if $cfg.show_vendors && $item.vendor}
				<li class="list-group-item">
                    <strong>{$LANG.MAPS_ITEM_VENDOR}: <a href="/maps/vendors/{$item.vendor_id}">{$item.vendor}</a>
				</li>
			{/if}
			{if $item.contacts.phone}
                <li class="list-group-item">
                    <strong>{$LANG.MAPS_CONTACTS_PHONE}:</strong> {$item.contacts.phone}
                </li>
            {/if}

            {if $item.addresses}
                {foreach key=m item=address from=$item.addresses}
                    {if $address.phone}
                        <li class="list-group-item">
                        <strong>{$LANG.MAPS_CONTACTS_PHONE}:</strong> {$address.phone}
                        <em style="color:#666">&mdash;
                            {if $cfg.mode=='world'}
                            {$address.full}
                            {else}
                            {$address.short}
                            {/if}
                        </em>
						</li>
                    {/if}
                {/foreach}
            {/if}
            {if $item.contacts.fax}<li class="list-group-item"><strong>{$LANG.MAPS_CONTACTS_FAX}:</strong> {$item.contacts.fax}</li>{/if}
            {if $item.contacts.url}<li class="list-group-item"><strong>{$LANG.MAPS_CONTACTS_URL}:</strong> <a href="{$item.contacts.url}" target="_blank">{$item.contacts.url_short}</a></li>{/if}
            {if $item.contacts.email}<li class="list-group-item"><strong>{$LANG.MAPS_CONTACTS_EMAIL}:</strong> <a href="mailto:{$item.contacts.email}">{$item.contacts.email}</a></li>{/if}
            {if $item.contacts.icq}<li class="list-group-item"><strong>{$LANG.MAPS_CONTACTS_ICQ}:</strong> {$item.contacts.icq}</li>{/if}
            {if $item.contacts.skype}<li class="list-group-item"><strong>{$LANG.MAPS_CONTACTS_SKYPE}:</strong> <a href="skype:{$item.contacts.skype}">{$item.contacts.skype}</a></li>{/if}
		</ul>
		<div class="panel-group" id="mapcordion">
		{if $cfg.show_full_desc}
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#mapcordion" href="#collapseDesc">
					<span class="glyphicon glyphicon-chevron-down pull-right"></span>
						{$LANG.MAPS_TAB_DESC}
					</a>
					</h4>
				</div>
				<div id="collapseDesc" class="panel-collapse collapse in">
					<div class="panel-body">
						<div class="item-description">{$item.description}</div>
                            {if $item.chars || $cfg.items_attend}
                                {assign var=last_grp value=""}
                                <ul class="map_chars_list">
                                    {if $item.chars}
                                        {foreach key=num item=char from=$item.chars}
                                            {if $cfg.show_char_grp}
                                                {if $char.fieldgroup && ($char.fieldgroup!=$last_grp)}
                                                    <li class="grp">{$char.fieldgroup}</li>
                                                {/if}
                                                {assign var=last_grp value=$char.fieldgroup}
                                            {/if}
                                            {if $char.value}
                                                <li><span class="quest">{$char.title}:</span> <span class="answer">{$char.value}</span></li>
                                            {/if}
                                        {/foreach}
                                    {/if}
                                    {if $cfg.items_attend}
                                        <li class="grp">{$LANG.MAPS_ITEM_ATTEND_LIST}</li>
                                        {if !$item.attend_users}
                                            <li>{$LANG.MAPS_ITEM_NO_ATTEND}</li>
                                        {else}
                                            <li>
                                                {foreach key=u item=user from=$item.attend_users}
                                                    {$user}
                                                {/foreach}
                                            </li>
                                        {/if}
                                        {if $is_user}
                                            <li class="grp">
                                                {if !$item.is_user_attend}
                                                    <input type="button" id="attend" onclick="window.location.href='/maps/attend/item/{$item.id}'" value="{$LANG.MAPS_ITEM_ATTEND}" />
                                                {else}
                                                    <input type="button" id="unattend" onclick="window.location.href='/maps/unattend/item/{$item.id}'" value="{$LANG.MAPS_ITEM_UNATTEND}" />
                                                {/if}
                                            </li>
                                        {/if}
                                    {/if}
                                </ul>
                            {/if}
					</div>
				</div>
			</div>
		{/if}
		{if $cfg.news_enabled}
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#mapcordion" href="#collapseNews">
							<span class="glyphicon glyphicon-chevron-down pull-right"></span>
							{$LANG.MAPS_TAB_NEWS}
						</a>
					</h4>
				</div>
				<div id="collapseNews" class="panel-collapse collapse">
					<div class="panel-body">
					{if $item.news}  
					{foreach key=n item=news from=$item.news}
            <div class="action_entry {cycle values="rowa1, rowa2"}"> 
                <span class="pull-right action_date"><span class="glyphicon glyphicon-time"></span> {$news.pubdate}</span>
                <div class="action_title act_add_maps_news">
                    <span class="action_user"><a href="/maps/news/{$news.id}.html">{$news.title}</a> </span>
				</div>
            </div>					
					{/foreach}
					<br />
					{/if}
					<div>
					<a class="btn btn-default" href="/maps/news-by/{$item.id}">{$LANG.MAPS_NEWS_ARCHIVE}</a>
					{if $item.can_edit}
					{if !$item.on_moderate && $cfg.news_enabled}
					<input type="button" class="btn btn-default" name="add_news" value="{$LANG.MAPS_ADD_NEWS}" onclick="window.location.href='/maps/news/{$item.id}/add.html'" />
					{/if}
					{/if}					
					</div>
					</div>
				</div>
			</div>
		{/if}
		{if $cfg.events_enabled}
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#mapcordion" href="#collapseEv">
							<span class="glyphicon glyphicon-chevron-down pull-right"></span>
							{$LANG.MAPS_TAB_EVENTS}
							</a>
						</h4>
					</div>
					<div id="collapseEv" class="panel-collapse collapse">
						<div class="panel-body">
							{if $item.events} 
							<div class="actions_list">
                            {foreach key=n item=event from=$item.events}
								<div class="action_entry {cycle values="rowa1,rowa2"}">
									<span class="pull-right action_date{if $action.is_new && $user_id != $action.user_id} is_new{/if}"><span class="glyphicon glyphicon-time"></span> {$event.date}</span>
									<div class="action_title">
											{if $event.is_today}<span class="today">{$LANG.MAPS_EVENT_TODAY}</span> {/if}
                                            {if $event.is_tomorrow}<span class="tomorrow">{$LANG.MAPS_EVENT_TOMORROW}</span> {/if}
                                            {if $event.days_to_start>1}  <span class="days_to">{$LANG.MAPS_EVENT_DAYS_TO} {$event.days_to_start|spellcount:$LANG.DAY:$LANG.DAY2:$LANG.DAY10}</span>{/if}									
											<a href="/maps/events/{$event.id}.html">{$event.title}</a>
									</div>
								</div>							
                            {/foreach}
							</div>
							<br />
							{/if}
							<div>
							<a class="btn btn-default" href="/maps/events-by/{$item.id}">{$LANG.MAPS_EVENTS_ARCHIVE}</a>
							{if $item.can_add_events && !$item.on_moderate && $cfg.events_enabled}
							<input type="button" class="btn btn-default" name="add_event" value="{$LANG.MAPS_ADD_EVENT}" onclick="window.location.href='/maps/events/{$item.id}/add.html'" />
							{/if}
							</div>
						</div>
					</div>
				</div>
		{/if}
		</div>
		<div>
	{if $cfg.items_abuses && !$item.is_user_abused}
        <a class="btn btn-default" href="/maps/abuse{$item.id}.html">{$LANG.MAPS_ITEM_ABUSE}</a>
    {/if}
	{if $cfg.items_embed}
        <a class="btn btn-default" href="/maps/embed-code/{$item.id}">{$LANG.MAPS_ITEM_EMBED}</a>
    {/if}		
    {if $item.can_edit}
        <input type="button" name="edit" class="btn btn-default" value="{$LANG.EDIT}" onclick="window.location.href='/maps/edit{$item.category_id}-{$item.id}.html'" />
    {/if}
    {if $item.on_moderate && $is_admin}
        <input type="button" class="btn btn-default" name="accept" value="{$LANG.MAPS_ACCEPT}" onclick="window.location.href='/maps/accept{$item.id}.html'">
        <input type="button" class="btn btn-default" name="delete" value="{$LANG.DELETE}" onclick="window.location.href='/maps/delete{$item.id}.html'">
    {/if}	
		</div>		
	</div>
</div>

<script type="text/javascript">

    var options = {literal}{{/literal}
            zoom_min: {$cfg.zoom_min},
            zoom_max: {$cfg.zoom_max},
            map_type: '{$cfg.minimap_type}',
            zoom: '{$cfg.zoom_minimap}'
    {literal}}{/literal};

    {literal}
        $(document).ready(function(){
    {/literal}
            initPlaceMapXY('{$item.current_marker.lng}', '{$item.current_marker.lat}', "{$item.title|escape:'html'}", options);
    {literal}
        });
    {/literal}

    {literal}
    function changeMap(){
        var coords = $('#map_marker').val();
    {/literal}

        latlng = coords.split('|');
        initPlaceMapXY(latlng[1], latlng[0], "{$item.title|escape:'html'}", options);

    {literal}
    }
    {/literal}

    {if $cfg.ratings}
        {literal}
            $('.star').rating({
                callback: function(value, link){
                    $(this.form).find('input[name=points]').val(value);
                    this.form.submit();
                }
            });
        {/literal}
    {/if}

</script>