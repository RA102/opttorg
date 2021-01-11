{if $is_admin || $is_moder || $is_member}
<div class="float_bar"><a class="btn btn-default" href="/clubs/addphoto{$album.id}.html">{$LANG.ADD_PHOTO_TO_ALBUM}</a> {if $is_admin || $is_moder}<a class="btn btn-default" href="javascript:void(0)" onclick="clubs.renameAlbum({$album.id});return false;" title="{$LANG.RENAME_ALBUM}"><span class="glyphicon glyphicon-edit"></span></a> <a class="btn btn-default" href="javascript:void(0)" onclick="clubs.deleteAlbum({$album.id}, '{csrf_token}');return false;" title="{$LANG.DELETE_ALBUM}"><span class="glyphicon glyphicon-trash"></span></a> {/if}</div>
{/if}

<h1 class="con_heading"><span id="album_title">{$album.title}</span> ({$total})</h1>
{if $photos}
{$col="1"}
{if $cfg.photo_maxcols>=4}{$cfg.photo_maxcols="4"}{$columns="3"}{else}{$columns=12/$cfg.photo_maxcols}{/if}
        {foreach key=tid item=con from=$photos name=clph}
            {if $col==1}<div class="row margin-bottom-row">{/if}
			<figure class="col-sm-{$columns} col-xs-6 media-gird">
<a href="/clubs/photo{$con.id}.html" title="{$con.title|escape:'html'}">
    <img src="/images/photos/small/{$con.file}" class="media-object" alt="{$con.title|escape:'html'}" />
</a>
<h4 class="media-heading"><a href="/clubs/photo{$con.id}.html" title="{$con.title|escape:'html'}">{$con.title|truncate:30}</a></h4>
{if !$con.published}<span class="text-danger">{$LANG.WAIT_MODERING}</span>{/if}			
			</figure>
{if $col==$cfg.photo_maxcols || $smarty.foreach.clph.last}</div>{$col="1"}{else}{$col=$col+1}{/if}
        {/foreach}
{$pagebar}
{else}
<p class="error-txt">{$LANG.NOT_PHOTOS_IN_ALBUM}</p>
{/if}