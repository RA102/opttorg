{if $access.is_auth}
{if $access.is_author || $access.is_admin || $access.is_moder}
<div class="float_bar">
      <a class="btn btn-default" href="javascript:void(0)" onclick="operationMovie('{$movie.id}', 'edit');" title="{$LANG.EDIT}"><span class="glyphicon glyphicon-edit"></span></a>
      <a class="btn btn-default" href="javascript:void(0)" onclick="core.confirm('{$LANG.DEL_MOVIES_CONFIRM}', null, function() {literal}{{/literal} operationMovie('{$movie.id}', 'delete'); {literal}}{/literal})" title="{$LANG.DELETE}"><span class="glyphicon glyphicon-trash"></span></a>
</div>
{/if}
{/if}
<h1 class="con_heading">{if $movie.is_vib_red}<span class="glyphicon glyphicon-flag text-danger" title="{$LANG.EDITORS_CHOICE}!"></span> {/if}{if $movie.is_hd}<span title="{$LANG.HD_VIDEO}" class="glyphicon glyphicon-hd-video"></span> {/if}{$movie.title}{if $movie.is_adult} <span class="text-danger">18+</span>{/if}</h1>
<div class="row">
	<div class="col-lg-8">   
			{$movie.player_code}
            {if $playlist_movies}
			<div id="movie_view_sidebar">
            <div id="watch-appbar-playlist">
                <div class="main-content">
                    <div class="playlist-header">
                        <div class="playlist-header-content">
                            <div class="playlist-info">
                                <h3 class="playlist-title">
                                    <span><a href="{if $playlist.rubric_link}{$playlist.rubric_link}{else}/video/channel/{$playlist.login}.html?album_id={$playlist.id}{/if}"><span class="glyphicon glyphicon-film"></span> {$playlist.title}</a></span>
                                </h3>
                                <div class="playlist-details">
                                    {$LANG.FROM} <strong><a href="/video/channel/{$playlist.login}.html" title="{$LANG.VIEW_TO_CHANNEL}"><span class="glyphicon glyphicon-user"></span> {$playlist.nickname}</a></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="playlist-videos-container">
                        <ol class="playlist-videos-list" id="playlist-videos-list" style="height: 120px">
                            {foreach key=id item=playlist_movie from=$playlist_movies}
                            <li class="{if $playlist_movie.id == $movie.id}currently-playing{/if}" data-url="{$playlist_movie.next_link}">
                                <a class="playlist-video" title="{$playlist_movie.title|escape:'html'}" href="{$playlist_movie.movie_link}">
                                    <span class="video-thumb ">
                                        <img alt="{$playlist_movie.title|escape:'html'}" src="/upload/video/thumbs/small/{$playlist_movie.img}">
                                    </span>
                                    <div class="playlist-video-description">
                                        <h4 class="ui-ellipsis">{$playlist_movie.title|escape:'html'}</h4>
                                        <span class="video-uploader-byline">
                                            <span><span class="glyphicon glyphicon-user"></span> {$playlist_movie.nickname|escape:'html'}</span>{if $playlist_movie.duration} &nbsp;&nbsp; <span title="{$LANG.DURATION}"><span class="glyphicon glyphicon-time"></span> {$playlist_movie.duration}</span>{/if}
                                        </span>
                                    </div>
                                </a>
                            </li>
                            {/foreach}
                        </ol>
                    </div>
                </div>
            </div>
			</div>
            {/if}
