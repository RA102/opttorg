{if $album.id == $root_album_id && $cfg.showlat}
<div class="float_bar">
<a class="btn btn-default" href="/photos/latest.html"><span class="glyphicon glyphicon-time"></span> {$LANG.LAST_UPLOADED}</a> <a class="btn btn-default" href="/photos/top.html"><span class="glyphicon glyphicon-star"></span> {$LANG.BEST_PHOTOS}</a>
</div>
{elseif $album.id != $root_album_id && $album.orderform}
    <div class="float_bar">
        {if $can_add_photo}
            <a class="btn btn-default" href="/photos/{$album.id}/addphoto.html">{$LANG.ADD_PHOTO_TO_ALBUM}</a>
        {/if}
    </div>
{elseif $can_add_photo && $album.parent_id > 0}
	<div class="float_bar"><a class="btn btn-default" href="/photos/{$album.id}/addphoto.html">{$LANG.ADD_PHOTO_TO_ALBUM}</a></div>
{/if}

<h1 class="con_heading">{$album.title} {if $total}({$total}){/if}</h1>
{if $album.description}
	<div class="item-description">{$album.description|nl2br}</div>
{/if}
{if $album.id != $root_album_id && $album.orderform}
<div class="well no-padding-bottom">
        <form action="" method="POST">
			<div class="row margin-bottom-row">
				<div class="col-sm-4">
            <select name="orderby" id="orderby">
                <option value="title" {if $orderby=='title'} selected {/if}>{$LANG.ORDERBY_TITLE}</option>
                <option value="pubdate" {if $orderby=='pubdate'} selected {/if}>{$LANG.ORDERBY_DATE}</option>
                <option value="rating" {if $orderby=='rating'} selected {/if}>{$LANG.ORDERBY_RATING}</option>
                <option value="hits" {if $orderby=='hits'} selected {/if}>{$LANG.ORDERBY_HITS}</option>
            </select>
				</div>
				<div class="col-sm-4">
            <select name="orderto" id="orderto">
                <option value="desc" {if $orderto=='desc'} selected {/if}>{$LANG.ORDERBY_DESC}</option>
                <option value="asc" {if $orderto=='asc'} selected {/if}>{$LANG.ORDERBY_ASC}</option>
            </select>
				</div>
				<div class="col-sm-4">
            <input type="submit" class="btn btn-default btn-block" value="Фильтр" />
				</div>
			</div>
        </form>
</div>
{/if}
{if $subcats}
{$col="1"}
{if $cfg.maxcols>=4}{$cfg.maxcols="4"}{$columns="3"}{else}{$columns=12/$cfg.maxcols}{/if}
    {foreach key=tid item=cat from=$subcats name=phooo}
        {if $col==1}<div class="row margin-bottom-row">{/if}
            <figure class="col-sm-{$columns} media-gird">
                <a href="/photos/{$cat.id}"><img class="media-object" src="/images/photos/small/{$cat.file}" alt="{$cat.title|escape:'html'}" /></a>
                <h4 class="media-heading"><a href="/photos/{$cat.id}">{$cat.title}</a> ({$cat.content_count})</h4>
                {if $cat.description}<div class="media-hinttext">{$cat.description|truncate:100}</div>{/if}
        	</figure>
{if $col==$cfg.maxcols || $smarty.foreach.phooo.last}</div>{$col="1"}{else}{$col=$col+1}{/if}
    {/foreach}
{/if}
{if $photos}
{$col="1"}
{if $album.maxcols>=4}{$album.maxcols="4"}{$columns="3"}{else}{$columns=12/$album.maxcols}{/if}
    {foreach key=tid item=photo from=$photos name=phoo}
        {if $col==1}<div class="row margin-bottom-row">{/if}
            <figure class="{$album.cssprefix} media-gird col-sm-{$columns}">
                {if $album.showtype == 'lightbox'}<a class="lightbox-enabled" rel="lightbox-galery" href="/images/photos/medium/{$photo.file}" title="{$photo.title|escape:'html'}">{else}<a href="/photos/photo{$photo.id}.html" title="{$photo.title|escape:'html'}">{/if}<img class="media-object" src="/images/photos/small/{$photo.file}" alt="{$photo.title|escape:'html'}" /></a>
                <h4 class="media-heading"><a href="/photos/photo{$photo.id}.html" title="{$photo.title|escape:'html'}">{$photo.title|truncate:30}</a></h4>
                {if $album.showdate}
				<div class="media-hinttext">
                    <span class="monospc"><span class="glyphicon glyphicon-time"></span> {$photo.pubdate}</span> <a class="monospc" href="/photos/photo{$photo.id}.html#c" title="{$photo.comments|spellcount:$LANG.COMMENT1:$LANG.COMMENT2:$LANG.COMMENT10}"><span class="glyphicon glyphicon-share-alt"></span> {$photo.comments}</a>
				</div>
				{/if}
                {if !$photo.published}
                    <p style="color:#F00; font-size:12px">{$LANG.WAIT_MODERING}</p>
                {/if}
        	</figure>
{if $col==$album.maxcols || $smarty.foreach.phoo.last}</div>{$col="1"}{else}{$col=$col+1}{/if}
    {/foreach}
{$pagebar}
{else}
	{if $album.parent_id > 0}<p class="text-danger">{$LANG.NOT_PHOTOS_IN_ALBUM}</p>{/if}
{/if}