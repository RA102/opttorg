    <form id="sform"action="/search" method="GET" enctype="multipart/form-data" style="clear:both">


			<h1 class="con_heading"><span>{$LANG.SEARCH_ON_SITE}</span></h1>
<div class="body-page">
	<div class="clearfix">
		<div class="row margin-bottom-row">
			<div class="col-sm-4">
        		<input type="text" name="query" id="query" size="40" value="{$query|escape:'html'}" placeholder="{$LANG.FIND}..." class="form-control" />
			</div>
			<div class="col-sm-3">			
        <select name="look" onchange="$('form#sform').submit();" class="form-control">
            <option value="allwords" {if $look=='allwords' || $look==''} selected="selected" {/if}>{$LANG.ALL_WORDS}</option>
            <option value="anyword" {if $look=='anyword' || $look==''} selected="selected" {/if}>{$LANG.ANY_WORD}</option>
            <option value="phrase" {if $look=='phrase' || $look==''} selected="selected" {/if}>{$LANG.PHRASE}</option>
        </select>
			</div>
			<div class="col-sm-3">	
        <select name="from_pubdate" class="form-control">
            <option value="" {if !$from_pubdate}selected="selected"{/if}>{$LANG.PUBDATE}: {$LANG.ALL}</option>
            <option value="d" {if $from_pubdate=='d'}selected="selected"{/if}>{$LANG.F_D}</option>
            <option value="w" {if $from_pubdate=='w'}selected="selected"{/if}>{$LANG.F_W}</option>
            <option value="m" {if $from_pubdate=='m'}selected="selected"{/if}>{$LANG.F_M}</option>
            <option value="y" {if $from_pubdate=='y'}selected="selected"{/if}>{$LANG.F_Y}</option>
        </select>		
			</div>
			<div class="col-sm-2">
        <input type="submit" class="btn btn-default btn-block" value="{$LANG.FIND}"/>
			</div>
		</div>
        <div id="from_search">
			<!--
			<div class="checkbox">
                {foreach key=tid item=enable_component from=$enable_components}
                            <label id="l_{$enable_component.link}" {if in_array($enable_component.link, $from_component) || !$from_component}class="selected"{/if} style="padding-right:7px;">
                                <input name="from_component[]" onclick="toggleInput('l_{$enable_component.link}')" type="checkbox" value="{$enable_component.link}" {if in_array($enable_component.link, $from_component) || !$from_component}checked="checked"{/if} />
                                {$enable_component.title}</label>
                {/foreach}
            <label id="order_by_date" class="gsegre" {if $order_by_date}class="selected"{/if}>
                <input name="order_by_date" onclick="toggleInput('order_by_date')" type="checkbox" value="1" {if $order_by_date}checked="checked"{/if} /> <span>Сначала новые</span></label>				
			</div>
			-->
        </div>
	</div>
	
    </form>


{if $results}
	{$num="1"}
<div class="responsive-table">	
    <div class="panel-heading"><h4 class="panel-title">{$LANG.BY_QUERY} <strong>{$query}</strong> найдено {$total|spellcount:$LANG.1_MATERIALS:$LANG.2_MATERIALS:$LANG.10_MATERIALS}</h4></div>
	<table class="table table-bordered">
    {foreach key=tid item=item from=$results}
	<tr>
	<td width="18">{$num}.</td>
    <td><a href="{$item.link}" target="_blank">{$item.s_title}</a></td>
	<!--<td><a href="{$item.placelink}">{$item.place}</a></td> -->

     {$num=$num+1}
	 </tr>
    {/foreach}
    
	</table>
</div>
{$pagebar}
{else}
	{if $query}
	<div class="well text-danger">{$LANG.BY_QUERY} <strong>"{$query}"</strong> {$LANG.NOTHING_FOUND}. <a href="{$external_link}" target="_blank">{$LANG.FIND_EXTERNAL}</a>
	</div>
    {/if}
{/if}
</div>
<script type="text/javascript">
		$(function(){
			$('#query').focus();
        });
		function toggleInput(id){
			$('#from_search label#'+id).toggleClass('selected');
		}
		function paginator(page){
			$('#sform').append('<input type="hidden" name="page" value="'+page+'" />');
			$('#sform').submit();
		}
</script>