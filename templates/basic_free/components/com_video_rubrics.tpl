    <div class="float_bar">
        {if $is_can_add_rubric}
            <a class="btn btn-default" href="/video/add_rubric.html"><span class="glyphicon glyphicon-plus-sign"></span> {$LANG.RUBRIC_ADD}</a>
        {/if}
    	{if $group}
    		<a class="btn btn-default" href="/video/rubrics/search/all" rel="nofollow"><span class="glyphicon glyphicon-film"></span> {$LANG.ALL_RUBRICS}</a>
        {/if}
    	<a class="btn btn-default" href="javascript:void(0)" rel="nofollow" onclick="getViewRubrics('table')" title="{$LANG.VIEW_MODE}: {$LANG.VIEW_MODE_TABLE}">{if $rub_view=='table'}<strong><span class="glyphicon glyphicon-th"></span> {$LANG.VIEW_MODE_TABLE}</strong>{else}<span class="glyphicon glyphicon-th"></span> {$LANG.VIEW_MODE_TABLE}{/if}</a>
        <a class="btn btn-default" href="javascript:void(0)" rel="nofollow" onclick="getViewRubrics('list')" title="{$LANG.VIEW_MODE}: {$LANG.VIEW_MODE_LIST}">{if $rub_view=='list'}<strong><span class="glyphicon glyphicon-list"></span> {$LANG.VIEW_MODE_LIST}</strong>{else}<span class="glyphicon glyphicon-list"></span> {$LANG.VIEW_MODE_LIST}{/if}</a>
    </div>

<h1 class="con_heading">{$LANG.RUBRICS}{if $group} :: {$group}{/if}</h1>

{if $rubrics}
<div class="breaker"></div>
    {assign var="last_group" value=''}

	{if $rub_view=='table'}
          {foreach key=tid item=rubric from=$rubrics}
          {if !$group && $rubric.r_group != $last_group}
  			<li class="rubric_groups"><h2><a href="{$rubric.group_url}">{$rubric.r_group}</a></h2></li>
          {/if}
		  <div class="row margin-bottom-row">
			<div class="col-md-4 media-gird">
				<a title="{$rubric.title|escape:'html'}" href="{$rubric.rubric_link}"><img src="{$rubric.image_url}" alt="{$rubric.title|escape:'html'}" class="media-object" /></a>
			</div>
			<div class="col-md-8">
			
			</div>
		  </div>
              <li>
              <div class="more_info">
                  <span class="icn-rating">{$rubric.rating}</span>
                  <span class="icn-movies">{$rubric.movie_count|spellcount:$LANG.MOVIE1:$LANG.MOVIE2:$LANG.MOVIE10}</span>
              </div>
                <a class="cover_img" href="{$rubric.rubric_link}" style="background: url({$rubric.image_url}) no-repeat center center; background-size: cover;"></a>
                <h3>
                    <a title="{$rubric.title|escape:'html'}" href="{$rubric.rubric_link}">{$rubric.title|truncate:20}</a>
                </h3>
              </li>
              {assign var="last_group" value=$rubric.r_group}
          {/foreach}
      {else}

          {foreach key=tid item=rubric from=$rubrics}
          {if !$group && $rubric.r_group != $last_group}
			<div class="row"><div class="col-xs-12"><h2 class="well"><a href="{$rubric.group_url}">{$rubric.r_group}</a></h2></div></div>
          {/if}
		  
		  <div class="row margin-bottom-row">
			<div class="col-md-4 media-gird">
				<a title="{$rubric.title|escape:'html'}" href="{$rubric.rubric_link}"><img src="{$rubric.image_url}" alt="{$rubric.title|escape:'html'}" class="media-object" /></a>
			</div>
			<div class="col-md-8">
				<h3 class="media-heading"><a href="{$rubric.rubric_link}">{$rubric.title}</a></h3>
				{if $rubric.strip_tags_text}
                <div class="media-description">
                    {$rubric.strip_tags_text|truncate:$cfg.rub_num_cut}
                </div>
                {/if}
                <div class="media-hinttext">
                      <span class="monospc"><span class="glyphicon glyphicon-star"></span> {$rubric.rating}</span>
                      <span class="monospc"><span class="glyphicon glyphicon-share-alt"></span> 
{if $rubric.comments_count} {$rubric.comments_count|spellcount:$LANG.COMMENT1:$LANG.COMMENT2:$LANG.COMMENT10}{else}{$LANG.NO} {$LANG.COMMENT10}{/if}</span>
                      <span class="monospc"><span class="glyphicon glyphicon-film"></span> {$rubric.movie_count|spellcount:$LANG.MOVIE1:$LANG.MOVIE2:$LANG.MOVIE10}</span>
				</div>				
			</div>
		  </div>		  
              {assign var="last_group" value=$rubric.r_group}
          {/foreach}

      {/if}
      {$pagebar}
{else}
<p class="text-danger">{$LANG.MOVIE_NOT_FOUND_IN_RUBRIC}...</p>
{/if}