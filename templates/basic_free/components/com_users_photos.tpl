{if ($my_profile || $is_admin) && $album_type == 'private'}
    <div class="float_bar">
        {if $my_profile}
            <a href="/users/addphoto.html" class="btn btn-primary">{$LANG.ADD_PHOTO}</a>
        {/if}
        <a href="javascript:void(0)" onclick="$('#usr_photos_upload_album').show();" class="btn btn-default">{$LANG.EDIT_ALBUM}</a>
        <a href="/users/{$user_id}/delalbum{$album.id}.html" onclick="if(!confirm('{$LANG.DELETE_ALBUM_CONFIRM}')){ return false; }" class="btn btn-default">{$LANG.DELETE_ALBUM}</a>
    </div>
{/if}

<h1 class="con_heading"><a href="{profile_url login=$usr.login}">{$usr.nickname}</a> &rarr; {$page_title}</h1>
{if ($my_profile || $is_admin) && $album_type == 'private'}
    <div id="usr_photos_upload_album" style="display:none;">
	<form action="/users/{$usr.id}/editalbum{$album.id}.html" method="post">
	<div class="table-responsive">
        <table class="table table-striped">
          <tr>
            <td><label for="album_title">{$LANG.ALBUM_TITLE}:</label></td>
            <td><input type="text" style="width:100%;" class="text-input" name="album_title" value="{$album.title|escape:'html'}" /></td>
            <td>{$LANG.SHOW}:</td>
			<td>
                    <select style="width:100%;" name="album_allow_who" id="album_allow_who">
                       <option value="all" {if $album.allow_who=='all'}selected="selected"{/if}>{$LANG.EVERYBODY}</option>
                       <option value="registered" {if $album.allow_who=='registered'}selected="selected"{/if}>{$LANG.REGISTERED}</option>
                       <option value="friends" {if $album.allow_who=='friends'}selected="selected"{/if}>{$LANG.MY_FRIENDS}</option>
                    </select>
            </td>
          </tr>
		  <tr><td colspan="4">&nbsp;</td></tr>
          <tr>
            <td><label for="description">{$LANG.ALBUM_DESCRIPTION}:</label></td>
            <td colspan="3"><textarea name="description" style="width:100%; height:100px;">{$album.description}</textarea></td>
          </tr>
        </table>
	</div>
        <div class="usr_photo_sel_bar bar" style="margin:20px 0 30px 0;text-align:right;">
           <input type="submit" name="save_album" value="{$LANG.SAVE}"/>
           <input name="Button" type="button" value="{$LANG.CANCEL}" onclick="$('#usr_photos_upload_album').hide();"/>
        </div>
      </form>
    </div>
{/if}
{if $album_type == 'public'}
    <div class="well">{$LANG.IS_PUBLIC_ALBUM} <a href="{if !$album.NSDiffer}/photos/{$album.id}{else}/clubs/photoalbum{$album.id}{/if}">{$LANG.ALL_PUBLIC_PHOTOS}</a></div>
{/if}
{if $album_type == 'private' && $album.description}
    <div class="well" id="usr_photos_upload_album">{$album.description|nl2br}</div>
{/if}
{if $photos}

        {if ($is_admin || $my_profile) && $album_type == 'private'}
        <form action="/users/{$user_id}/photos/editlist" method="post">
            <input type="hidden" name="album_id" value="{$album.id}" />
            <script type="text/javascript">
                function toggleButtons(){
                    var is_sel = $('.photo_id:checked').length;
                    if (is_sel > 0) {
                        $('#edit_btn, #delete_btn').prop('disabled', false);
                    } else {
                        $('#edit_btn, #delete_btn').prop('disabled', true);
                    }
                }
            </script>
        {/if}


            {$col="1"}

			{foreach key=id item=photo from=$photos name=usalb}
				{if $col==1} <div class="row margin-bottom-row"> {/if}
				<div class="col-sm-2 col-xs-6 media-gird">
                        <a href="{$photo.url}" title="{$photo.title|escape:'html'}"><img class="media-object" src="{$photo.file}" alt="{$photo.title|escape:'html'}"/></a>
						<h4 class="media-heading"><a href="{$photo.url}" title="{$photo.title|escape:'html'}">{$photo.title|truncate:32}</a></h4>
							<div class="media-hinttext"><span class="glyphicon glyphicon-eye-open"></span> {$photo.hits} &nbsp; <span class="glyphicon glyphicon-time"></span> {$photo.fpubdate}</div>
                        {if ($is_admin || $my_profile) && $album_type == 'private'}
                            <input type="checkbox" name="photos[]" class="photo_id" value="{$photo.id}" style="position:absolute;top:10px;right:30px;z-index:10;" onclick="toggleButtons()" />
                        {/if}
				</div>
				{if $col==6 || $smarty.foreach.usalb.last}</div>{$col="1"}{else}{$col=$col+1}{/if}
			{/foreach}


        {if ($is_admin || $my_profile) && $album_type == 'private'}
            <div class="usr_photo_sel_bar">
                {$LANG.SELECTED_ITEMS}:
                <input type="submit" name="edit" id="edit_btn" value="{$LANG.EDIT}" disabled="disabled" />
                <input type="submit" name="delete" id="delete_btn" value="{$LANG.DELETE}" disabled="disabled" />
            </div>
            </form>
        {/if}

		{$pagebar}

{else}
    <p class="text-danger">{$LANG.NOT_PHOTOS}</p>
{/if}