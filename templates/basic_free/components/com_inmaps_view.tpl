{* ================================================================================ *}
{* =================== Cписок [под]рубрик и товаров магазина ====================== *}
{* ================================================================================ *}

{if $root_cat.id!=1}
    <div class="float_bar">
        {if $cfg.show_rss}
            <a href="/rss/maps/{$root_cat.id}/feed.rss" class="btn btn-default"><span class="glyphicon glyphicon-signal"></span></a>
        {/if}
        {if $is_can_add}
            <a href="/maps/add{$root_cat.id}.html" class="btn btn-default">{$LANG.MAPS_ADD_OBJECT}</a>
        {/if}
        {if $cfg.events_enabled}
            <a href="/maps/events/{$root_cat.id}" class="btn btn-default">{$LANG.MAPS_EVENTS}</a>
        {/if}
        {if $cfg.news_enabled}
            <a href="/maps/news/{$root_cat.id}" class="btn btn-default">{$LANG.MAPS_NEWS}</a>
        {/if}
    </div>
{/if}

<h1 class="con_heading">
{if $root_cat.id!=1}
        {if $cfg.city_sel != 'none'}
         <a href="javascript:selectCity('{$cfg.city_sel}')" class="monospc" title="{$LANG.MAPS_SELECT_CITY_LINK}"><span class="glyphicon glyphicon-map-marker"></span> {if $location.city}{$location.city}{else}Все города{/if}</a>  &rarr;  
        {/if}
{/if}
{$root_cat.title}
</h1>


{add_css file='components/maps/city_select/nyromodal.css'}
{add_js file='components/maps/city_select/nyromodal.js'}
{add_js file='components/maps/city_select/select.js'}

{if $root_cat.description}
    <div class="item-description">{$root_cat.description}</div>
{/if}

{if $is_homepage || ($root_cat.id==1 && $cfg.show_map) || ($root_cat.id>1 && $cfg.show_map_in_cats)}
    {if $cfg.show_cats_pos == 'bottom'}
        {include file='com_inmaps_map.tpl'}
    {/if}
{/if}

{if $cfg.show_subcats && $subcats && (!$is_homepage || $cfg.show_homepage=='all')}
{$col="1"}
<div class="well no-padding-bottom">
        {foreach key=tid item=cat from=$subcats name=mapcats}
{if $col==1}<div class="row margin-bottom-row cats-list">{/if}	
<div class="col-md-4">
<div class="media">
	<a class="pull-left" href="/maps/{$cat.seolink}"><img src="/images/photos/small/{$cat.config.icon}" class="media-object" /></a>
  <div class="media-body">
    <h4 class="media-heading"><a href="/maps/{$cat.seolink}">{$cat.title}</a></h4>	
       {if $cat.subcats && $cfg.show_subcats2}
    <div class="media-hinttext">
        {foreach key=num item=subcat from=$cat.subcats}
            <a href="/maps/{$subcat.seolink}">{$subcat.title}</a>{if $num<sizeof($cat.subcats)-1}, {/if}
        {/foreach}
    </div>
       {/if}
   </div>
</div>
</div>
{if $col==3 || $smarty.foreach.mapcats.last}</div>{$col="1"}{else}{$col=$col+1}{/if}			
        {/foreach}
</div>
{/if}

{if $is_homepage || ($root_cat.id==1 && $cfg.show_map) || ($root_cat.id>1 && $cfg.show_map_in_cats)}
    {if $cfg.show_cats_pos == 'top'}
        {include file='com_inmaps_map.tpl'}
    {/if}
{/if}

{if $items && !$city_has_objects}
    <p style="float:right;padding:4px;padding-left:20px;background:url(/components/maps/images/info.png) no-repeat left center">
        В вашем городе объекты не найдены. Показаны объекты из других городов
    </p>
{/if}

{if $cfg.show_filter && ($items || $filter) && $filter_chars}
<div class="shop_filter_link">
    <a href="javascript:" onclick="$('.shop_filter').toggle()"><span class="glyphicon glyphicon-filter"></span> {$LANG.MAPS_FILTER}</a> {if $filter}Найдено объектов: {$total}{/if}
</div>

    <div class="shop_filter" >

        <div class="filter_body">
            <form action="/maps/{$root_cat.seolink}" method="post">

                <table cellpadding="2" cellspacing="0" border="0" width="100%">
                    {foreach key=tid item=char from=$filter_chars}
                        {if $char.is_filter}
                            <tr>
                                <td colspan="3" style="padding-top:8px;"><strong>{$char.title}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    {if $char.values}
                                        {if $char.is_filter_many}
                                            {foreach key=vid item=val from=$char.values_arr}
                                                <div>
                                                    <label><input type="checkbox" value="{$val|trim}" name="filter[{$char.id}][]" {if in_array(trim($val), $filter[$char.id])}checked="checked"{/if} /> {$val}</label>
                                                </div>
                                            {/foreach}
                                        {else}
                                            <select name="filter[{$char.id}]" style="width:100%">
                                                <option value="" {if !$filter[$char.id]}selected="selected"{/if}>{$LANG.MAPS_FILTER_ALL}</option>
                                                {foreach key=vid item=val from=$char.values_arr}
                                                    <option value="{$val}" {if trim($filter[$char.id]) == trim($val)}selected="selected"{/if}>{$val}</option>
                                                {/foreach}
                                            </select>
                                        {/if}
                                    {else}
                                        <input type="text" name="filter[{$char.id}]" class="input" value="{$filter[$char.id]}" style="width:99%"/>
                                    {/if}
                                </td>
                            </tr>
                        {/if}
                    {/foreach}
                </table>
                <p>
                    <input type="submit" value="{$LANG.MAPS_FILTER_SUBMIT}" />
                    {if $filter}<input type="button" value="{$LANG.MAPS_FILTER_CANCEL}" onclick="window.location.href='/maps/{$root_cat.seolink}'" />{/if}
                </p>
            </form>
        </div>
    </div>
{/if}

{if $items}
    {include file='com_inmaps_items.tpl'}
{else}
    {if $filter}
        <p>{$LANG.MAPS_ITEMS_NOT_FOUND}</p>
    {/if}
{/if}

<script type="text/javascript">
    {literal}
        function openCity(city){
            window.location.href="/components/maps/city_select/set.php?city="+city;
        }
    {/literal}
</script>