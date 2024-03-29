<h1 class="con_heading">{$LANG.CREATE_BLOG}</h1>

<p><strong>{$LANG.BLOG}</strong> {$LANG.BLOG_DESCRIPTION}</p>
<form style="margin-top:15px" action="" method="post" name="addform">
<div class="table-responsive">
  <table class="table table-striped">
	<tr>
	  <td width="20%"><strong>{$LANG.BLOG_TITLE}: </strong></td>
	  <td><input name="title" type="text" id="title" class="text-input"  style="width:100%;" size="40" /></td>
	</tr>
	<tr>
	  <td><strong>{$LANG.BLOG_TYPE}: </strong></td>
	  <td>
	  	  <select name="ownertype" id="ownertype" style="width:100%;">
			  <option value="single" selected>{$LANG.PERSONAL} {if $is_restrictions && $cfg.min_karma_private>0}({$LANG.BLOG_KARMA_NEED} {$cfg.min_karma_private}){/if}</option>
			  <option value="multi" >{$LANG.COLLECTIVE} {if $is_restrictions && $cfg.min_karma_public>0}({$LANG.BLOG_KARMA_NEED} {$cfg.min_karma_public}){/if}</option>
		  </select>
	  </td>
	</tr>
	<tr>
	  <td><strong>{$LANG.SHOW_BLOG}:</strong></td>
	  <td>
	  	<select name="allow_who" id="allow_who" style="width:100%;">
			<option value="all" selected="selected">{$LANG.TO_ALL}</option>
			<option value="friends">{$LANG.TO_MY_FRIENDS}</option>
			<option value="nobody">{$LANG.TO_ONLY_ME}</option>
		</select>
	   </td>
	</tr>
  </table>
</div>
  <p style="margin-top:20px">
  	<input name="goadd" type="submit" id="goadd" value="{$LANG.CREATE_BLOG}" />
  	<input name="cancel" type="button" onclick="window.history.go(-1)" value="{$LANG.CANCEL}" />
  </p>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $('#title').focus();
    });
</script>