{* ================================================================================ *}
{* ============================ Просмотр новости объекта ========================== *}
{* ================================================================================ *}
<div class="row margin-bottom-row">
	<div class="col-md-4 media-gird">
        <a href="/maps/{$item.seolink}.html"><img src="/images/photos/small/{$item.filename}" class="media-object" alt="{$item.title}" /></a>
	</div>
	<div class="col-md-8">
<h1 class="con_heading">
    {$news.title} &rarr; <a href="/maps/{$item.seolink}.html">{$item.title}</a>
</h1>
<div class="media-hinttext"><span class="glyphicon glyphicon-time"></span> {$news.pubdate}</div>	
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
                {$news.content}
            </div>

            {if $is_can_edit}
                <p style="margin-top:15px">
                    <input class="btn btn-default" type="button" name="edit" value="{$LANG.EDIT}" onclick="window.location.href='/maps/news/edit{$news.id}.html'" />
                    <input class="btn btn-default" type="button" name="delete" value="{$LANG.DELETE}" onclick="if (confirm('{$LANG.MAPS_DELETE_NEWS}?')) window.location.href='/maps/news/delete{$news.id}.html'" />
                </p>
            {/if}
