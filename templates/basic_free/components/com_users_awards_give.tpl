<div class="con_heading">{$LANG.AWARD_USER}</div>
<form action="" method="POST" name="addform" id="addform">
<div class="table-responsive">
  <table class="table table-striped">
    <tr>
      <td width="20%" valign="middle">{$LANG.AWARD_IMG}:</td>
      <td valign="middle"><div style="overflow:hidden;_height:1%">

	{foreach key=id item=img from=$awardslist}
        <div style="float:left;margin:4px">
        <table border="0" cellspacing="0" cellpadding="4"><tr>
                <td align="center" valign="middle"><label><img src="/images/users/awards/{$img}" /><br/><input type="radio" name="imageurl" value="{$img}"/></label></td>
        </tr></table></div>
	{/foreach}

      </div></td>
    </tr>
    <tr>
      <td width="150">{$LANG.AWARD_NAME}:</td>
      <td><input type="text" name="title" class="text-input" style="width:300px" /></td>
    </tr>
    <tr>
      <td width="150">{$LANG.AWARD_DESC}:</td>
      <td><textarea name="description" class="text-input" style="width:300px" rows="4"></textarea></td>
    </tr>
  </table>
</div>
  <div style="margin-top:6px;">
    <input type="submit" name="gosend" value="{$LANG.TO_AWARD}" />
    <input type="button" name="gosend" value="{$LANG.CANCEL}" onclick="window.history.go(-1)"/>
  </div>
</form>
