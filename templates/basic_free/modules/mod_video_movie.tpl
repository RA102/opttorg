	{$col="1"}
    {foreach key=tid item=movie from=$items_mod name=videomod}
	{if $col==1}<div class="row margin-bottom-row videorow{if $cfg.showtype == 'short'} shortvideo{/if}">{/if}	
	<div class="{if $cfg.showtype=='full_list'}col-xs-12{else}col-md-4{/if}">
		<div class="media">
			<a title="{$movie.title|escape:'html'}" href="{$movie.movie_link}" class="pull-left{if $movie.custom_img} start_rotation{/if}"><img src="/upload/video/thumbs/small/{$movie.img}" {if $movie.custom_img}data-custom_img="{$movie.custom_img|json_encode|escape:html}"{/if} class="media-object" alt="{$movie.title|escape:'html'}" /><span class="glyph-icon-play glyphicon glyphicon-play"></span></a>
			{if $cfg.showtype != 'short'}
			<div class="media-body">
				<h4 class="media-heading"><a href="{$movie.movie_link}">{$movie.s_title}</a></h4>
				<div class="media-hinttext">
                  {if $cfg.showtype=='full_list'}
                <span class="monospc"><span class="glyphicon glyphicon-calendar"></span> {$movie.fpubdate}</span>
                  {/if}
                <span class="monospc"><span class="glyphicon glyphicon-play"></span> {$movie.hits}</span>
                <span class="monospc"><span class="glyphicon glyphicon-star"></span> {$movie.rating}</span>
                <span class="monospc"><span class="glyphicon glyphicon-share-alt"></span> {$movie.comments}</span>
                <a class="monospc" href="{$movie.cat_link}" title="{$movie.cat_title|escape:'html'}"><span class="glyphicon glyphicon-film"></span> {$movie.cat_title|truncate:18}</a>				
				</div>			
			</div>
			{/if}
		</div>
	</div>
	{if $col==3 || $smarty.foreach.videomod.last}</div>{$col="1"}{else}{$col=$col+1}{/if}			
    {/foreach}

{if $cfg.showmore}
    <div style="margin: 5px 0 0 0"><a href="{$movie.cat_link}" class="btn btn-default">{$movie.cat_title}</a> <a href="/rss/video/{$movie.cat_id}/feed.rss"  class="btn btn-default"><span class="glyphicon glyphicon-signal"></span></a></div>
{/if}
{if $cfg.showtype == 'short'}
{literal}
<script type="text/javascript">
$(document).ready(function() {
	$('.modulebody .sort li').css('height', '120px');
});
</script>
{/literal}
{/if}