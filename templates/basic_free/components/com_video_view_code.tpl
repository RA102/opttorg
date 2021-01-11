<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background:#333;">
  <tr>
    <td width="35px" {if $prev_movie_link}class="nav_movie" onclick="getMovieToView('{$prev_movie_link.id}', '{$prev_movie_link.pubdate|strtotime}');"{/if} align="center" valign="middle">{if $prev_movie_link}<img src="/templates/{template}/images/video/slideLeft.png" />{/if}</td>
    <td width="{$cfg.channel_width}px">
        {$currient_movie.player_code}
        <div id="channel_movie_info">
            <h2><a href="{$currient_movie.movie_link}">{$currient_movie.title|truncate:63}</a></h2>
            <div><a id="lightsoff" href="javascript:void(0)" class="ajax_link lightsoff_channel">{$LANG.LIGHT_OFF}</a></div>
        </div>
    </td>
    <td width="35px" {if $next_movie_link}class="nav_movie" onclick="getMovieToView('{$next_movie_link.id}', '{$next_movie_link.pubdate|strtotime}');"{/if} align="center" valign="middle">{if $next_movie_link}<img src="/templates/{template}/images/video/slideRight.png" />{/if}</td>
  </tr>
</table>
<input type="hidden" name="current_mov_id" value="{$currient_movie.id}" />
<script type="text/javascript">
	{literal}
	$(document).ready(function(){
		lightsoff();
	});
{/literal}
</script>