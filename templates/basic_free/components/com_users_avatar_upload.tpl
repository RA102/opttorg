<div class="body-page">
<h1 class="con_heading">{$LANG.LOAD_AVATAR}</h1>

<form enctype="multipart/form-data" action="/users/{$id}/avatar.html" method="POST">
	<p class="text-success">{$LANG.SELECT_UPLOAD_FILE}: </p>
		<input name="upload" type="hidden" value="1"/>
		<input name="userid" type="hidden" value="{$id}"/>
		<input name="picture" type="file" id="picture" size="30" />
	<p style="margin-top:10px">
		<input type="submit" value="{$LANG.UPLOAD}"> <input type="button" onclick="window.history.go(-1);" value="{$LANG.CANCEL}"/>
	</p>
</form>

</div>