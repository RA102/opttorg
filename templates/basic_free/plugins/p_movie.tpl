{if !$is_load}

    <link rel="stylesheet" href="/templates/{template}/css/invideo.css" type="text/css" />
    <div class="auto_load">
        <div class="loader hid">{$LANG.LOADING}...</div>
        <input type="hidden" id="total_pages" value="{$total_pages}" />
        <div class="top_movie" style="margin-bottom:20px;">
            <h3>{$LANG.USERS_MOVIES}, <a href="/video/channel/{$usr.login}.html">{$LANG.ALL_CHANNEL}</a>{if $access.myprofile && $access.is_auth} | <a class="" href="/video/add.html">{$LANG.MOVIE_ADD}</a>{/if}</h3>
        </div>

    {if $movies}
	{$col="1"}
	{foreach key=tid item=movie from=$movies name=videoprof}
	{if $col==1}<div class="row margin-bottom-row videorow">{/if}
		<div class="col-md-4">
			<div class="media">
				<a href="{$movie.movie_link}" title="{if $movie.is_viewed}{$LANG.IS_VIEWED}: {/if}{$movie.title|escape:'html'}" class="pull-left{if $movie.custom_img} start_rotation{/if}"><img src="/upload/video/thumbs/medium/{$movie.img}" class="media-object{if $movie.is_viewed} watched_img{/if}" {if $movie.custom_img}data-custom_img="{$movie.custom_img|json_encode|escape:html}" {/if}alt="{if $movie.is_viewed}{$LANG.IS_VIEWED}: {/if}{$movie.title|escape:'html'}" /><span class="glyph-icon-play glyphicon glyphicon-play"></span></a>
				<div class="media-body">
					<h4 class="media-heading"><a href="{$movie.movie_link}" title="{if $movie.is_viewed}{$LANG.IS_VIEWED}: {/if}{$movie.title|escape:'html'}">{if !$movie.published}<span class="glyphicon glyphicon-eye-close" style="color:red;" title="{$LANG.ON_MODERATE}"></span> {/if}{if $movie.is_hd}<span class="glyphicon glyphicon-hd-video" title="{$LANG.HD_VIDEO}"></span> {/if}{$movie.s_title|truncate:55}</a></h4>
					<div class="media-hinttext">
                <span class="monospc"><span class="glyphicon glyphicon-play"></span> {$movie.hits}</span>
                <span class="monospc"><span class="glyphicon glyphicon-star"></span> {$movie.rating}</span>
                <span class="monospc"><span class="glyphicon glyphicon-share-alt"></span> {$movie.comments}</span>
				<span title="{$LANG.DURATION}" class="monospc"><span class="glyphicon glyphicon-time"></span> {$movie.duration}</span>			
                <a class="monospc" href="{$movie.cat_link}" title="{$movie.cat_title|escape:'html'}"><span class="glyphicon glyphicon-film"></span> {$movie.cat_title|truncate:18}</a>
			  {if $movie.is_adult}<span class="text-danger"><span class="strong">!</span> 18+</span>{/if}
					</div>
				</div>			
			</div>
		</div>
	{if $col==3 || $smarty.foreach.videoprof.last}</div>{$col="1"}{else}{$col=$col+1}{/if}	
	{/foreach}
    </div>
    {literal}
    <script type="text/javascript">
    $(document).ready(function(){
        $window  = $(window);
        var loader     = $('.loader');
        var page       = 1;
        var is_loaded  = 0;
        var total_page = $('#total_pages').val();
        $window.scroll(function() {
            if  ($window.scrollTop() == ($(document).height()-$window.height()) && is_loaded==0){
                page = page + 1;
                if(page <= total_page){
                    loader.fadeIn();
                    is_loaded = 1;
                    $.post('/users/channel?user_id={/literal}{$usr.id}{literal}', {page: page, is_load: 1}, function(data){
                        $('#p_movie').delay(1500).append(data);
                        setTimeout(function (){ loader.hide(); },500);
                        is_loaded = 0;
                    });
                } else {
                    loader.hide();
                    is_loaded = 0;
                    $window.unbind('scroll');
                }
            }
        });
    });
    </script>
    {/literal}
    {else}
        <p class="text-danger">{$LANG.USER_NOT_UPLOAD_MOVIE}...</p>
    {/if}

{else}
    {if $movies}
	{$col="1"}
	{foreach key=tid item=movie from=$movies name=videoprof}
	{if $col==1}<div class="row margin-bottom-row videorow">{/if}
		<div class="col-md-4">
			<div class="media">
				<a href="{$movie.movie_link}" title="{if $movie.is_viewed}{$LANG.IS_VIEWED}: {/if}{$movie.title|escape:'html'}" class="pull-left{if $movie.custom_img} start_rotation{/if}"><img src="/upload/video/thumbs/medium/{$movie.img}" class="media-object{if $movie.is_viewed} watched_img{/if}" {if $movie.custom_img}data-custom_img="{$movie.custom_img|json_encode|escape:html}" {/if}alt="{if $movie.is_viewed}{$LANG.IS_VIEWED}: {/if}{$movie.title|escape:'html'}" /><span class="glyph-icon-play glyphicon glyphicon-play"></span></a>
				<div class="media-body">
					<h4 class="media-heading"><a href="{$movie.movie_link}" title="{if $movie.is_viewed}{$LANG.IS_VIEWED}: {/if}{$movie.title|escape:'html'}">{if !$movie.published}<span class="glyphicon glyphicon-eye-close" style="color:red;" title="{$LANG.ON_MODERATE}"></span> {/if}{if $movie.is_hd}<span class="glyphicon glyphicon-hd-video" title="{$LANG.HD_VIDEO}"></span> {/if}{$movie.s_title|truncate:55}</a></h4>
					<div class="media-hinttext">
                <span class="monospc"><span class="glyphicon glyphicon-play"></span> {$movie.hits}</span>
                <span class="monospc"><span class="glyphicon glyphicon-star"></span> {$movie.rating}</span>
                <span class="monospc"><span class="glyphicon glyphicon-share-alt"></span> {$movie.comments}</span>
				<span title="{$LANG.DURATION}" class="monospc"><span class="glyphicon glyphicon-time"></span> {$movie.duration}</span>			
                <a class="monospc" href="{$movie.cat_link}" title="{$movie.cat_title|escape:'html'}"><span class="glyphicon glyphicon-film"></span> {$movie.cat_title|truncate:18}</a>
			  {if $movie.is_adult}<span class="text-danger"><span class="strong">!</span> 18+</span>{/if}
					</div>
				</div>			
			</div>
		</div>
	{if $col==3 || $smarty.foreach.videoprof.last}</div>{$col="1"}{else}{$col=$col+1}{/if}	
	{/foreach}
    {/if}
{/if}