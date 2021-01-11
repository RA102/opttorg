{if $rubric_cats || $rubric.r_group || $is_auth}
<div class="float_bar">
    {if $rubric.r_group}<a href="{$rubric.group_url}" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> {$rubric.r_group}</a>{/if}
    {if $is_can_edit_rubric}
        <a class="btn btn-default" href="/video/edit_rubric{$rubric.id}.html" title="{$LANG.RUBRIC_EDIT}"><span class="glyphicon glyphicon-pencil"></span></a>
    {/if}
    {if $is_auth}
        <a class="btn btn-default" href="/video{if $rubric_cats}/{$rubric_cat.cat_id}{/if}/add{$rubric.id}.html"><span class="glyphicon glyphicon-plus-sign"></span> {$LANG.MOVIE_ADD}</a>
    {/if}
</div>
{/if}
<h1 class="con_heading">{$rubric.title}</h1> 
<div class="well no-padding-bottom">
<div class="row margin-bottom-row">
	<div class="col-md-4">
{if $rubric.image}
    {if $rubric.more_img_array}
        <div class="media-gird" onclick="nextImg();" style="cursor:pointer;">
            <!--noindex-->
            <script type="text/javascript">
                var more_img_array = ['{$rubric.img_path}',
                {foreach key=tid item=more_img from=$rubric.more_img_path}
                    '{$more_img}',
                {/foreach}
                    ];
                var current = 1;
                var count   = more_img_array.length-1;
                {literal}
                function nextImg(){
                    var new_img = new Image();
                    new_img_src = more_img_array[current];
                    new_img.src = new_img_src;
                    $('#more_img').animate({
                        opacity: 0.0
                    }, 350, function(){
                        $('#more_img').attr('src', new_img_src);
                    });
                    new_img.onload = function(){
                            $('#more_img').animate({
                                opacity: 1.0
                            }, 350);
                        };
                    if (current == count) {
                        current = 0;
                    } else {
                        current += 1;
                    }
                }
                {/literal}
            </script>
            <!--/noindex-->
            <img id="more_img" class="media-object" src="{$rubric.img_path}" alt="{$rubric.title|escape:'html'}"/>
			<div class="more-media-info"><span class="glyphicon glyphicon-refresh"></span> {$rubric.more_img_array|@count|spellcount:$LANG.POSTER1:$LANG.POSTER2:$LANG.POSTER10}, {$LANG.CLICK_TO_VIEW} </div>
        </div>
    {else}
        <img id="more_img" class="media-object" src="{$rubric.img_path}" alt="{$rubric.title|escape:'html'}"/>
    {/if}
{/if}
	</div>
{if $rubric.description || $rubric_cats}
	<div class="col-md-{if $rubric.is_rating}6{else}8{/if}">
	{if $rubric_cats}
	<div class="list-group">
    	{foreach key=tid item=rubric_cat from=$rubric_cats}
        	<a href="{$rubric_cat.cat_link}" class="list-group-item">{$rubric_cat.title}</a>
    	{/foreach}
	</div>
    {/if}	
   {$rubric.description}
	</div>
{/if}	
{if $rubric.is_rating}
	<div class="col-md-2"><div class="blog-header-karma">{$karma_form}</div></div>
{/if}
</div>
</div>
{if $movies}
	{$col="1"}
	{foreach key=tid item=movie from=$movies name=viderub}
	{if $col==1}<div class="row margin-bottom-row videorow">{/if}
		<div class="col-md-4">
			<div {if $movie.is_viewed}class="media media-viewed"{else}class="media"{/if}>
				<a href="{$movie.movie_link}" title="{if $movie.is_viewed}{$LANG.IS_VIEWED}: {/if}{$movie.title|escape:'html'}" class="pull-left{if $movie.custom_img} start_rotation{/if}"{if $cfg.lightbox_on_cat} onclick="getMovieLightboxNoNav(this);return false;" id="{$movie.id}"{/if}><img src="/upload/video/thumbs/small/{$movie.img}" class="media-object{if $movie.is_viewed} watched_img{/if}" {if $movie.custom_img}data-custom_img="{$movie.custom_img|json_encode|escape:html}" {/if}alt="{if $movie.is_viewed}{$LANG.IS_VIEWED}: {/if}{$movie.title|escape:'html'}" /><span class="glyph-icon-play glyphicon glyphicon-play"></span></a>
				<div class="media-body">
					<h4 class="media-heading"><a href="{$movie.movie_link}" title="{if $movie.is_viewed}{$LANG.IS_VIEWED}: {/if}{$movie.title|escape:'html'}">{if !$movie.published}<span class="glyphicon glyphicon-eye-close" style="color:red;" title="{$LANG.ON_MODERATE}"></span> {/if}{if $movie.is_hd}<span class="glyphicon glyphicon-hd-video" title="{$LANG.HD_VIDEO}"></span> {/if}{$movie.s_title}</a></h4>
					<div class="media-hinttext">
                <span class="monospc"><span class="glyphicon glyphicon-play"></span> {$movie.hits}</span>
                <span class="monospc"><span class="glyphicon glyphicon-star"></span> {$movie.rating}</span>
                <span class="monospc"><span class="glyphicon glyphicon-share-alt"></span> {$movie.comments}</span>
			  {if $movie.orig_duration}<span title="{$LANG.DURATION}" class="monospc"><span class="glyphicon glyphicon-time"></span> {$movie.duration}</span>{/if}				
                {if $is_nested}
                <a class="monospc" href="{$movie.cat_link}" title="{$movie.cat_title|escape:'html'}"><span class="glyphicon glyphicon-film"></span> {$movie.cat_title|truncate:18}</a>
                {/if}	
			  {if $movie.is_adult}<span class="censored">18+</span>{/if}
					</div>
				</div>			
			</div>
		</div>
	{if $col==3 || $smarty.foreach.viderub.last}</div>{$col="1"}{else}{$col=$col+1}{/if}	
	{/foreach}
      {$pagebar}
{if $rubric.is_comments}
    {comments target='video_rubric' target_id=$rubric.id}
{/if}
{else}
    <p class="text-danger">{$LANG.MOVIE_NOT_FOUND_IN_RUBRIC}...</p>
{/if}