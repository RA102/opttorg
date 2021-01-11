<h1 class="con_heading">
	<a href="/clubs/{$club.id}">{$club.title}</a> &rarr; {$LANG.CONFIG}
</h1>

{add_js file='includes/jquery/tabs/jquery.ui.min.js'}
{add_css file='includes/jquery/tabs/tabs.css'}

<form name="configform" id="club_config_form" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="{csrf_token}" />
<div id="configtabs" style="margin-top:20px" class="uitabs">
	<ul id="tabs">
		<li><a href="#about"><span>{$LANG.CLUB_DESC}</span></a></li>
		<li><a href="#moders"><span>{$LANG.MODERATORS}</span></a></li>
		<li><a href="#members"><span>{$LANG.MEMBERS}</span></a></li>
		{if $club.enabled_photos || $club.enabled_blogs}
            <li><a href="#limits"><span>{$LANG.LIMITS}</span></a></li>
		{/if}
        {if $is_admin}
            <li><a href="#vip"><span>VIP</span></a></li>
        {/if}
        {if $cfg.seo_user_access || $is_admin}
            <li><a href="#seo"><span>SEO</span></a></li>
        {/if}
	</ul>

    {if $cfg.seo_user_access || $is_admin}
	<div id="seo" class="table-responsive">
		<table class="table table-striped">
            <tr>
                <td valign="top">
                    <strong>{$LANG.SEO_PAGETITLE}</strong>
                    <div class="hint">{$LANG.SEO_PAGETITLE_HINT}</div>
                </td>
                <td>
                    <input name="pagetitle" style="width:400px" class="text-input" value="{$club.pagetitle|escape:'html'}" />
                </td>
            </tr>
            <tr>
                <td valign="top"><strong>{$LANG.SEO_METAKEYS}</strong></td>
                <td>
                    <input name="meta_keys" style="width:400px" class="text-input" value="{$club.meta_keys|escape:'html'}" />
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <strong>{$LANG.SEO_METADESCR}</strong>
                    <div class="hint">{$LANG.SEO_METADESCR_HINT}</div>
                </td>
                <td>
                    <textarea name="meta_desc" rows="3" style="width:400px" class="text-input">{$club.meta_desc|escape:'html'}</textarea>
                </td>
            </tr>
		</table>
	</div>
    {/if}

	<div id="about" class="table-responsive">
		<table class="table table-striped">
			<tr>
				<td valign="middle">
				  <strong>Название: </strong> &nbsp;
				</td>
				<td valign="middle">
					<input name="title" class="text-input" type="text" value="{$club.title|escape:'html'}" />
				</td>
			</tr>
			<tr>
				<td valign="middle">
						<img width="64" class="media-object" src="/images/clubs/small/{$club.f_imageurl}" border="0" alt="{$club.title|escape:'html'}"/>
				</td>
				<td valign="middle">
					<label>{$LANG.UPLOAD_LOGO}:</label>
					<input name="picture" type="file" id="picture" />
				</td>
			</tr>
			<tr><td colspan="2">{wysiwyg name='description' value=$club.description height=350 }</td></tr>
		</table>
	</div>

	<div id="moders" class="table-responsive">
		<table class="table table-striped" id="multiuserscfg">
			<tr>
				<td colspan="3">
					<div class="hint">{$LANG.MODERATE_TEXT}</div>
				</td>
			</tr>
			<tr>
				<td align="center" valign="top" width="30%">
					<p><strong>{$LANG.CLUB_MODERATORS}: </strong></p>
				</td>
				<td align="center" valign="middle" width="40%">
					&nbsp;
				</td>
				<td align="center" valign="top" width="30%">
					<p><strong>{$LANG.MY_FRIENDS_AND_CLUB_USERS}:</strong></p>
				</td>
			</tr>			
			<tr>
				<td align="center" valign="top" width="30%">
					<select name="moderslist[]" size="10" multiple id="moderslist" style="width:200px">
						{$moders_list}
					</select>
				</td>
				<td align="center" valign="middle" width="40%">
					<input name="moderator_add" type="button" id="moderator_add" value="&lt;&lt;" /> <input name="moderator_remove" type="button" id="moderator_remove" value="&gt;&gt;" />
				</td>
				<td align="center" valign="top" width="30%">
					<select name="userslist1" size="10" multiple id="userslist1" style="width:200px">
						{$fr_members_list}
					</select>
				</td>
			</tr>
		</table>
	</div>

	<div id="members" class="table-responsive">
		<table class="table table-striped">
			<tr>
			  <td>{$LANG.MAX_MEMBERS}:<br/><span class="hint">{$LANG.MAX_MEMBERS_TEXT}</span> </td>
			  <td><input class="text-input" name="maxsize" type="text" style="width:200px"  value="{$club.maxsize}"/></td>
		  </tr>
			<tr>
				<td>
					<label>{$LANG.SELECT_CLUB_TYPE}:</label>
				</td>
				<td width="200">
					<select class="text-input" name="clubtype" id="clubtype" style="width:200px" onchange="$('#minkarma').toggle();">
                        <option value="public" {if $club.clubtype=='public'}selected="selected"{/if}>{$LANG.PUBLIC} (public)</option>
                        <option value="private" {if $club.clubtype=='private'}selected="selected"{/if}>{$LANG.PRIVATE} (private)</option>
                     </select>
				</td>
			</tr>
		</table>
		<table class="table table-striped" id="minkarma" cellpadding="10" {if $club.clubtype!='public'}style="display:none;"{/if}>
			<tr>
			  <td>{$LANG.USE_LIMITS_KARMA}: <br/><span class="hint">{$LANG.USE_LIMITS_KARMA_TEXT}</span></td>
			  <td valign="top">
					<span style="margin-right:5px;"><input style="margin-right:5px;" name="join_karma_limit" type="radio" value="1" {if $club.join_karma_limit}checked{/if}/> {$LANG.YES}</span>
					<span style="margin-right:5px;"><input style="margin-right:5px;" name="join_karma_limit" type="radio" value="0" {if !$club.join_karma_limit}checked{/if}/> {$LANG.NO}</span>
			  </td>
		  </tr>
			<tr>
				<td>
					{$LANG.LIMITS_KARMA}: <br/><span class="hint">{$LANG.LIMITS_KARMA_TEXT}</span>
				</td>
				<td width="200" valign="top">
					&ge; <input class="text-input" name="join_min_karma" type="text" style="margin:0 7px;width:60px !important;display:inline !important;" value="{$club.join_min_karma}"/> {$LANG.POINTS}
				</td>
			</tr>
		</table>
		<table class="table table-striped" id="members">
			<tr>
				<td align="center" valign="top" width="30%">
					<p><strong>{$LANG.CLUB_MEMBERS}: </strong></p>
				</td>
				<td align="center" width="40%">
