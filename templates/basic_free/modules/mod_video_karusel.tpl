{if $cfg.karusel == 'imageflow'}
    {literal}
        <script type="text/javascript">
            $(document).ready(function(){
                var editors_choice = new ImageFlow();
                editors_choice.init({ ImageFlowID: 'editors_choice',
                                         slideshow: true,
                                         reflectPath: '/modules/mod_video_karusel/imageflow/',
                                         reflectionGET: '&bgc=ffffff&fade_start=20%',
                                         slideshowSpeed: 5000,
                                         aspectRatio: 2.333,
                                         circular: true,
                                         imagesM: 0.9,
                                         imageCursor: 'pointer',
                                         slideshowAutoplay: {/literal}{$cfg.is_autoplay}{literal},
                                         slider: false });
                        });
        </script>
    {/literal}

    <div id="editors_choice" class="imageflow">
    {foreach key=tid item=movie from=$items_mod}
        <img src="/upload/video/thumbs/medium/{$movie.img}" longdesc="{$movie.movie_link}" width="450" height="350" alt="{$movie.title|escape:'html'}" />
    {/foreach}
    </div>
{elseif $cfg.karusel == 'bkosborne'}
<div id="carousel-example-video" class="carousel slide" data-ride="carousel">
{$col="0"}
  <ol class="carousel-indicators">
  {foreach key=tid item=movie from=$items_mod name=videored}
	<li data-target="#carousel-example-video" data-slide-to="{$col}"{if $smarty.foreach.videored.first}class="active"{/if}></li>
  {$col=$col+1}
  {/foreach}
  </ol>
  <div class="carousel-inner">
         {foreach key=tid item=movie from=$items_mod name=videored2}
    <a href="{$movie.movie_link}" title="{$movie.title|escape:'html'}" class="item{if $smarty.foreach.videored2.first} active{/if}">
      <img src="/upload/video/thumbs/medium/{$movie.img}" alt="{$movie.title|escape:'html'}" />
      <div class="carousel-caption">
        <h3>{$movie.title}</h3>
          {if $movie.description}
            <p>{$movie.description|strip_tags|truncate:100}</p>
		  {/if}
      </div>
    </a>		 
        {/foreach}  
  </div>
  <a class="left carousel-control" href="#carousel-example-video" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#carousel-example-video" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div>  
{else}
{$col="1"}
    {foreach key=tid item=movie from=$items_mod name=videored}
	{if $col==1}<div class="row margin-bottom-row videorow">{/if}	
	<div class="col-md-4">
		<div class="media">
			<a title="{$movie.title|escape:'html'}" href="{$movie.movie_link}" class="pull-left{if $movie.custom_img} start_rotation{/if}"><img src="/upload/video/thumbs/small/{$movie.img}" {if $movie.custom_img}data-custom_img="{$movie.custom_img|json_encode|escape:html}"{/if} class="media-object" alt="{$movie.title|escape:'html'}" /><span class="glyph-icon-play glyphicon glyphicon-play"></span></a>
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
		</div>
	</div>
	{if $col==3 || $smarty.foreach.videored.last}</div>{$col="1"}{else}{$col=$col+1}{/if}			
    {/foreach}
{/if}