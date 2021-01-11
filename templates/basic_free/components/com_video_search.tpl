<div class="float_bar">{$LANG.FOUND} {$total|spellcount:$LANG.RESULT1:$LANG.RESULT2:$LANG.RESULT10}&nbsp;&nbsp;&nbsp;<a href="#" rel="nofollow" data-cat_id="0" class="btn btn-default" onclick="return displaySearchForm(this);" title="{$LANG.SEARCH_MOVIE}">{$LANG.NEW_SEARCH}</a></div>

<h1 class="con_heading">{$LANG.SEARCH_MOVIE}</h1>

{if $movies}
	{$col="1"}
	{foreach key=tid item=movie from=$movies name=videosrch}
	{if $col==1}<div class="row margin-bottom-row videorow">{/if}
		<div class="col-xs-12">
			<div {if $movie.is_viewed}class="media media-viewed"{else}class="media"{/if}>
				<a href="{$movie.movie_link}" title="{if $movie.is_viewed}{$LANG.IS_VIEWED}: {/if}{$movie.title|escape:'html'}" class="pull-left{if $movie.custom_img} start_rotation{/if}"{if $cfg.lightbox_on_cat} onclick="getMovieLightboxNoNav(this);return false;" id="{$movie.id}"{/if}><img src="/upload/video/thumbs/medium/{$movie.img}" class="media-object{if $movie.is_viewed} watched_img{/if}" {if $movie.custom_img}data-custom_img="{$movie.custom_img|json_encode|escape:html}" {/if}alt="{if $movie.is_viewed}{$LANG.IS_VIEWED}: {/if}{$movie.title|escape:'html'}" /><span class="glyph-icon-play glyphicon glyphicon-play"></span></a>
				<div class="media-body">
					<h4 class="media-heading"><a href="{$movie.movie_link}" title="{if $movie.is_viewed}{$LANG.IS_VIEWED}: {/if}{$movie.title|escape:'html'}">{if !$movie.published}<span class="glyphicon glyphicon-eye-close" style="color:red;" title="{$LANG.ON_MODERATE}"></span> {/if}{if $movie.is_hd}<span class="glyphicon glyphicon-hd-video" title="{$LANG.HD_VIDEO}"></span> {/if}{$movie.s_title}</a></h4>
					{if $cat_view_type!='table' && $root_cat.id!=1}
					<div class="media-description">{$movie.description|strip_tags|truncate:300}</div>
					{/if}					
					<div class="media-hinttext">
                <span class="monospc"><span class="glyphicon glyphicon-play"></span> {$movie.hits}</span>
                <span class="monospc"><span class="glyphicon glyphicon-star"></span> {$movie.rating}</span>
                <span class="monospc"><span class="glyphicon glyphicon-share-alt"></span> {$movie.comments}</span>
                {if $cat_view_type!='table' && $root_cat.id!=1}
                <span class="monospc"><span class="glyphicon glyphicon-calendar"></span> {$movie.fpubdate}</span>
                {/if}
			  {if $movie.orig_duration}<span title="{$LANG.DURATION}" class="monospc"><span class="glyphicon glyphicon-time"></span> {$movie.duration}</span>{/if}				
                {if $is_nested || $root_cat.id==1}
                <a class="monospc" href="{$movie.cat_link}" title="{$movie.cat_title|escape:'html'}"><span class="glyphicon glyphicon-film"></span> {$movie.cat_title|truncate:18}</a>
                {/if}	
			  {if $movie.is_adult}<span class="censored">18+</span>{/if}
					</div>
				</div>			
			</div>
		</div>
	{if $col==3 || $smarty.foreach.videosrch.last}</div>{$col="1"}{else}{$col=$col+1}{/if}	
	{/foreach}
      {$pagebar}
{if $params.search_query}
    {add_js file='components/video/js/jquery.highlight.js'}
    <script type="text/javascript">
    var hl = {$params.search_query};
    {literal}
    $(document).ready(function(){
        $('.component').highlight(hl);
    });
    </script>
{/literal}{/if}
{else}
    <p class="text-danger">{$LANG.SEARCH_NOT_FOUND}...</p>
{/if}