{* ================================================================================ *}
{* ========================== Редактирование события объекта ====================== *}
{* ================================================================================ *}
{add_js file='includes/jqueryui/jquery-ui.min.js'}
{add_js file='includes/jqueryui/jquery.ui.datepicker-ru.min.js'}
{add_css file='includes/jqueryui/css/smoothness/jquery-ui.min.css'}
<h1 class="con_heading">
    {if $do=='add_event'}{$LANG.MAPS_ADD_EVENT}{else}{$LANG.MAPS_EDIT_EVENT}{/if} &rarr; <a href="/maps/{$item.seolink}.html">{$item.title}</a>
</h1>

<div class="row">
	<div class="col-md-3 media-gird">
		<div class="well" align="center">
		<img src="/images/photos/small/{$item.filename}" class="media-object" />
            {if !$limit_reach || $is_admin}
                <p>{$LANG.MAPS_EVENTS_LIMIT}</p>
                {if !$is_admin}
                    <p>{$LANG.MAPS_EVENTS_LIMIT_USED}</p>
                {/if}
            {/if}	
		</div>
	</div>
	<div class="col-md-9">
            <div>
                {if $limit_reach}
                    <p class="text-danger">{$LANG.MAPS_EVENTS_LIMIT_REACH}</p>
                    <p>{$LANG.MAPS_EVENTS_LIMIT}</p>
                    <div style="margin-top:20px">
                        {if !$limit_reach}
                            <input type="button" class="btn btn-default" name="save" value="{$LANG.SAVE}" onclick="checkForm()" />
                        {/if}
                        <input type="button" name="cancel" class="btn btn-default" value="{$LANG.CANCEL}" onclick="window.history.go(-1)" />
                    </div>
                {else}
                    <form id="event_form" action="/maps/events/submit" method="POST">
                        <input type="hidden" name="id" value="{$id}" />
                        <input type="hidden" name="action" value="{$do}" />
                        <input type="hidden" name="item_id" value="{$item_id}" />
                        <div style="margin-bottom:5px"><strong>{$LANG.MAPS_EVENT_TITLE}</strong>:</div>
                        <input name="title" class="text-input" type="text" id="event_title" value="{$event.title|escape:'html'}" />
						<table width="100%" border="0" style="margin-top:10px;">
							<tr>
								<td width="50%">
						<div style="margin-bottom:5px"><strong>{$LANG.MAPS_EVENT_DATE_START}</strong>:</div>
                        <input name="date_start" class="text-input" type="text" id="event_date_start" style="width:140px" value="{if $do=='add_event'}{'d.m.Y'|date}{else}{$event.date_start|escape:'html'}{/if}" />
								</td>
								<td>
                        <div style="margin-bottom:5px"><strong>{$LANG.MAPS_EVENT_DATE_END}</strong>:</div>
                        <input name="date_end" class="text-input" type="text" id="event_date_end" style="width:140px" value="{$event.date_end|escape:'html'}" />
								</td>
							</tr>
						</table>

                        <div style="margin-bottom:5px;margin-top: 10px"><strong>{$LANG.MAPS_EVENT_CONTENT}</strong>:</div>
                        <div>
                            {if $cfg.news_html}
                                {wysiwyg name='content' value=$event.content height=300 width='99%' toolbar='Basic'}
                            {else}
                                <textarea name="content" id="news_content" style="width:99%;height:300px">{$event.content}</textarea>
                            {/if}
                        </div>

                        <div style="margin-top:20px">
                            <input class="btn btn-default" type="button" name="save" value="{$LANG.SAVE}" onclick="checkForm()" />
                            <input class="btn btn-default" type="button" name="cancel" value="{$LANG.CANCEL}" onclick="window.history.go(-1)" />
                        </div>

                    </form>
                {/if}
            </div>	
	</div>
	
</div>


{if !$limit_reach}
    <script type="text/javascript">
        {literal}
        $(document).ready(function(){
            var datePickerOptions = {showStatus: true, showOn: "focus"};
            $('#event_date_start').datepicker(datePickerOptions);
            $('#event_date_end').datepicker(datePickerOptions);
        });

        function checkForm(){
            if ($('input#event_title').val()=='') {
                $('input#event_title').focus();
                alert('Пожалуйста, укажите заголовок события');
                return false;
            } else {
                if ($('input#event_date_start').val()==''){
                    $('input#event_title').focus();
                    alert('Пожалуйста, укажите дату проведения события');
                    return false;
                } else {
                    $('form#event_form').submit();
                }
            }
        }
        {/literal}
    </script>
{/if}