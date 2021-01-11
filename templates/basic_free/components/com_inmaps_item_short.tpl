<div style="display:block">
	<div class="media">
		<a class="pull-left" href="/maps/{$item.seolink}.html" target="_top"><img src="/images/photos/small/{$item.filename}" class="media-object" /></a>
		<div class="media-body">
			<h4 class="media-heading"><a href="/maps/{$item.seolink}.html" target="_top">{$item.title}</a> <a href="/maps/{$item.category.seolink}" target="_top" class="second-a">/ {$item.category.title}</a></h4>
                {if $item.address}
                    <p><em><span class="glyphicon glyphicon-map-marker"></span> {$item.address}</em></p>
                {/if}
	{if $item.shortdesc}
    <div class="map-object-short">{$item.shortdesc}</div>
	{/if}				
			<div class="media-hinttext">
                {if $item.contacts.phone || $item.contacts.fax || $item.contacts.url || $item.contacts.email || $item.contacts.icq || $item.contacts.skype}
                        {if $item.contacts.phone}<span class="monospc"><span class="glyphicon glyphicon-phone"></span> {$item.contacts.phone}</span>{/if}
                        {if $item.contacts.fax}<span class="monospc"><span class="glyphicon glyphicon-print"></span> {$item.contacts.fax}</span>{/if}
                        {if $item.contacts.url}<span class="monospc"><span class="glyphicon glyphicon-link"></span> <a href="{$item.contacts.url}" target="_blank">{$item.contacts.url_short}</a></span>{/if}
                        {if $item.contacts.email}<span class="monospc"><span class="glyphicon glyphicon-envelope"></span> <a href="mailto:{$item.contacts.email}">{$item.contacts.email}</a></span>{/if}
                        {if $item.contacts.icq}<span class="monospc"><span class="glyphicon glyphicon-hand-up"></span> {$item.contacts.icq}</span>{/if}
                        {if $item.contacts.skype}<span class="monospc"><span class="glyphicon glyphicon-hand-up"></span> <a href="skype:{$item.contacts.skype}">{$item.contacts.skype}</a></span>{/if}
                {/if}				
			</div>
    <div style="margin-top:10px;">
        {if $cfg.comments}
                <a href="/maps/{$item.seolink}.html#c" class="btn btn-default btn-small" target="_top">
                    {$item.comments|spellcount:$LANG.COMMENT:$LANG.COMMENT2:$LANG.COMMENT10}
                </a>
        {/if}

        {if $cfg.news_enabled}
            {if $news_count}
                    <a class="btn btn-default btn-small" href="/maps/{$item.seolink}.html#tab_news" target="_top">
                        {$LANG.MAPS_NEWS}
                    </a>
            {/if}
        {/if}

        {if $cfg.events_enabled}
            {if $events_count}
                    <a class="btn btn-default btn-small" href="/maps/{$item.seolink}.html#tab_events" target="_top">
                        {$LANG.MAPS_EVENTS}
                    </a>
            {/if}
        {/if}
    </div>
		
		</div>
	</div>
</div>