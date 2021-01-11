<form action="/login" method="post" name="authform" style="margin:0px" target="_self" id="authform">
    <input type="hidden" name="csrf_token" value="{csrf_token}" />
<div class="input-group">
  <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
  <input name="login" type="text" id="login" class="form-control" placeholder="{$LANG.AUTH_LOGIN}" />
</div>
<br />
<div class="input-group">
  <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
  <input name="pass" type="password" id="pass" class="form-control" placeholder="{$LANG.AUTH_PASS}" />
</div>	
{if $cfg.autolog}
    <div style="margin:15px 0 0 0;"><input name="remember" type="checkbox" id="remember" value="1" checked="checked" /> <label for="remember"> {$LANG.AUTH_REMEMBER}</label></div>
{/if}
<br />
<input id="login_btn" type="submit" name="Submit" class="btn btn-primary" value="{$LANG.AUTH_ENTER}" />
{if $cfg.passrem}<a class="btn btn-default" href="/passremind.html">{$LANG.AUTH_FORGOT}</a>{/if}
</form>