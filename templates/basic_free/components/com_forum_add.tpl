<h1 class="con_heading">{$pagetitle}</h1>

<form action="" method="POST" name="msgform" id="msgform" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="{csrf_token}" />
<input type="hidden" name="gosend" value="1" />
{if $do == 'newthread'}
    <input type="hidden" name="forum_id" value="{$forum.id}" />
    <div class="row forum_postinfo" style="margin-bottom:20px;">
		<div class="col-sm-3">
			<strong>{$LANG.THREAD_TITLE}:</strong>
		</div>
		<div class="col-sm-9">
	<input type="text" name="title" class="text-input" id="title" style="width: 100%" value="{$thread.title|escape:html}" />
		</div>
	</div>
	<div class="row forum_postinfo" style="margin-bottom:20px;">
		<div class="col-sm-3">
			<strong>{$LANG.THREAD_DESCRIPTION}:</strong>
		</div>
		<div class="col-sm-9">
	<input type="text" name="description" class="text-input" style="width: 100%" value="{$thread.description|escape:html}" />
		</div>
	</div>
{/if}

<div class="usr_msg_bbcodebox forum_postinfo">
    {$bb_toolbar}
</div>
{$smilies}
<div class="cm_editor forum_postinfo">
    <textarea id="message" style="box-shadow:0 !important;border:#dedede 1px solid;margin-top:10px;" name="message" rows="15">{$post_content}</textarea>
</div>

{if $cfg.fa_on && $is_allow_attach}
    {add_js file='includes/jquery/multifile/jquery.multifile.js'}
    <script type="text/javascript">
        $(function(){ $('#upfile').MultiFile({ max: ' {$cfg.fa_max}', accept:'{$cfg.fa_ext} ', max:3, STRING: { remove:LANG_CANCEL, selected:LANG_FILE_SELECTED, denied:LANG_FILE_DENIED, duplicate:LANG_FILE_DUPLICATE } }); });
    </script>
    <input type="hidden" name="fa_count" value="1"/>
    <div class="forum_fa">
        <div class="forum_fa_title"><a href="javascript:" onclick="$('#fa_entries').toggle();">{$LANG.ATTACH_FILES}</a></div>
            <div class="forum_fa_entries" id="fa_entries">
                <div class="forum_fa_desc">
                    <div><strong>{$LANG.MAX_SIZE_FILE}:</strong> {$cfg.fa_size} {$LANG.KBITE}.</div>
                    <div><strong>{$LANG.MUST_FILE_TYPE}:</strong> {$cfg.fa_ext}</div>
                    <div><strong>{$LANG.SELECT_FILES} {$cfg.fa_max}:</strong></div>
                </div>
                <input type="file" name="fa[]" id="upfile" size="30" />
            </div>
    </div>
{/if}

