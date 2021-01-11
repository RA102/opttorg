{literal}
<style>
.reports_view label {font-weight:100 !important;}
.reports_view label input {margin-right:7px !important;}
</style>
{/literal}
<div id="rerport_playbackissue" class="reports_view">
    <h6>{$LANG.MOVIE_PLAYBACKISSUE} {$LANG.OR} <a href="#" class="ajax_link_orig" onclick="$('.reports_view').toggleClass('hid');return false;">{$LANG.REPORT_INAPPR}</a></h6>
    {if !$is_playbackissue}
    <div class="video_action_block" style="margin: 20px 0;">
      {$LANG.PLAYBACKISSUE_INFO}
    </div>
    <p class="subj_title">{$LANG.SUPPORT_FLASH_INFO}</p>
    <div id="flashversion">
        <span style="color:#F00">{$LANG.SUPPORT_FLASH_INFO_NO}</span>
    </div>
    <p class="subj_title">{$LANG.WHAT_IS_PROBLEM}</p>
    <p><label><input type="radio" name="vidspeedissue" value="{$LANG.NEVER_PLAEYRS}" onclick="$('#other').hide();">{$LANG.NEVER_PLAEYRS}</label></p>
    <p><label><input type="radio" name="vidspeedissue" value="{$LANG.NEVER_PLAYS}" onclick="$('#other').hide();">{$LANG.NEVER_PLAYS}</label></p>
    <p><label><input type="radio" name="vidspeedissue" value="{$LANG.STARTS_STOPS}" onclick="$('#other').hide();">{$LANG.STARTS_STOPS}</label></p>
    <p><label><input type="radio" name="vidspeedissue" value="{$LANG.JERKY}" onclick="$('#other').hide();">{$LANG.JERKY}</label></p>
    <p><label><input type="radio" name="vidspeedissue" value="other_sel" onclick="$('#other').fadeIn();$('#other').focus();">{$LANG.OTHER_PROBLEM}</label></p>
    <textarea name="other" id="other" style="width:99%; height:80px; display:none"></textarea>
    <p style="margin-top:13px"><input id="movie_playbackissue" type="button" value="{$LANG.SEND}"  onclick="sendPlaybackIssue('{$movie.id}');" /></p>
    {else}
        <div class="sess_messages" style="margin: 20px 0;">
          <div class="message_info">{$LANG.MOVIE_PLAYBACKISSUE_ALREADY}</div>
        </div>
    {/if}
</div>
<div class="reports_view hid" id="rerport_inappr">
    <h6><a href="#" class="ajax_link_orig" onclick="$('.reports_view').toggleClass('hid');return false;">{$LANG.MOVIE_PLAYBACKISSUE}</a> {$LANG.OR} {$LANG.REPORT_INAPPR}</h6>
    {if $user_id}
        {if !$is_inappropriate}
        <p style="margin:15px 0;">{$LANG.REPORT_INAPPR_DESCR}.</p>
	<div class="input-group">
        <select name="option_inappropriate" id="option_inappropriate" class="form-control">
            <option value="">- {$LANG.SELECT_REASON}</option>
            {foreach key=tid item=flag from=$inappropriate}
                <option value="{$flag|escape:'html'}">{$flag}</option>
            {/foreach}
        </select>
      <span class="input-group-btn">
         <input id="movie_flag_as" class="btn btn-default" type="button" value="{$LANG.REPORT}"  onclick="sendInappropriate('{$movie.id}');" />
      </span>
    </div>

        {else}
            <div class="sess_messages" style="margin: 20px 0;">
              <div class="message_info">{$LANG.REPORT_INAPPR_ALREADY}</div>
            </div>
        {/if}
    {else}
        <p style="padding:15px 0 0 0" class="text-danger"><a href="/login">{$LANG.TO_LOGIN}</a> {$LANG.OR} <a href="/registration">{$LANG.TO_REGISTRATION}</a> {$LANG.RIGHT_NOW}!</p>
    {/if}
</div>
{literal}
<script type="text/javascript">
$(document).ready(function () {
    getFlash();
    window.csrf_token = {/literal}'{csrf_token}'{literal};
});
function sendPlaybackIssue(movie_id){
	opt  = $("input[name=vidspeedissue]:checked").val();
	text = $('#other').val();
	if (!opt) { core.alert({/literal}'{$LANG.ERROR_SEND_PLAYBACKISSUE}', '{$LANG.ATTENTION}{literal}'); return false; }
	if(opt == 'other_sel' && (!text)) { core.alert({/literal}'{$LANG.ERROR_TEXT_PLAYBACKISSUE}', '{$LANG.ATTENTION}{literal}'); return false; }
	$('#movie_playbackissue').prop('disabled', true);
	$('#movie_playbackissue').val('{/literal}{$LANG.LOADING}{literal}');
	$.post('/components/video/ajax/report.php', {id: movie_id, text: text, opt: opt, do: 'send_playbackissue', csrf_token: window.csrf_token}, function(data){
		$('#rerport_playbackissue').html('<div class="sess_messages" style="margin: 20px 0;"><div class="message_success">'+data+'</div></div>');
	});
}
function sendInappropriate(movie_id){
	text = $("#option_inappropriate option:selected").val();
    if (!text) { core.alert({/literal}'{$LANG.SELECT_REASON}', '{$LANG.ATTENTION}{literal}'); return false; }
	$('#movie_flag_as').prop('disabled', true);
	$('#movie_flag_as').val('{/literal}{$LANG.LOADING}{literal}');
	$.post('/components/video/ajax/report.php', {id: movie_id, text: text, do: 'send_inappropriate', csrf_token: window.csrf_token}, function(data){
		$('#rerport_inappr').html('<div class="sess_messages" style="margin: 20px 0;"><div class="message_success">'+data+'</div></div>');
	});
}
{/literal}
</script>