{if $cfg.rub_view == 'table'}
{$col="1"}
      {foreach key=tid item=rubric from=$rubrics name=vidru}
        {if $col==1}<div class="row margin-bottom-row">{/if}
	<div class="col-lg-4">
<div class="media">
	<a class="pull-left" title="{$rubric.title|escape:'html'}" href="{$rubric.rubric_link}"><img src="{$rubric.image_url}" class="media-object" /></a>
	<div class="media-body">
		<h4 class="media-heading"><a title="{$rubric.title|escape:'html'}" href="{$rubric.rubric_link}">{$rubric.title|truncate:35}</a></h4>
		<div class="media-hinttext">
            <span class="monospc"><span class="glyphicon glyphicon-star"></span> {$rubric.rating}</span>
            <span class="monospc"><span class="glyphicon glyphicon-film"></span> {$rubric.movie_count|spellcount:$LANG.MOVIE1:$LANG.MOVIE2:$LANG.MOVIE10}</span>	
			{if !$group && $rubric.r_group != $last_group}<a href="{$rubric.group_url}">&rarr; {$rubric.r_group}</a>{/if}
		</div>
	</div>
</div>
	</div>
    {assign var="last_group" value=$rubric.r_group}
{if $col==3 || $smarty.foreach.vidru.last}</div>{$col="1"}{else}{$col=$col+1}{/if}		  
      {/foreach}
{elseif $cfg.rub_view == 'slider'}

    {assign var="rubric_count" value=$rubrics|@count}
    {add_js file='components/video/js/owl-carousel/owl.carousel.min.js'}
    {add_css file='components/video/js/owl-carousel/owl.carousel.css'}
    <script type="text/javascript">
        var module_id = '{$module_id}';
        var is_pag    = {$cfg.is_pag};
        var is_nav    = {$cfg.is_nav};
        var autoplay  = {$cfg.autoplay};
    {literal}
        $(document).ready(function() {
          $('#owl'+module_id).owlCarousel({
              autoPlay: autoplay,
              stopOnHover : true,
              pagination: is_pag,
              paginationNumbers: true,
              navigation: is_nav,
              navigationText : [LANG_PREVIOUS,LANG_NEXT],
              items : 3
          });
          $('#owl'+module_id+' .owl-controls').prepend('<h2>'+LANG_RUBRICS+'</h2>');
        });
    {/literal}
    </script>
    <div id="owl{$module_id}" class="owl">
        {foreach key=tid item=rubric from=$rubrics}
            <div class="item">
                <a href="{$rubric.rubric_link}" {if $rubric_count < 3}class="a_img1_2"{else}class="a_img3"{/if}>
                    <img src="{$rubric.image_url}" alt="{$rubric.title|escape:'html'}" />
                </a>
                <h3><a title="{$rubric.title|escape:'html'}" href="{$rubric.rubric_link}">{$rubric.title|truncate:20}</a></h3>
                <div class="minfo">
                    <span class="icn-rating">{$rubric.rating}</span>
                    <span class="icn-movies" title="{$rubric.movie_count|spellcount:$LANG.MOVIE1:$LANG.MOVIE2:$LANG.MOVIE10}">{$rubric.movie_count}</span>
                </div>
                {if $rubric.strip_tags_text}
                    <div class="owl_descr{if $rubric_count >= 3} owl_descr3{/if}">
                        {$rubric.strip_tags_text|truncate:$component_cfg.rub_num_cut}
                    </div>
                {/if}
            </div>
        {/foreach}
    </div>

{else}
{literal}<style>.rub_title a {color:#666;border-bottom:#666 1px dashed;} .rub_title {text-align:center;width:100%;padding:5px 10px;font-size:1.2em;}</style>{/literal}
    {foreach key=tid item=rubric from=$rubrics}
    {if !$group && $rubric.r_group != $last_group}
    <div class="rub_title"><a href="{$rubric.group_url}">{$rubric.r_group}</a></div>
    {/if}	
<div class="media {cycle values="rowa1,rowa2"}">
	<a class="pull-left" title="{$rubric.title|escape:'html'}" href="{$rubric.rubric_link}"><img src="{$rubric.image_url}" class="media-object" /></a>
	<div class="media-body">
		<h4 class="media-heading"><a title="{$rubric.title|escape:'html'}" href="{$rubric.rubric_link}">{$rubric.title|truncate:35}</a></h4>
        {if $rubric.strip_tags_text}
        <div class="media-description">
            {$rubric.strip_tags_text|truncate:$component_cfg.rub_num_cut}
        </div>
        {/if}		
		<div class="media-hinttext">
            <span class="monospc"><span class="glyphicon glyphicon-star"></span> {$rubric.rating}</span>
            <span class="monospc"><span class="glyphicon glyphicon-film"></span> {$rubric.movie_count|spellcount:$LANG.MOVIE1:$LANG.MOVIE2:$LANG.MOVIE10}</span>	
		</div>
	</div>
</div>	
      {assign var="last_group" value=$rubric.r_group}
    {/foreach}

{/if}