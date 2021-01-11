		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">{$LANG.RECOVER_PASS}</h3></div>
			<div class="panel-body">
{add_js file='components/registration/js/check.js'}
<form action="" method="post">
    <input type="hidden" name="csrf_token" value="{csrf_token}" />
<div class="form-group">
    <label>{$LANG.LOGIN}</label>
	<input type="text" name="pass" value="{$user.login}" disabled="disabled" class="form-control" />
</div><br />
<div class="form-group">
    <label>{$LANG.PASS}</label>
	<input type="password" name="pass" id="pass1input" value="" class="form-control" onchange="$('#passcheck').html('');" />
</div>	<br />
<div class="form-group">
    <label>{$LANG.REPEAT_PASS}</label>
	<input type="password" name="pass2" id="pass2input" value="" class="form-control" onchange="checkPasswords()" /><div id="passcheck"></div>
</div><br />


    <input type="submit" id="submit" name="submit" value="{$LANG.CHANGE_PASS}" />

</form>
			</div>
		</div>
<script type="text/javascript">
    $(function(){
        $('input[name=pass]').focus();
    });
</script>