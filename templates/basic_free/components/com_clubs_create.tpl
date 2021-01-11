<p>
	<strong>{$LANG.CLUBS}</strong> {$LANG.CLUBS_DESC}
</p>
{if $can_create}
	<script type="text/javascript" src="/includes/jquery/jquery.form.js"></script>
    <form action="/clubs/create.html" method="post" id="create_club">
	<div class="table-responsive">
        <input type="hidden" name="create" value="1" />
        <input type="hidden" name="csrf_token" value="{csrf_token}" />
        <table class="table table-striped">
          <tr>
            <td width="20%">
              <strong>{$LANG.CLUB_NAME}: </strong>
            </td>
            <td>
              <input name="title" type="text" id="title" class="text-input" style="width:300px" />
          </td>
          </tr>
          <tr>
            <td><strong>{$LANG.CLUB_TYPE}: </strong></td>
            <td>
                <select name="clubtype" id="clubtype" style="width:300px">
                  <option value="public">{$LANG.PUBLIC} (public)</option>
                  <option value="private">{$LANG.PRIVATE} (private)</option>
                </select>
            </td>
          </tr>
        </table>
	</div>
    </form>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#title').focus();
        });
    </script>
{/if}
<div class="sess_messages" {if !$last_message}style="display:none"{/if}>
  <div class="message_info" id="error_mess">{$last_message}</div>
</div>