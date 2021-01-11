{if !$of_ajax}
<link href="/templates/{template}/css/invideo.css" rel="stylesheet" type="text/css" />
{literal}
<style type="text/css">
#movie_list .sort li{
	height: auto;
    width: 203px;
}
#movie_list .sort{
    overflow: hidden;
    padding: 7px 0 7px 10px;
}
.box_title_wrap {
    background-color: #5D90D1;
    border-color: #45688E #43658A;
    border-style: solid;
    border-width: 1px;
    color: #FFFFFF;
    font-size: 1.18em;
    font-weight: bold;
    padding: 0;
}
.box_x_button {
    cursor: pointer;
    float: right;
    height: 17px;
    margin: 7px 5px 0;
    padding: 0;
    width: 17px;
}
.box_title {
    border-top: 1px solid #648CB7;
    padding: 6px 10px 8px;
}
#movie_list .thumb:hover .thumb_hover {
background: none;
}
</style>
{/literal}

<div style="background:#FFF; overflow: hidden; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.35);">
<div class="box_title_wrap" style=""><div class="box_x_button simplemodal-close">X</div><div class="box_title">{$LANG.SELECT_MOVIE} (<span id="perpage">{$perpage}</span> {$LANG.OF} {$total})</div></div>
{if $movies}
<div id="movie_list" style="overflow-x: hidden; overflow-y: auto; height:450px; clear:both; border: 1px solid #45688E; border-top:none; position:relative; width: 680px;">
<div class="loader hid">{$LANG.LOADING}...</div>
<input type="hidden" id="total_pages" value="{$total_pages}" />
<input type="hidden" id="field_id" value="{$field_id}" />
    <ul class="sort" id="p_bb_movie">
      {foreach key=tid item=movie from=$movies}
          <li>
          <a href="javascript:addVideo({$movie.id}, '{$field_id}')" class="thumb"><img src="/upload/video/thumbs/small/{$movie.img}" alt="{$movie.title|escape:'html'}">{if $movie.is_adult}<span class="censored">18+</span>{/if}{if $movie.orig_duration}<span title="{$LANG.DURATION}" class="duration">{$movie.duration}</span>{/if}<span class="thumb_hover"></span>{if $movie.is_hd}<span class="is_hd" title="{$LANG.HD_VIDEO}">HD</span>{/if}</a>
            <h5><a href="{$movie.movie_link}" title="{$LANG.VIEW_MOVIE} - {$movie.title|escape:'html'}" target="_blank">{$movie.s_title|truncate:30}</a></h5>
          </li>
      {/foreach}
      </ul>
</div>
{else}
	<p>{$LANG.USER_NOT_UPLOAD_MOVIE}...</p>
{/if}
</div>
{else}
    {if $movies}
          {foreach key=tid item=movie from=$movies}
              <li>
              <a href="javascript:addVideo({$movie.id}, '{$field_id}')" class="thumb"><img src="/upload/video/thumbs/medium/{$movie.img}" alt="{$movie.title|escape:'html'}">{if $movie.is_adult}<span class="censored">18+</span>{/if}{if $movie.orig_duration}<span title="{$LANG.DURATION}" class="duration">{$movie.duration}</span>{/if}<span class="thumb_hover"></span>{if $movie.is_hd}<span class="is_hd" title="{$LANG.HD_VIDEO}">HD</span>{/if}</a>
                <h5><a href="{$movie.movie_link}">{$movie.s_title|truncate:30}</a></h5>
              </li>
          {/foreach}
    {/if}
{/if}