<!--noindex-->
{if ($movie.ratings.like > 0) || ($movie.ratings.unlike > 0)}
		<div class="row">
			<div class="col-xs-12">
                    {if $cfg.ratings}
				<div class="progress progress-striped">
					<div class="progress-bar progress-bar-success" title="{$LANG.LIKED}: {$movie.ratings.like}" style="cursor:help;width: {$movie.ratings.like_percent}%">{if $movie.ratings.like>0}<span class="glyphicon glyphicon-thumbs-up"></span> {/if}{$movie.ratings.like}</div>
					<div class="progress-bar progress-bar-danger" title="{$LANG.DO_NOT} {$LANG.LIKED}: {$movie.ratings.unlike}" style="cursor:help;width: {$movie.ratings.unlike_percent}%">{if $movie.ratings.unlike>0}<span class="glyphicon glyphicon-thumbs-down"></span> {/if}{$movie.ratings.unlike}</div>
				</div>					
                    {/if}
			</div>	
		</div>
{/if}
		<div class="row">
			<div class="col-sm-8 col-xs-6">
            <div id="watch-user-header">
				<div class="media">
					<a class="pull-left" href="{profile_url login=$movie.login}" title="{$LANG.MOVIE_AUTHOR}"><img src="{$movie.user_avatar}" alt="{$movie.nickname|escape:'html'}" class="media-object" style="width:48px;height:48px;" /></a>
					<div class="media-body">
						<h4 class="media-heading"><a href="/video/channel/{$movie.login}.html" title="{$LANG.VIEW_TO_CHANNEL}">{$movie.nickname}</a> <span class="glyphicon glyphicon-film"></span> {$movie.video_count}</h4>
						<div class="media-hinttext">
				    <span class="{if !$user_subscribed}icn-subskr{else}icn-unsubskr{/if} monospc" id="subscription_link">
                    {if $access.is_auth}
                        {if !$access.is_author}
                            {if !$user_subscribed}
                                <a href="#" onclick="subscribe('{$movie.user_id}', 1);return false;"><span class="glyphicon glyphicon-pencil"></span> {$LANG.SUBSCRIBE}</a>
                                <a href="#" style="display: none" onclick="subscribe('{$movie.user_id}', 1);return false;">{$LANG.UNSUBSCRIBE}</a>
                            {else}
                                <a href="#" onclick="subscribe('{$movie.user_id}', 1);return false;"><span class="glyphicon glyphicon-pencil"></span> {$LANG.UNSUBSCRIBE}</a>
                                <a href="#" style="display: none" onclick="subscribe('{$movie.user_id}', 1);return false;">{$LANG.SUBSCRIBE}</a>
                            {/if}
                        {else}
                            {$LANG.SUBSCRIBED_TO_CHANNEL}
                        {/if}
                    {else}
                        <a href="#" rel="nofollow" onclick="core.alert('{$LANG.REGISTERED_ACCESS_SUBSCRIBE|escape:html}', '{$LANG.ATTENTION}');return false;"><span class="glyphicon glyphicon-pencil"></span> {$LANG.SUBSCRIBE}</a>
                    {/if}
                    </span>	
					<span id="count_subscribe" class="monospc">/ {$movie.count_subscribe|spellcount:$LANG.SUBSCRIBER1:$LANG.SUBSCRIBER2:$LANG.SUBSCRIBER10}</span>		
						</div>
					</div>
				</div>
			</div>
			</div>
			<div class="col-sm-4 col-xs-6">
                <div id="watch-views-info">
					<div class="watch-view-count" style="cursor:help;" title="{$movie.hits|spellcount:$LANG.HITS1:$LANG.HITS2:$LANG.HITS10}">{$movie.hits}
					{if $cfg.ratings}
					<span> / </span>
					<span id="movie_rating" style="cursor:help;" title="{$LANG.SUMM_RATING}">{$movie.ratings.rating}</span>
					{/if}
					</div>	
                {if $cfg.ratings}
                <div id="watch-sentiment-actions">
                    <div id="karma_mov">
                        {if $access.is_auth || $cfg.vote_for_guests}
                            {if !$movie.ratings.is_karmed && !$access.is_author}
                                <a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="likeMovie('{$movie.id}')" rel="nofollow"><span class="glyphicon glyphicon-thumbs-up"></span> {$LANG.LIKE}</a>
                                <a class="btn btn-danger btn-sm" href="javascript:void(0);" title="{$LANG.NOT_LIKE}" onclick="unlikeMovie('{$movie.id}')" rel="nofollow"><span class="glyphicon glyphicon-thumbs-down"></span></a>
                            {elseif $movie.ratings.is_karmed == '-1'}
                                <em class="liked unlike_sel">{$LANG.YOU_NOT_LIKE}!</em>
                            {elseif $movie.ratings.is_karmed == '1'}
                                <em class="liked like_sel">{$LANG.YOU_LIKE}!</em>
                            {/if}
                        {else}
                            <a class="liked like" href="#" onclick="core.alert('{$LANG.AUTH_TO_VOTE_MOVIE|escape:html}', '{$LANG.ATTENTION}');return false;" rel="nofollow">{$LANG.LIKE}</a>
                            <a class="liked unlike" href="#" onclick="core.alert('{$LANG.AUTH_TO_VOTE_MOVIE|escape:html}', '{$LANG.ATTENTION}');return false;" rel="nofollow" title="{$LANG.NOT_LIKE}"></a>
                        {/if}
                    </div>
                </div>
                {/if}					
                </div>
			</div>
		</div>
            <div id="watch-action" class="well">
                <div id="watch-secondary-actions">
                    <span><button role="button" onclick="getInfo(this);return false;" class="action-panel-trigger btn btn-default" type="button"><span>{$LANG.ABOUT_VIDEO}</span></button></span>
                    <span><button id="share_button" role="button" onclick="getShareInfo(this);return false;" class="action-panel-trigger all btn btn-default" type="button"><span>{$LANG.SHARE}</span></button></span>
                    {if !$access.is_author && !$access.is_admin}
                        <span><button role="button" title="{$LANG.MOVIE_FLAG_AS} {$LANG.OR} {$LANG.MOVIE_PLAYBACKISSUE}" onclick="reportMovie(this);return false;" class="action-panel-trigger all btn btn-default" type="button"><span>{$LANG.MOVIE_FLAG_AS}</span></button></span>
                    {/if}
                    <span><button role="button" class="action-panel-trigger all btn btn-default" type="button" id="lightsoff"><span>{$LANG.LIGHT_OFF}</span></button></span>
                    {if $access.is_auth}
                        <span><button role="button" onclick="addToDo(this);return false;" class="action-panel-trigger all btn btn-default" type="button">{$LANG.VIDEO_ADD_TO}</button></span>
                    {else}
                        <button role="button" class="action-panel-trigger all btn btn-default" type="button"  onclick="core.alert('{$LANG.AUTH_OR_REGISTERED|escape:html}', '{$LANG.ATTENTION}');return false;">{$LANG.VIDEO_ADD_TO}</button>
                    {/if}

                </div>
            </div>
            <!--/noindex-->
            <div id="watch-action-panels">
                <div class="action-panel-content" id="action-panel-details">
				{if $movie.description}
					<div class="item-description">
						{$movie.description}
					</div>
				{/if}
				<ul class="list-group">
						<li class="list-group-item"><strong>{$LANG.CAT_MOVIE}:</strong> <span><a href="{$cat.cat_link}">{$cat.title}</a></span></li>
                    {if $rubric}
                        <li class="list-group-item"><strong>{$LANG.RUBRIC}:</strong> <span><a href="{$rubric.rubric_link}" title="{$rubric.r_group|escape:'html'}">{$rubric.title}</a></span></li>
                    {/if}
                    {if $formsdata}
                        {include file='com_video_movie_form_view.tpl'}
                    {/if}
                    {if $movie.tags}
                        <li class="list-group-item"><strong>{$LANG.TAGS}:</strong> <span>{$movie.tags}</span></li>
                    {/if}
                    {if $movie.city}
                        <li class="list-group-item"><strong>{$LANG.CITY}:</strong> <span><a class="ajaxlink" href="#" onclick="openMap(this, '{$movie.title|escape:'html'}');return false;" title="{$LANG.DISPLAY_CITY}">{$movie.city}</a></span></li>
                    {/if}
					{if $movie.frecorddate}<li class="list-group-item" title="{$LANG.RECORD_DATE}"><strong>{$LANG.RECORD_DATE}:</strong>{$movie.frecorddate}</li>{/if}
                        <li class="list-group-item" title="{$LANG.MOVIES_DATE}"><strong>{$LANG.MOVIES_DATE}:</strong> {if $movie.published}<time>{$movie.fpubdate}</time>{else}<span class="text-danger" title="{$LANG.MOVIE_VISIBLE_ONLY_YOU}">{$LANG.ON_MODERATE}</span>{if $access.is_admin || $access.is_moder}<span id="published_yes"><a href="javascript:void(0)" onclick="publishMovie('{$movie.id}', '{$movie.fpubdate}');" style="color:#093">{$LANG.PUBLISH}</a></span>{/if}{/if}</li>
				</ul>
                </div>
                <div class="action-panel-content hid" id="action-panel-share">
                <div id="share_text">{include file='com_video_share_code.tpl'}</div>
                {if $access.is_auth}
                    {if $movie.my_friends}				
                    {add_js file="includes/jquery/jquery.form.js"}
                    <div class="share_code" id="recommend_form">
					<label>{$LANG.SELECT_FRIEND}</label>
                    <form action="/video/recommend.html" method="post">
                        <input type="hidden" name="id" value="{$movie.id}" />
							<div class="input-group">
								<select name="to_id" id="to_id" class="form-control">
										{$movie.my_friends}
								</select>
								<span class="input-group-btn">
									 <input type="button" id="do_recommend" class="btn btn-default" value="{$LANG.TO_RECOMMEND}" onclick="recommend();" />
								</span>
							</div>						
                    </form>
                    </div>
					{/if}
				{/if}
                </div>
                <div class="action-panel-content hid" id="action-panel-report"></div>
                <div class="action-panel-content hid" id="action-panel-addto"></div>
            </div>
						
            {if $is_comments}
                {comments target='movie' target_id=$movie.id}
            {/if}
            <script type="text/javascript">
            {literal}
            $(document).ready(function () {
                checkHeightDescr();
            });
            {/literal}
            </script>
	</div>
        
	<div class="col-lg-4">
		{ad_add pos=bottom movie=$movie} 
		{if $plugins}
            {foreach key=id item=plugin from=$plugins}
                <div id="plugin_{$plugin.name}">{$plugin.html}</div>
            {/foreach}
		{/if} 	
	</div>			
       
