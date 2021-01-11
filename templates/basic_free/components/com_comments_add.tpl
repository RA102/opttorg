<div class="cm_addentry">

{if $user_can_add}
    {if $can_by_karma || !$cfg.min_karma}
	<form action="/comments/{$do}" id="msgform" method="POST">
        <input type="hidden" name="parent_id" value="{$parent_id}" />
        <input type="hidden" name="comment_id" value="{$comment.id}" />
        <input type="hidden" name="csrf_token" value="{csrf_token}" />
        <input type="hidden" name="target" value="{$target}"/>
        <input type="hidden" name="target_id" value="{$target_id}"/>
        {if !$is_user}
            <!--<div class="cm_guest_name" style="margin-bottom:10px;margin-left:-10px;"><input type="text" maxchars="20" size="20" name="guestname" class="text-input" value="" id="guestname" placeholder="{$LANG.YOUR_NAME}" /></div>
            <script type="text/javascript">$(document).ready(function(){ $('#guestname').focus(); });</script>-->
			<input type="hidden" name="guestname" value="Гость" id="guestname" />
        {/if}
        <div class="row">
			<div class="col-sm-4 col-xs-12">
				<div class="rateit">
					<div class="small">Качество товара</div>
					<select id="example-bootstrap1" name="rating1" autocomplete="off">
					  <option value=""></option>
					  <option value="1">1</option>
					  <option value="2">2</option>
					  <option value="3">3</option>
					  <option value="4">4</option>
					  <option value="5">5</option>
					</select>
				</div>
			</div>
			<div class="col-sm-4 col-xs-12">
				<div class="rateit">
					<div class="small">Качество обслуживания</div>
					<select id="example-bootstrap2" name="rating2" autocomplete="off">
					  <option value=""></option>
					  <option value="1">1</option>
					  <option value="2">2</option>
					  <option value="3">3</option>
					  <option value="4">4</option>
					  <option value="5">5</option>
					</select>					
				</div>
			</div>	
			<div class="col-sm-4 col-xs-12">
				<div class="rateit">
					<div class="small">Качество доставки</div>
					<select id="example-bootstrap3" name="rating3" autocomplete="off">
					  <option value=""></option>
					  <option value="1">1</option>
					  <option value="2">2</option>
					  <option value="3">3</option>
					  <option value="4">4</option>
					  <option value="5">5</option>
					</select>					
				</div>
			</div>			
		</div>
        <div class="cm_editor">
            <textarea id="content" name="content" class="ajax_autogrowarea" style="height:150px;min-height: 150px;">{$comment.content_bbcode|escape:'html'}</textarea>
        </div>		
        {if $do=='add'}
			<!--
            {if $need_captcha}
                <div class="cm_codebar" style="margin-right:10px !important;">{captcha}</div>
            {/if}
			-->
            <div class="submit_cmm" {if $need_captcha}style="margin-top:21px;"{else}style="margin-top:10px;"{/if}>
                <input id="submit_cmm" type="button" value="{$LANG.SEND}"/>
                <input id="cancel_cmm"type="button" onclick="$('.cm_addentry').remove();$('.cm_add_link').show();" value="{$LANG.CANCEL}"/>
            </div>
        {/if}
	</form>
    <div class="sess_messages" {if !$notice}style="display:none"{/if}>
      <div class="message_info" id="error_mess">{$notice}</div>
    </div>
    {else}
        {if $is_user}
            <p>{$LANG.YOU_NEED} <a href="/users/{$is_user}/karma.html">{$LANG.KARMS}</a> {$LANG.TO_ADD_COMM}.<br> {$LANG.NEED} &mdash; {$karma_need}, {$LANG.HAS} &mdash; {$karma_has}.</p>
        {else}
            <p>{$LANG.COMMENTS_CAN_ADD_ONLY} <a href="/registration" />{$LANG.REGISTERED}</a> {$LANG.USERS}.</p>
        {/if}
    {/if}
{else}
    <p class="text-danger" style="margin-top:10px;">Отзывы к товарам могут добавлять только зарегистрированные пользователи!</p>
{/if}
<script>
$(function() {
        $('#example-bootstrap1').barrating({
            theme: 'bootstrap-stars',
            showSelectedRating: false
        });
        $('#example-bootstrap2').barrating({
            theme: 'bootstrap-stars',
            showSelectedRating: false
        });	
        $('#example-bootstrap3').barrating({
            theme: 'bootstrap-stars',
            showSelectedRating: false
        });
        $('#example-bootstrap4').barrating({
            theme: 'bootstrap-stars',
            showSelectedRating: false
        });		
});
</script>
</div>