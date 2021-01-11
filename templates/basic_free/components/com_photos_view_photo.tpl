{if $is_author || $is_admin}
<div class="float_bar">
<a class="btn btn-default" href="javascript:void(0)" onclick="photos.editPhoto({$photo.id});return false;">{$LANG.EDIT}</a>{if $is_admin} <a class="btn btn-default" href="javascript:void(0)" onclick="photos.movePhoto({$photo.id});return false;">{$LANG.MOVE}</a>{if !$photo.published}<span id="pub_photo_link"> <a class="btn btn-default" href="javascript:void(0)" onclick="photos.publishPhoto({$photo.id});return false;">{$LANG.PUBLISH}</a></span>{/if}{/if} <a class="btn btn-default" href="javascript:void(0)" onclick="photos.deletePhoto({$photo.id}, '{csrf_token}');return false;">{$LANG.DELETE}</a>
</div>
{/if}
<h1 class="con_heading">{$photo.title}</h1>

{if $photo.description}
    <div class="item-description">
        {$photo.description|nl2br}
    </div>
{/if}

<div class="row singlephoto-row">
	<div class="col-md-9 col-sm-8 img-col">
            <img src="/images/photos/medium/{$photo.file}" alt="{$photo.title|escape:'html'}" />
            {if $photo.album_nav}
                    {if $previd}
                        <a class="u-prev1" href="/photos/photo{$previd.id}.html" title="{$LANG.PREVIOUS}"><span class="glyphicon glyphicon-chevron-left"></span></a>
                    {/if}
                    {if $nextid}
                        <a class="u-next1" href="/photos/photo{$nextid.id}.html" title="{$LANG.NEXT}"><span class="glyphicon glyphicon-chevron-right"></span></a>
                    {/if}
			{/if}			
	</div>
	<div class="col-md-3 col-sm-4">
            <div class="well">
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td valign="top">
                            <p><strong>{$LANG.RATING}: </strong><span id="karmapoints">{$photo.rating|rating}</span></p>
                            <p><strong>{$LANG.HITS}: </strong> {$photo.hits}</p>
                        </td>
                        {if $photo.karma_buttons}
                            <td width="16" valign="top">{$photo.karma_buttons}</td>
                        {/if}
                    </tr>
                </table>
                <div class="photo_date_details">
                    <p>{if !$photo.published}<span id="pub_photo_wait" style="color:#F00;">{$LANG.WAIT_MODERING}</span><span id="pub_photo_date" style="display:none;">{$photo.pubdate}</span>{else}<time datetime="{$photo.pubdate}">{$photo.pubdate}</time>{/if}</p>
                    <p>{$photo.genderlink}</p>
                </div>

                {if $cfg.link}
                    <p class="photo_date_details"><a class="lightbox-enabled" rel="lightbox-galery" href="/images/photos/{$photo.file}" title="{$photo.title|escape:'html'}">{$LANG.OPEN_ORIGINAL}</a></p>
                {/if}

            </div>
            {if $photo.album_nav}
                <div class="photo_sub_details">
                    &mdash; {$LANG.BACK_TO} <a href="/photos/{$photo.album_id}">{$LANG.TO_ALBUM}</a><br/>
                    &mdash; {$LANG.BACK_TO}  <a href="/photos">{$LANG.TO_LIST_ALBUMS}</a><br/>&nbsp;
                </div>
            {/if}
            {if $photo.a_bbcode}
            <div class="well">
                {$LANG.CODE_INPUT_TO_FORUMS}:<br/>
                <input onclick="$(this).select();" type="text" class="photo-bbinput" value="{$bbcode}"/>
            </div>
            {/if}
				{if $tagbar}
            <div class="photo-tagbar">
               <span class="glyphicon glyphicon-tag"></span> {$tagbar}
            </div>
				{/if}

    </div>
</div>