{* ================================================================================ *}
{* ========================== Редактирование новости объекта ====================== *}
{* ================================================================================ *}

<h1 class="con_heading">
    {if $do=='add_news'}{$LANG.MAPS_ADD_NEWS}{else}{$LANG.MAPS_EDIT_NEWS}{/if} &rarr; <a href="/maps/{$item.seolink}.html">{$item.title}</a>
</h1>
<div class="row">
	<div class="col-md-3 media-gird">
		<div class="well" align="center">
			<img src="/images/photos/small/{$item.filename}" class="media-object" />
            {if !$limit_reach || $is_admin}
                <p>{$LANG.MAPS_NEWS_LIMIT}</p>
                {if !$is_admin}
                    <p>{$LANG.MAPS_NEWS_LIMIT_USED}</p>
                {/if}
            {/if}		
		</div>
	</div>
	<div class="col-md-9">
            <div>
                {if $limit_reach}
                    <p class="text-danger">{$LANG.MAPS_NEWS_LIMIT_REACH}</p>
                    <p>{$LANG.MAPS_NEWS_LIMIT}</p>
                    <p style="margin-top:20px">
                        {if !$limit_reach}
                            <input type="button" class="btn btn-default" name="save" value="{$LANG.SAVE}" onclick="checkForm()" />
                        {/if}
                        <input type="button" class="btn btn-default" name="cancel" value="{$LANG.CANCEL}" onclick="window.history.go(-1)" />
                    </p>
                {else}
                    <form id="news_form" action="/maps/news/submit" method="POST">

                        <input type="hidden" name="id" value="{$id}" />
                        <input type="hidden" name="action" value="{$do}" />
                        <input type="hidden" name="item_id" value="{$item_id}" />

                        <div style="margin-bottom:5px"><strong>{$LANG.MAPS_NEWS_TITLE}</strong>:</div>
                        <div>
                            <input name="title" class="text-input" type="text" id="news_title" value="{$news.title|escape:'html'}" />
                        </div>

                        <div style="margin-bottom:5px;margin-top: 20px"><strong>{$LANG.MAPS_NEWS_CONTENT}</strong>:</div>
                        <div>
                            {if $cfg.news_html}
                                {wysiwyg name='content' value=$news.content height=300 width='99%' toolbar='Basic'}
                            {else}
                                <textarea name="content" id="news_content" style="width:99%;height:300px">{$news.content}</textarea>
                            {/if}
                        </div>

                        <div style="margin-top:20px">
                            <input type="button" class="btn btn-default" name="save" value="{$LANG.SAVE}" onclick="checkForm()" />
                            <input type="button" class="btn btn-default" name="cancel" value="{$LANG.CANCEL}" onclick="window.history.go(-1)" />
                        </div>

                    </form>
                {/if}
            </div>
	</div>
</div>
{if !$limit_reach}
    <script type="text/javascript">
        {literal}
        function checkForm(){
            if ($('input#news_title').val()=='') {
                $('input#news_title').focus();
                alert('Пожалуйста, укажите заголовок новости');
                return false;
            } else {
                $('form#news_form').submit();
            }
        }
        {/literal}
    </script>
{/if}