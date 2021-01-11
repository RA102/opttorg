{* ================================================================================ *}
{* =================== Cписок [под]рубрик и товаров магазина ====================== *}
{* ================================================================================ *}

<h1 class="con_heading">{$root_cat.title}</h1>

{if $root_cat.description}
    <div style="margin-bottom:20px">{$root_cat.description}</div>
{/if}

{if $cfg.show_subcats && $subcats}
    <ul class="shop_cat_list">
        {foreach key=tid item=cat from=$subcats}
            <li class="shop_cat_item" style="background:url(/images/photos/small/{$cat.config.icon}) no-repeat left top;">
                <div><a href="/shop/{$cat.seolink}">{$cat.title}</a></div>
                {if $cat.subcats}
                    <div class="subcats">
                        {foreach key=num item=subcat from=$cat.subcats}
                            <a href="/shop/{$subcat.seolink}">{$subcat.title}</a>{if $num<sizeof($cat.subcats)-1}, {/if}
                        {/foreach}
                    </div>
                {/if}
            </li>
        {/foreach}
    </ul>
{/if}

{if $cfg.show_filter && ($items || $filter)}

<div class="shop_filter_link">
    <a href="javascript:" onclick="$('.shop_filter').toggle()">{$LANG.SHOP_FILTER}</a> {if $filter}Найдено товаров: {$total}{/if}
</div>

    <div class="shop_filter">

        <div class="filter_body">
            <form action="/shop/{$root_cat.seolink}" method="post">

                <table cellpadding="2" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td colspan="3"><strong>{$LANG.SHOP_PRICE}</strong></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="filter[pfrom]" class="input" value="{$filter.pfrom}" style="width:102px"/></td>
                        <td>&mdash;</td>
                        <td><input type="text" name="filter[pto]" class="input" value="{$filter.pto}" style="width:102px"/></td>
                    </tr>
                    {if $cfg.show_filter_vendors && is_array($vendors)}
                    <tr>
                        <td colspan="3" style="padding-top:8px;"><strong>{$LANG.SHOP_VENDORS}:</strong></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            {foreach key=vendor_id item=vendor from=$vendors}
                                <div>
                                    <label>
                                        <input type="checkbox" value="{$vendor.id}" name="filter[vendors][]" {if in_array($vendor.id, $filter.vendors)}checked="checked"{/if} /> {$vendor.title}
                                    </label>
                                </div>
                            {/foreach}
                        </td>
                    </tr>
                    {/if}
                    {foreach key=tid item=char from=$chars}
                        {if $char.is_filter}
                            <tr>
                                <td colspan="3" style="padding-top:8px;">
                                    <strong>
                                        {$char.title}{if $char.units}, {$char.units}{/if}
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                {if $char.fieldtype != 'int'}
                                    <td colspan="3">
                                        {if $char.values}
                                            {if $char.is_filter_many}
                                                {foreach key=vid item=val from=$char.values_arr}
                                                    <div>
                                                        <label><input type="checkbox" value="{$val}" name="filter[{$char.id}][]" {if in_array(trim($val), $filter[$char.id])}checked="checked"{/if} /> {$val}</label>
                                                    </div>
                                                {/foreach}
                                            {else}
                                                <select name="filter[{$char.id}]" style="width:100%">
                                                    <option value="" {if !$filter[$char.id]}selected="selected"{/if}>{$LANG.SHOP_FILTER_ALL}</option>
                                                    {foreach key=vid item=val from=$char.values_arr}
                                                        <option value="{$val}" {if trim($filter[$char.id]) == trim($val)}selected="selected"{/if}>{$val}</option>
                                                    {/foreach}
                                                </select>
                                            {/if}
                                        {else}
                                                <input type="text" name="filter[{$char.id}]" class="input" value="{$filter[$char.id]}" style="width:99%"/>
                                        {/if}
                                    </td>
                                {else}
                                    <td><input type="text" name="filter[{$char.id}][from]" class="input" value="{$filter[$char.id].from}" style="width:102px"/></td>
                                    <td>&mdash;</td>
                                    <td><input type="text" name="filter[{$char.id}][to]" class="input" value="{$filter[$char.id].to}" style="width:102px"/></td>
                                {/if}
                            </tr>
                        {/if}
                    {/foreach}
                </table>
                <p>
                    <input type="submit" value="{$LANG.SHOP_FILTER_SUBMIT}" />
                    {if $filter}<input type="button" value="{$LANG.SHOP_FILTER_CANCEL}" onclick="window.location.href='/shop/{$root_cat.seolink}/all'" />{/if}
                    <input type="button" value="Закрыть" onclick="$('.shop_filter').toggle()" />
                </p>
            </form>
        </div>
    </div>
{/if}

{if $items}
    {include file='com_inshop_items.tpl'}
{else}
    {if $filter}
        <p>{$LANG.SHOP_ITEMS_NOT_FOUND}</p>
    {/if}
{/if}

