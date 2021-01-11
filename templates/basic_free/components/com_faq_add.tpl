<h1 class="con_heading"><span>{$LANG.SET_QUESTION}</span></h1>

<div style="margin:10px 0;">{$LANG.SET_QUESTION_TEXT}</div>
<div style="margin-bottom:10px;">{$LANG.CONTACTS_TEXT}</div>

{if $error}<p class="text-danger">{$error}</p>{/if}
<div class="clearfix" style="height:30px;"></div>
<form action="" method="POST" name="questform">

				<select name="category_id" style="width:100%;" class="form-control">
					{$catslist}
				</select>
<div class="clearfix" style="height:30px;"></div>

	<textarea name="message" id="faq_message" style="width:100%;height:150px;" class="form-control">{$message}</textarea>

    {if !$user_id}
        <div style="margin:10px 0 0 0;width:100%;display:inline-block;">{captcha} <br /></div>
    {/if}
<div class="clearfix" style="height:30px;"></div>
	<div>
		<input type="button" class="btn-vkorz" onclick="sendQuestion()" name="gosend" value="{$LANG.SEND}"/>
		<input type="button" class="btn-vspis" name="cancel" onclick="window.history.go(-1)" value="{$LANG.CANCEL}"/>
	</div>
<div class="clearfix" style="height:30px;"></div>	
</form>
