<h1 class="con_heading">{$pagetitle}</h1>

<form style="margin-top:15px" action="" method="post" name="msgform" enctype="multipart/form-data">
<div class="table-responsive">
  <table class="table table-striped">
		<tr>
			<td width="20%"><strong>{$LANG.TITLE_POST}: </strong></td>
		  	<td><input name="title" class="text-input" type="text" id="title" style="width:100%;" value="{$mod.title|escape:'html'}"/></td>
		</tr>

		{if $blog.showcats && $cat_list}
			<tr>
				<td><strong>{$LANG.BLOG_CAT}:</strong></td>
				<td>
					<select name="cat_id" id="cat_id" style="width:100%;">
						<option value="0" {if !isset($mod.cat_id) || $mod.cat_id==0}  selected {/if}>{$LANG.WITHOUT_CAT}</option>
						{$cat_list}
					</select>
				</td>
			</tr>
		{/if}

		{if $myblog || $is_admin}
			<tr>
				<td><strong>{$LANG.SHOW_POST}:</strong></td>
				<td>
					<select name="allow_who" id="allow_who" style="width:100%;">
						<option value="all" {if !isset($mod.allow_who) || $mod.allow_who=='all'} selected {/if}>{$LANG.TO_ALL}</option>
						<option value="friends" {if $mod.allow_who=='friends'} selected {/if}>{$LANG.TO_MY_FRIENDS}</option>
						<option value="nobody" {if $mod.allow_who=='nobody'} selected {/if}>{$LANG.TO_ONLY_ME}</option>
					</select>
				</td>
			</tr>
		{else}
			<input type="hidden" name="allow_who" value="{$blog.allow_who}" />
		{/if}

		<tr>
			<td><strong>{$LANG.YOUR_MOOD}:</strong></td>
			<td><input name="feel" class="text-input" type="text" id="feel" style="width:100%;" value="{$mod.feel|escape:'html'}"/></td>
		</tr>
		<tr>
			<td><strong>{$LANG.PLAY_MUSIC}:</strong></td>
			<td><input name="music" class="text-input" type="text" id="music" style="width:100%;" value="{$mod.music|escape:'html'}"/></td>
		</tr>
        {if $is_admin || $user_can_iscomments}
		<tr>
            <td valign="top">
				<strong>{$LANG.COMMENTS}:</strong>
				<div class="hint">{$LANG.IS_COMMENTS}</div>
			</td>
			<td>
                <select name="comments" id="comments" style="width:100%;">
                    <option value="0" {if !$mod.comments}selected="selected"{/if}>{$LANG.NO}</option>
                    <option value="1" {if $mod.comments}selected="selected"{/if} >{$LANG.YES}</option>
                </select>
			</td>
		</tr>
        {/if}
		<tr>
			<td valign="top">
				<strong>{$LANG.TAGS}:</strong><div class="hint">{$LANG.KEYWORDS}</div>
			</td>
			<td>
				<input name="tags" class="text-input" type="text" id="tags" style="width:100%;" value="{$mod.tags|escape:'html'}"/>
		
			<script type="text/javascript">
					{$autocomplete_js}
				</script>
			</td>
		</tr>
        {if $cfg.seo_user_access || $is_admin}
            <tr>
                <td valign="top"><strong>{$LANG.SEO_PAGETITLE}</strong><div class="hint">{$LANG.SEO_PAGETITLE_HINT}</div></td>
                <td>
                    <input name="pagetitle" style="width:100%;" class="text-input" value="{$mod.pagetitle|escape:'html'}" />
                </td>
            </tr>
            <tr>
                <td valign="top"><strong>{$LANG.SEO_METAKEYS}</strong></td>
                <td>
                    <input name="meta_keys" style="width:100%;" class="text-input" value="{$mod.meta_keys|escape:'html'}" />
                </td>
            </tr>
            <tr>
                <td valign="top"><strong>{$LANG.SEO_METADESCR}</strong><div class="hint">{$LANG.SEO_METADESCR_HINT}</div></td>
                <td>
                    <textarea name="meta_desc" rows="3" style="width:100%;" class="text-input">{$mod.meta_desc|escape:'html'}</textarea>
                </td>
            </tr>
         {/if}
		<tr>
			<td colspan="2">
				<div class="usr_msg_bbcodebox" style="padding-top:10px;">{$bb_toolbar}</div>
				{$smilies}
				{$autogrow}
                <div class="cm_editor" style="padding-top:10px;"><textarea rows="15" class="ajax_autogrowarea" style="width:100%;" name="content" id="message">{$mod.content|escape:'html'}</textarea></div>
                <div style="margin-top:12px;margin-bottom:15px;" class="hinttext">
                    <strong>{$LANG.IMPORTANT}:</strong> {$LANG.CUT_TEXT}, 
                    <a href="javascript:addTagCut('message');" class="ajaxlink">{$LANG.ADD_CUT_TAG}</a> {$LANG.BETWEEN}.
                </div>
			</td>
		</tr>
	</table>
</div>
	<p>
		<input name="goadd" type="submit" id="goadd" value="{$LANG.SAVE_POST}" />
		<input name="cancel" type="button" onclick="window.history.go(-1)" value="{$LANG.CANCEL}" />
	</p>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $('#title').focus();
    });
</script>