</div>
<script type="text/javascript">
    var show_adult_info = {$show_adult_info};
    var access_msg = '{$access_msg}';
{literal}
$(function () {
    if(show_adult_info){
        core.message('{/literal}{$LANG.MOVIE_NOTIFICATION}{literal}');
        $('#popup_overlay, #popup_cancel ,#popup_close, .popup_x_button').off('click');
        $('#popup_message').html('{/literal}{$LANG.MOVIE_NOTIFICATION_TEXT}<p>{$LANG.MOVIE_NOTIFICATION_BDAY}</p>{literal}');
        $('#popup_progress, .popup_x_button').hide();
        $('#popup_overlay').css({ opacity: '0.9' });
        $('#popup_ok').val('{/literal}{$LANG.MOVIE_IAM_18}, {$LANG.MOVIE_CONTINUE_VIEW}{literal}').show().on('click', function (){
            core.box_close();
        });
        $('#popup_cancel').val('{/literal}{$LANG.MOVIE_IAM_NO_18}, {$LANG.MOVIE_STOP_VIEW}{literal}').on('click', function (){
            window.location.href = '{/literal}{$cat.cat_link}{literal}';
        });
    }
    if(access_msg){
        core.alert(access_msg);
    }
    {/literal}{if $playlist_movies}{literal}
    ivPlayLists.after = function (){
        movie_play_list = $('#playlist-videos-list');
        movies  = $('li', movie_play_list);
        current = $('li.currently-playing', movie_play_list);
        next_id = $(movies).index(current)+1;
        next    = $(movies).eq(next_id);
        if(next.length){
            window.location.href = $(next).data('url');
        } else {
            ivPlayLists.showRelated();
        }
    };
    $('.playlist-videos-list').stop().animate({
        scrollTop: +$('.currently-playing').offset().top - +$('.playlist-videos-list').offset().top
    }, 1000);
    {/literal}{/if}{literal}
    $("input, textarea").focus(function () {
        $(this).select();
    }).mouseup(function(e){
        e.preventDefault();
    });
    lightsoff();
    $sidebar_td = $('#movie_view_sidebar');
    sidebar_html = $sidebar_td.children().length;
    if(!sidebar_html){
        $sidebar_td.remove();
        $('#player_container').css({width:$('.movie_view_content').width()});
    }
    $(".player_play").click(function() {
        autoLightsoff();
    });
});
function autoLightsoff(){
    idleTimer = null;
    idleState = false;
    idleWait  = 20000;
    $(document).bind('mousemove keydown scroll', function(){
        clearTimeout(idleTimer); // отменяем прежний временной отрезок
        if(idleState == true){
            $('#lightsoff-background')
            .fadeOut(function() {
                $('.lightsoff-background').remove();
                $('#player_code').css({'z-index' : 0 });
            });
        }
        idleState = false;
        idleTimer = setTimeout(function(){
            $('#player_code').css({ 'visibility' : 'visible', 'position' : 'relative', 'z-index' : 1999 });
            $('body').prepend('<div class="lightsoff-background" id="lightsoff-background" title="'+LANG_CLICK_LIGHT_ON+'"></div>');
            $('#lightsoff-background').css({ height: $(document).height() }).fadeIn();
            $('#lightsoff-background').show();
          idleState = true;
        }, idleWait);
    });
    $("body").trigger("mousemove");
}
function getInfo(obj){
    toggleButton(obj);
    $('.action-panel-content').hide();
    $('#action-panel-details').fadeIn();
}
function getShareInfo(obj){
    toggleButton(obj);
    $('div.share_info').remove();
    $('.action-panel-content').hide();
    $('#action-panel-share').fadeIn();
}
function toggleButton(obj){
    $('.action-panel-trigger').addClass('all');
    $(obj).removeClass('all');
}
function recommend(){
    $('#do_recommend').prop('disabled', true).val('{/literal}{$LANG.LOADING}{literal}');
    var options = {
        success: doRecommend
    };
    $('#recommend_form form').ajaxSubmit(options);
}
function doRecommend(result, statusText, xhr, $form){
    if(statusText == 'success'){
        if(result.error == false){
            core.alert(result.info, '{/literal}{$LANG.ATTENTION}{literal}');
            $('#recommend_form').hide();
        }
    } else {
        core.alert(statusText, '{/literal}{$LANG.ATTENTION}{literal}');
    }
}
function reportMovie(obj){
    toggleButton(obj);
    $('.action-panel-content').hide();
    $('#action-panel-report').html('<div class="player_play_loading"></div>').show();
	$.post('/components/video/ajax/report.php', {id: {/literal}{$movie.id}{literal}}, function(data){
        $('#action-panel-report').html(data);
	});
}
function addToDo(obj){
    toggleButton(obj);
    $('.action-panel-content').hide();
    $('#action-panel-addto').html('<div class="player_play_loading"></div>').show();
	$.post('/video/get_playlists', {movie_id: {/literal}{$movie.id}{literal}}, function(data){
        $('#action-panel-addto').html(data);
	});
}
{/literal}
</script> 