<div id="player_code">
    <div id="player_container">
        {if $show_title}
            <div id="movie_embed_title"><a href="{$movie.movie_link}" target="_blank">{$movie.title}</a></div>
        {/if}
        {if $is_share_info}
            <div class="movie_id_view" title="{$LANG.MOVIE_ID}"># {$movie.id}</div>
        {/if}
        {if !$movie.ad_html}
        	<div class="player_play"></div>
        	<div class="poster_img" style="background: url(/upload/video/thumbs/medium/{$movie.img}) no-repeat center center; background-size: cover;"></div>
        {else}
            <div id="pseudo_ad_body">{$movie.ad_html}</div>
        {/if}
        {if $movie.orig_duration}
            <div class="duration"><span title="{$LANG.DURATION}"><span class="glyphicon glyphicon-time"></span> {$movie.duration}</span>{if $movie.size}&nbsp;&nbsp;<span title="{$LANG.SIZE}"><span class="glyphicon glyphicon-hdd"></span> {$movie.size}</span>{/if}</div>
        {/if}
    </div>
    {if $is_share_info}
    <div class="player_share" onclick="showShare();return false;">{$LANG.SHARE}</div>
    <div class="player_share_close hid" onclick="hideShare();return false;"></div>
    <div class="share_info hid">
        <div class="share_code">
            <p><strong>{$LANG.MOVIE_LINK}:</strong></p>
            <input type="text" readonly="readonly" onclick="$(this).select();" class="site_link" value="{$movie.link_movie|escape:'html'}"/>
        </div>
        {if $movie.movie_code}
            {include file='com_video_share_code.tpl'}
        {/if}
    </div>
    {/if}
    <script type="text/javascript">
    var movie_id = '{$movie.id}';
    var play_headers = {$play_headers};
    {if $cfg.autoplay && !$movie.ad_html}
        {literal}
            $(function(){
                playMovie(movie_id, play_headers);
            });
        {/literal}
    {/if}
    {literal}
        $(function(){
            $(document).on('click', '.player_play, .replay', function() {
                playMovie(movie_id, play_headers);
            });
        });
    {/literal}
    </script>
</div>