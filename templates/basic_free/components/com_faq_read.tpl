<h1 class="con_heading">{$LANG.QUESTION_VIEW} {if $is_admin}<a href="/faq/delquest{$quest.id}.html"><span class="glyphicon glyphicon-trash"></span></a>{/if}</h1>

<table cellspacing="5" cellpadding="0" border="0" width="100%">
	<tr>
		<td width="40" valign="top"><span class="glyphicon glyphicon-question-sign" style="font-size:2em;"></span></td>
		<td width="" valign="top">
			<div class="faq_questtext">{$quest.quest}</div>
			<div class="media-hinttext">&mdash; {$quest.pubdate}{if $cfg.user_link}, {if $quest.nickname}<a rel="author" class="a-inverse" href="{profile_url login=$quest.login}">{$quest.nickname}</a>{else}{$LANG.QUESTION_GUEST}{/if}{/if}</div>
		</td>
	</tr>
</table>

{if $quest.answer}
<table cellspacing="5" cellpadding="0" border="0" width="100%" style="margin:15px 0px;">
	<tr>
		<td width="40" valign="top">
			<span class="glyphicon glyphicon-hand-up" style="font-size:2em;"></span>
		</td>
		<td width="" valign="top">
			<div class="faq_answertext">{$quest.answer}</div>
			<div class="media-hinttext">&mdash; {$quest.answerdate}</div>
		</td>
	</tr>
</table>
{/if}

{if $cfg.is_comment}
{comments target='faq' target_id=$quest.id labels=$labels}
{/if}