		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">{$LANG.REMINDER_PASS}</h3></div>
			<div class="panel-body">
<form name="prform" action="" method="POST">
<input type="hidden" name="csrf_token" value="{csrf_token}" />
    <div class="input-group">
      <input name="email" type="text" size="25" class="form-control" placeholder="{$LANG.WRITE_REGISTRATION_EMAIL}" />
      <span class="input-group-btn">
        <button class="btn btn-default" name="goremind" type="submit">{$LANG.SEND}</button>
      </span>	  
    </div>
</form>
			</div>
		</div>