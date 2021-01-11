<h1 class="con_heading">{$LANG.MY_INVITES}</h1>

<p style="margin-bottom: 4px">{$LANG.YOU_CAN_SEND} {$invites_count|spellcount:$LANG.INVITE1:$LANG.INVITE2:$LANG.INVITE10}</p>

<p style="margin-bottom: 10px">{$LANG.INVITE_NOTICE}</p>

<p style="margin-bottom: 5px"><strong>{$LANG.INVITE_EMAIL}:</strong></p>

<form method="post" action="">
    <input type="hidden" name="csrf_token" value="{csrf_token}" />
    <div class="input-group">
      <input type="text" name="invite_email" value="" class="form-control" />
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit" name="send_invite">{$LANG.SEND_INVITE}</button>
      </span>	  
    </div>	
</form>