{if $do == 'newthread' || ($do=='editpost' && $is_first_post)}
<div class="forum_fa">
  <div class="forum_fa_title">{if $thread_poll}{$LANG.EDIT_POLL}{else}<a href="javascript:" onclick="$('#pa_entries').toggle();">{$LANG.ATTACH_POLL}</a>{/if}</div>
  <div class="forum_fa_entries" id="pa_entries" {if $thread_poll}style="display: block"{/if}>
        <div class="forum_fa_title" style="margin-bottom:10px">{$LANG.POLL_PARAMS}</div>
        <div style="margin-bottom:10px;overflow-x:scroll;"><table cellspacing="0" class="forum_fa_entry" cellpadding="5">
            <tr>
                <td width="20%" style="padding:7px 0;">{$LANG.QUESTION}: </td>
                <td style="padding:7px 0;"><input name="poll[title]" type="text" size="30" class="text-input" value="{$thread_poll.title|escape:html}" /></td>
            </tr>
            <tr>
                <td style="padding:7px 0;">{$LANG.COMMENT_FOR_POLL}: </td>
                <td style="padding:7px 0;"><input name="poll[desc]" type="text" size="30" class="text-input" value="{$thread_poll.description|escape:html}" /></td>
            </tr>
            <tr>
                <td style="padding:7px 0;">{$LANG.LENGTH_POLL}, {$LANG.DAYS}: </td>
                <td style="padding:7px 0;"><input name="poll[days]" type="text" size="4" class="text-input" value="{$thread_poll.days_left}" /> </td>
            </tr>
            <tr>
                <td style="padding:7px 0;">{$LANG.SHOW_RESULT}: </td>
                <td style="padding:7px 0;"><select name="poll[result]" class="text-input">
                        <option value="0" {if !$thread_poll.options.result}selected="selected"{/if}>{$LANG.FOR_ALL_EVER}</option>
                        <option value="1" {if $thread_poll.options.result==1}selected="selected"{/if}>{$LANG.ONLY_VOTERS}</option>
                        <option value="2" {if $thread_poll.options.result==2}selected="selected"{/if}>{$LANG.ONLY_END_POLL}</option>
                     </select>
                </td>
            </tr>
            <tr>
                <td style="padding:7px 0;">{$LANG.CHANGE_VOTE_USER}: </td>
                <td style="padding:7px 0;"><select name="poll[change]" class="text-input">
                        <option value="0" {if !$thread_poll.options.change}selected="selected"{/if}>{$LANG.PROHIBITING}</option>
                        <option value="1" {if $thread_poll.options.change}selected="selected"{/if}>{$LANG.ALLOWING}</option>
                    </select>
                </td>
            </tr>
        </table></div>
        <div class="forum_fa_title" style="margin-bottom:10px;">{$LANG.OPTIONS_ANSWER}</div>
		<div style="margin-bottom:10px;overflow-x:scroll;">
        {section name=foo start=1 loop=13 step=1}
            {if $smarty.section.foo.index < 5 || $thread_poll.answers_key[$smarty.section.foo.index]}{$style="display:block"}{else}{$style="display:none"}{/if}
            <div id="pa_entry{$smarty.section.foo.index}" style="{$style}">
                <table cellspacing="0" class="forum_fa_entry" cellpadding="5">
                    <tr>
                        <td width="20%" style="padding:7px 0;">{$LANG.OPTION} №{$smarty.section.foo.index}: </td>
                        <td style="padding:7px 0;"><input name="poll[answers][]" type="text" size="30" id="pa_entry_input{$smarty.section.foo.index}" class="text-input" value="{$thread_poll.answers_key[$smarty.section.foo.index]|escape:html}" /></td>
                        {if $smarty.section.foo.index >= 4}{$ostyle="display:block"}{else}{$ostyle="display:none"}{/if}
                        <td width="10">&nbsp;</td>
						<td style="padding:7px 0;">
                            <div id="pa_entry_btn{$smarty.section.foo.index}" style="{$ostyle}">
                            {if $smarty.section.foo.index < 12}
                            <a href="javascript:showPaEntry({$smarty.section.foo.index+1})" title="{$LANG.ADD_OPTION}"><img src="/images/icons/plus.gif" border="0"/></a>
                            {/if}
                            {if $smarty.section.foo.index > 2}
                            <a href="javascript:hidePaEntry({$smarty.section.foo.index})" title="{$LANG.HIDE_OPTION}"><img src="/images/icons/minus.gif" border="0"/></a>
                            {/if}
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        {/section}
		</div>
</div></div>

<script type="text/javascript">
    function showPaEntry(id){
        $('#pa_entry'+id).fadeIn();
        $('#pa_entry_btn'+(id - 1)).hide();
        $('#pa_entry_input'+id).focus();
    }
    function hidePaEntry(id){
        $('#pa_entry'+id).hide();
        $('#pa_entry_btn'+(id - 1)).fadeIn();
        $('#pa_entry_input'+(id - 1)).focus();
        $('#pa_entry_input'+id).val('');
    }
</script>

{/if}
<div style="margin-top:15px;">
<div class="pull-right">
    {if $do=='newpost' && ($is_admin || $is_moder || $thread.is_mythread)}
        <label style="padding-left:10px;"><input type="checkbox" class="checkit" name="fixed" value="1" /> {$LANG.TOPIC_FIXED_LABEL}</label> 
    {/if}
    {if ($do=='newpost' && !$is_subscribed) || $do=='newthread'}
        <label style="padding-left:10px;"><input name="subscribe" type="checkbox" class="checkit" value="1" /> {$LANG.SUBSCRIBE_THREAD}</label>
    {/if}
</div>
    <input type="button" class="kopa-button navy-button nano-button" value="{$LANG.SEND}" onclick="$(this).prop('disabled', true);$('#msgform').submit();" />
    <input type="button" class="kopa-button border-button nano-button" value="{$LANG.CANCEL}" onclick="window.history.go(-1)"/> 

</div>
</form>

{if $do == 'newthread'}
    <script type="text/javascript">
        $(document).ready(function(){
            $('#title').focus();
        });
    </script>
{else}
    <script type="text/javascript">
        $(document).ready(function(){
            $('#message').focus();
        });
    </script>
{/if}