{if $my_profile}
    <div class="float_bar">
        <a href="/users/addphoto.html" class="btn btn-primary">{$LANG.ADD_PHOTO}</a>
    </div>
{/if}
<h1 class="con_heading"><a href="{profile_url login=$user.login}">{$user.nickname}</a> &rarr; {$LANG.PHOTOALBUMS}</h1>
{if $albums}
 {$col="1"}
            {foreach key=key item=album from=$albums name=ualb}
				{if $col==1} <div class="row margin-bottom-row"> {/if}
				<div class="col-sm-2 col-xs-6">
					<div class="media-gird">
                        <a href="/users/{$user.login}/photos/{$album.type}{$album.id}.html" title="{$album.title|escape:'html'}"><img class="media-object" src="{$album.imageurl}" alt="{$album.title|escape:'html'}"/></a>
						<a class="media-heading" href="/users/{$user.login}/photos/{$album.type}{$album.id}.html" title="{$album.title|escape:'html'}">{$album.title|truncate:32}</a>
							<div class="media-hinttext"><span class="glyphicon glyphicon-picture"></span> {$album.photos_count} &nbsp; <span class="glyphicon glyphicon-time"></span> {$album.pubdate}</div>
                    </div>
				</div>				
				{if $col==6 || $smarty.foreach.ualb.last}</div>{$col="1"}{else}{$col=$col+1}{/if}
            {/foreach}
{else}
    <p class="text-danger">{$LANG.NOT_PHOTOS}</p>
{/if}