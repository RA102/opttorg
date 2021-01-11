<h1 class="con_heading">{$pagetitle}</h1>

{$col="1"} 
{if $maxcols>=4}{$maxcols="4"}{$columns="3"}{else}{$columns=12/$maxcols}{/if}
    {foreach key=tid item=photo from=$photos name=phoo1}
        {if $col==1}<div class="row margin-bottom-row">{/if}
            <figure class="media-gird col-sm-{$columns} {$album.cssprefix}">
                <a href="/photos/photo{$photo.id}.html" title="{$photo.title|escape:'html'}"><img class="media-object" src="/images/photos/small/{$photo.file}" alt="{$photo.title|escape:'html'}" /></a>
                <h4 class="media-heading"><a href="/photos/photo{$photo.id}.html" title="{$photo.title|escape:'html'}">{$photo.title|truncate:30}</a></h4>
				<div class="media-hinttext">
                    <span class="monospc"><span class="glyphicon glyphicon-time"></span> {$photo.pubdate}</span> <a class="monospc" href="/photos/photo{$photo.id}.html#c" title="{$photo.comments|spellcount:$LANG.COMMENT1:$LANG.COMMENT2:$LANG.COMMENT10}"><span class="glyphicon glyphicon-share-alt"></span> {$photo.comments}</a><a class="monospc" href="/photos/{$photo.album_id}" title="{$photo.cat_title|escape:'html'}"><span class="glyphicon glyphicon-folder-open"></span> {$photo.cat_title|truncate:18}</a>
				</div>				
        	</figure>
{if $col==$maxcols || $smarty.foreach.phoo1.last}</div>{$col="1"}{else}{$col=$col+1}{/if}
    {/foreach}