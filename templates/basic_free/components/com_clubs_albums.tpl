{strip}
{if $show_title}
    {if $is_admin || $is_moder || $is_karma_enabled}
        <div class="float_bar">
            <a class="btn btn-primary" href="javascript:void(0)" onclick="clubs.addAlbum({$club.id});">{$LANG.ADD_PHOTOALBUM}</a>
        </div>
    {/if}
    <h1 class="con_heading">{$pagetitle}</h1>
{/if}

{if $club.photo_albums}
{$col="1"}
            {foreach key=key item=album from=$club.photo_albums name=clalbs}
{if $col==1}<div class="row margin-bottom-row">{/if}				
			<div class="col-sm-4 media-gird" id="{$album.id}">
  <a href="/clubs/photoalbum{$album.id}" title="{$album.title|escape:'html'}"><img class="media-object" src="/images/photos/small/{$album.file}" alt="{$album.title|escape:'html'}" /></a>
    <h4 class="media-heading monospc"><a href="/clubs/photoalbum{$album.id}" title="{$album.title|escape:'html'}">{$album.title|truncate:30}</a></h4>
    <div class="media-hinttext">{if $album.content_count}<span class="monospc"><span class="glyphicon glyphicon-picture"></span> {$album.content_count}</span>{/if}<span class="monospc"><span class="glyphicon glyphicon-time"></span> {$album.pubdate}</span>  </div> 
			</div>
{if $col==3 || $smarty.foreach.clalbs.last}</div>{$col="1"}{else}{$col=$col+1}{/if}				
            {/foreach}

{else}
    <div class="usr_albums_block">
        {$LANG.NO_PHOTOALBUM}. {if $is_admin || $is_moder || $is_photo_karma_enabled}<a href="javascript:void(0)" onclick="clubs.addAlbum({$club.id});" title="{$LANG.ADD_PHOTOALBUM}" class="a-inverse">{$LANG.ADD_PHOTOALBUM}.</a>{/if}
    </div>
{/if}
{/strip}