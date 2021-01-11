<div class="panel panel-default">
	<div class="panel-heading">
<h4 class="panel-title">{if $opt == 'similar'}{$LANG.SIMILAR_MOVIES} | <a href="javascript:;" onclick="getUserMovie('{$movie.user_id}', 'other', '{$movie.id}');" class="strong" rel="nofollow">{$LANG.OTHER_MOVIE}</a>{else}<a href="javascript:;" onclick="getUserMovie('{$movie.user_id}', 'similar', '{$movie.id}');" class="strong" rel="nofollow">{$LANG.SIMILAR_MOVIES}</a> | {$LANG.OTHER_MOVIE}{/if}</h4>
	</div>
	<div class="panel-body">
		<div class="videorow">
{foreach key=tid item=smovie from=$similar_movies}
            <div class="media">
    <a title="{$LANG.VIEW_MOVIE} - {$smovie.title|escape:'html'}" href="{$smovie.movie_link}" class="pull-left {if $smovie.custom_img} start_rotation{/if}"><img src="/upload/video/thumbs/medium/{$smovie.img}" {if $smovie.custom_img}data-custom_img="{$smovie.custom_img|json_encode|escape:html}"{/if} alt="{$smovie.title|escape:'html'}" class="media-object"><span class="glyph-icon-play glyphicon glyphicon-play"></span></a>
	<div class="media-body">
		<h4 class="media-heading"><a href="{$smovie.movie_link}">{if $smovie.is_hd}<span class="glyphicon glyphicon-hd-video" title="{$LANG.HD_VIDEO}"></span> {/if}{$smovie.s_title|truncate:55}</a></h4>
        <div class="media-hinttext">
                <span class="monospc"><span class="glyphicon glyphicon-play"></span> {$smovie.hits}</span>
                <span class="monospc"><span class="glyphicon glyphicon-star"></span> {$smovie.rating}</span>
                <span class="monospc"><span class="glyphicon glyphicon-share-alt"></span> {$smovie.comments}</span>
			  {if $smovie.orig_duration}<span title="{$LANG.DURATION}" class="monospc"><span class="glyphicon glyphicon-time"></span> {$smovie.duration}</span>{/if}				
                <a class="monospc" href="{$smovie.cat_link}" title="{$smovie.cat_title|escape:'html'}"><span class="glyphicon glyphicon-film"></span> {$smovie.cat_title|truncate:18}</a>
				{if $movie.is_adult}<span class="text-danger"><span class="strong">!</span> 18+</span>{/if}
        </div>
	</div>
        	</div>
{/foreach}
		</div>
	</div>
{if $is_show_more}
    <div class="panel-footer"><input type="button" class="btn btn-default" onclick="getUserMovie('{$movie.user_id}', '{$opt}', '{$movie.id}', '{$next_page}');loadAutoScroll();" value="{$LANG.PS_SHOW_MORE}"></div>
{/if}
</div>