&nbsp;	</td>
				<td align="center" valign="top" width="30%">
					<p><strong>{$LANG.MY_FRIENDS_ARE}:</strong></p>
				</td>
			</tr>		
			<tr>
				<td align="center" valign="top" width="30%">
					<select class="text-input" name="memberslist[]" size="10" multiple id="memberslist" style="width:200px">
						{$members_list}
					</select>
				</td>
				<td align="center" width="40%" valign="middle">
					<div><input name="member_add" type="button" id="member_add" value="&lt;&lt;" /> <input name="member_remove" type="button" id="member_remove" value="&gt;&gt;" /></div>
				</td>
				<td align="center" valign="top" width="30%">
					<select class="text-input" name="userslist2" size="10" multiple id="userslist2" style="width:200px">
						{$friends_list}
					</select>
				</td>
			</tr>
		</table>
	</div>

	{if $club.enabled_photos || $club.enabled_blogs}
	<div id="limits" class="table-responsive">
		<table class="table table-striped">
			{if $club.enabled_blogs}
			<tr>
				<td>
					<label><strong>{$LANG.PREMODER_POSTS_IN_BLOGS}:</strong></label>
				</td>
				<td width="150">
					<span style="margin-right:5px;"><input style="margin-right:5px;" name="blog_premod" type="radio" value="1" {if $club.blog_premod}checked{/if}/> {$LANG.YES}</span>
					<span style="margin-right:5px;"><input style="margin-right:5px;" name="blog_premod" type="radio" value="0" {if !$club.blog_premod}checked{/if}/> {$LANG.NO}</span>
				</td>
			</tr>
			{/if}
			{if $club.enabled_photos}
			<tr>
				<td>
					<label><strong>{$LANG.PREMODER_PHOTOS}:</strong></label>
				</td>
				<td width="150">
					<span style="margin-right:5px;"><input style="margin-right:5px;" name="photo_premod" type="radio" value="1" {if $club.photo_premod}checked{/if}/> {$LANG.YES}</span>
					<span style="margin-right:5px;"><input style="margin-right:5px;" name="photo_premod" type="radio" value="0" {if !$club.photo_premod}checked{/if}/> {$LANG.NO}</span>
				</td>
			</tr>
			{/if}
			{if $club.enabled_blogs}
			<tr>
				<td>
					<label>{$LANG.KARMA_LIMITS_FOR_NEW_POSTS}:</label>
				</td>
				<td width="150">&ge; <input class="text-input" name="blog_min_karma" type="text"  style="margin:0 7px;width:60px !important;display:inline !important;" value="{$club.blog_min_karma}"/> {$LANG.POINTS}
			  </td></tr>
			{/if}
			{if $club.enabled_photos}
			<tr>
				<td>
					<label>{$LANG.KARMA_LIMITS_FOR_ADD_PHOTOS}:</label>
				</td>
				<td width="150">
					&ge;
					<input name="photo_min_karma" class="text-input" type="text"  style="margin:0 7px;width:60px !important;display:inline !important;" value="{$club.photo_min_karma}"/> {$LANG.POINTS}
				</td>
			</tr>
			{/if}
			{if $club.enabled_photos}
			<tr>
				<td>
					<label>{$LANG.KARMA_LIMITS_NEW_PHOTOALBUM}:</label>
				</td>
				<td width="150">
					&ge; <input name="album_min_karma" class="text-input" type="text"  style="margin:0 7px;width:60px !important;display:inline !important;"  value="{$club.album_min_karma}"/> {$LANG.POINTS}
			  </td>
			</tr>
			{/if}
		</table>
	</div>
	{/if}

	{if $is_admin}
	<div id="vip" class="table-responsive">
        {if !$is_billing}
            <p class="text-danger">{$LANG.VIP_BILLING_INFO}</p>
            <p class="text-danger">{$LANG.VIP_BILLING_INFO1}</p>
        {else}
    		<table class="table table-striped">
                <tr>
                    <td>
                        <label><strong>{$LANG.VIP_CLUB}:</strong></label>
                    </td>
                    <td width="150">
                        <input name="is_vip" type="radio" value="1" {if $club.is_vip}checked{/if}/> {$LANG.YES}
                        <input name="is_vip" type="radio" value="0" {if !$club.is_vip}checked{/if}/> {$LANG.NO}
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>{$LANG.VIP_CLUB_JOIN_COST}:</label>
                    </td>
                    <td width="150">
                        <input name="join_cost" class="text-input" type="text" style="width:60px" value="{$club.join_cost}"/> {$LANG.BILLING_POINT10}
                    </td>
                </tr>
            </table>
        {/if}
	</div>
	{/if}

