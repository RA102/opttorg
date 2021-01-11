<div class="com-clubs">
<div class="float_bar">
 {if $is_author || $is_admin || $is_moder}<a class="btn btn-default" href="javascript:void(0)" onclick="clubs.editPhoto({$photo.id});return false;">{$LANG.EDIT}</a> {if $is_admin || $is_moder}{if !$photo.published}<span id="pub_photo_link"><a class="btn btn-default" href="javascript:void(0)" onclick="clubs.publishPhoto({$photo.id});return false;">{$LANG.PUBLISH}</a></span>{/if} <a class="btn btn-default" href="javascript:void(0)" onclick="clubs.deletePhoto({$photo.id}, '{csrf_token}');return false;">{$LANG.DELETE}</a>{/if}{/if}
</div>
<h1 class="con_heading">{$photo.title}</h1>
{if $photo.description}
    <div class="item-description"> {$photo.description|nl2br} </div>
{/if}
<div class="row singlephoto-row">
	<figure class="col-md-9 col-sm-7 img-col">
          {if $is_exists_original}
              <a href="/images/photos/{$photo.file}" class="photobox"><img src="/images/photos/medium/{$photo.file}" alt="{$photo.title|escape:'html'}" id="view_photo" /></a>
          {else}
              <img src="/images/photos/medium/{$photo.file}" alt="{$photo.title|escape:'html'}" id="view_photo" />
          {/if}	
		  {if $photo.previd.file}
		  <a class="u-prev1" style="background-image:url(/images/photos/small/{$photo.previd.file});" href="/clubs/photo{$photo.previd.id}.html#main" title="{$LANG.PREVIOUS}"><span class="glyphicon glyphicon-chevron-left"></span></a>
		  {/if}
		  {if $photo.nextid.file}
		  <a class="u-next1" style="background-image:url(/images/photos/small/{$photo.nextid.file});" href="/clubs/photo{$photo.nextid.id}.html#main" title="{$LANG.NEXT}"><span class="glyphicon glyphicon-chevron-right"></span></a>
			{/if}
	</figure>
	<div class="col-md-3 col-sm-5">
	<div class="well">
{if $photo.karma_buttons}
	<div class="pull-right">{$photo.karma_buttons}</div>
{/if}	
<span class="glyphicon glyphicon-star"></span> {$LANG.RATING}: <span id="karmapoints">{$photo.rating|rating}</span> <br /> <span class="glyphicon glyphicon-eye-open"></span> {$LANG.HITS}:  {$photo.hits} <br /> <span class="glyphicon glyphicon-time"></span> {if !$photo.published}<span id="pub_photo_wait" style="color:#F00;">{$LANG.WAIT_MODERING}</span><span id="pub_photo_date" style="display:none;">{$photo.pubdate|date_format:"%d/%m/%y"}</span>{else}{$photo.pubdate|date_format:"%d/%m/%y"}{/if} <br /> <a style="color:#666;" href="{profile_url login=$photo.login}"><span class="glyphicon glyphicon-user"></span> {$photo.nickname}</a></p>
	</div>
    </div>
</div>
</div>