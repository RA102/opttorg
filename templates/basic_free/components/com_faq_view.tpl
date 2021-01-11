<div class="com-faq" style="margin-bottom:30px;">
{if $is_user || $cfg.guest_enabled}
<div class="float_bar">
    <a class="btn-vkorz" href="/faq/sendquest{if $id>0}{$id}{/if}.html">{$LANG.SET_QUESTION}</a>
</div>
{/if}

<h1 class="con_heading"><span>{$pagetitle}</span></h1>

{if $is_subcats}
	<div class="list-group">
			{foreach key=tid item=subcat from=$subcats}
<a class="list-group-item" href="/faq/{$subcat.id}"><h4><span class="glyphicon glyphicon-question-sign"></span> {$subcat.title}</h4>{if $subcat.description}<div class="hint">{$subcat.description}</div>{/if}</a>
			{/foreach}
	</div>
{/if}

{if $is_quests}
{$fakiki="1"}
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	{foreach key=tid item=quest from=$quests name=faki}
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading{$fakiki}">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{$fakiki}" aria-expanded="{if $smarty.foreach.faki.first}true{else}false{/if}" aria-controls="collapse{$fakiki}">
          <!-- {if $quest.nickname}{$quest.nickname}{else}{$LANG.QUESTION_GUEST}{/if} - -->{$quest.quest|truncate:80}
        </a>
      </h4>
    </div>
    <div id="collapse{$fakiki}" class="panel-collapse collapse{if $smarty.foreach.faki.first} in{/if}" role="tabpanel" aria-labelledby="heading{$fakiki}">
      <div class="panel-body">
        <div><strong>Вопрос:</strong> <br />{$quest.quest}</div>
		<div style="margin-top:15px;"><strong>Ответ:</strong> {$quest.answer}</div>
      </div>
    </div>
  </div>	
  {$fakiki=$fakiki+1}
	{/foreach}
</div>	
	{if $id > 0} {$pagebar} {/if}
{/if}
</div>