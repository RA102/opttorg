	{$col="1"}
	{foreach key=tid item=movie from=$movies name=similars}
	{if $col==1}<div class="row margin-bottom-row videorow">{/if}
		<div class="col-md-4">
			<div class="media">
				<a href="{$movie.movie_link}" title="{$movie.title|escape:'html'}" class="pull-left"><img src="/upload/video/thumbs/medium/{$movie.img}" class="media-object" alt="{$movie.title|escape:'html'}" /><span class="glyph-icon-play glyphicon glyphicon-play"></span></a>
				<div class="media-body">
					<h4 class="media-heading"><a href="{$movie.movie_link}" title="{$movie.title|escape:'html'}">{$movie.s_title}</a></h4>
					<div class="media-hinttext">
			  {if $movie.orig_duration}<span title="{$LANG.DURATION}" class="monospc"><span class="glyphicon glyphicon-time"></span> {$movie.duration}</span>{/if}	
			  {if $movie.is_adult}<span class="censored">18+</span>{/if}
					</div>
				</div>			
			</div>
		</div>
	{if $col==3 || $smarty.foreach.similars.last}</div>{$col="1"}{else}{$col=$col+1}{/if}	
	{/foreach}
<div class="replay">{$LANG.VIDEO_REPLAY}</div>