<form action="" method="post">
    <input type="hidden" name="csrf_token" value="{csrf_token}" />
    {if !$user_id}
    <div style="margin-bottom:20px">
        <input type="text" class="text-input" name="username" value="" placeholder="{$LANG.YOUR_NAME}" />
    </div>
    {/if}
    <div class="input-group">
      <input type="text" class="text-input"  name="friend_email" class="form-control" value="" placeholder="{$LANG.FRIEND_EMAIL}" />
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit" name="send_invite_email">{$LANG.DO_INVITE}</button>
      </span>	  
    </div>
</form>
{if $is_redirect}
<script type="text/javascript">
    $(document).ready(function(){
        location.href='{$smarty.server.REQUEST_URI}';
    });
</script>
{/if}