</div>

<div>
	<input type="submit" class="button" name="save" value="{$LANG.SAVE}"/>
	<input type="button" class="button" name="back" value="{$LANG.CANCEL}" onclick="window.history.go(-1)"/>
</div>

</form>

<script type="text/javascript">
    $(".uitabs").tabs();
    $("#club_config_form").submit(function() {
    $('#moderslist').each(function(){
            $('#moderslist option').prop("selected", true);
        });
        $('#memberslist').each(function(){
            $('#memberslist option').prop("selected", true);
        });
    });
    $(function(){
      $('#moderator_remove').click(function() {

            var user = new Array;

            $('#moderslist option:selected').each(function () {
                user.push(this);
            });

            while (user.length){
                opt     = user.pop();
                opt2    = $(opt).clone();
                $(opt).remove().appendTo('#userslist1');
                $(opt2).remove();
            }

      });
      $('#moderator_add').click(function() {

            var user_id = new Array;

            $('#userslist1 option:selected').each(function () {
                user_id.push(this.value);
            });

            $('#userslist1 option:selected').remove().appendTo('#moderslist');

            while (user_id.length){
                id = user_id.pop();
                $('#userslist2 option[value='+id+']').remove();
            }

      });

      $('#member_remove').click(function() {
            var user = new Array;

            $('#memberslist option:selected').each(function () {
                user.push(this);
            });

            var user_id = new Array;

            $('#memberslist option:selected').each(function () {
                user_id.push(this.value);
            });

            while (user.length){
                opt     = user.pop();
                opt2    = $(opt).clone();
                $(opt).remove().appendTo('#userslist1');
                $(opt2).remove().appendTo('#userslist2');
            }

            while (user_id.length){
                id = user_id.pop();
                $('#moderslist option[value='+id+']').remove();
            }

      });

      $('#member_add').click(function() {

            var user_id = new Array;

            $('#userslist2 option:selected').each(function () {
                user_id.push(this.value);
            });

            $('#userslist2 option:selected').remove().appendTo('#memberslist');

      });

      $("#addform").submit(function() {
            $('#moderslist').each(function(){
                $('#moderslist option').prop("selected", true);
            });
            $('#memberslist').each(function(){
                $('#memberslist option').prop("selected", true);
            });
      });

    });
</script>