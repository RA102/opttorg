	<form action="/shop/{$root_cat.seolink}" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="h4 modal-title" id="filModalLabel">Фильтр товаров</div>
      </div>
      <div class="modal-body">
				<div class="filter-block">
					<div class="ex-click">Цена, тенге</div>
					<div class="row">
						<div class="col-xs-6"><input type="number" min="1" name="filter[pfrom]" class="form-control" value="{$filter.pfrom}" placeholder="от" /></div>
						<div class="col-xs-6"><input type="number" min="1" name="filter[pto]" class="form-control" value="{$filter.pto}" placeholder="до" /></div>
					</div>
				</div>			
				<div class="clearfix">
					{if $cfg.show_filter_vendors && is_array($vendors)}
					<div class="filter-block">
						<div class="ex-click">Производство <span class="pull-right"><span class="glyphicon glyphicon-plus-sign"></span></span></div>
						<div class="ex-slide">
						{foreach key=vendor_id item=vendor from=$vendors}
						<div class="f-label"><label><input type="checkbox" value="{$vendor.id}" name="filter[vendors][]" {if in_array($vendor.id, $filter.vendors)}checked="checked"{/if} /> {$vendor.title}</label></div>
						{/foreach}
						</div>
					</div>	
					{/if}
					{$crse="1"}
                    {foreach key=tid item=char from=$chars}
					{if $char.is_filter}
					<div class="filter-block">
						<div class="ex-click">{$char.title}{if $char.units}, {$char.units}{/if} <span class="pull-right"><span class="glyphicon glyphicon-plus-sign"></span></span></div>
						<div class="ex-slide">
						{if $char.fieldtype != 'int'}
							{if $char.values}
								{if $char.is_filter_many}
								{foreach key=vid item=val from=$char.values_arr}
									<div class="f-label"><label><input type="checkbox" value="{$val}" name="filter[{$char.id}][]" {if in_array(trim($val), $filter[$char.id])}checked="checked"{/if} /> {$val}</label></div>
								{/foreach}
								{else}
                                    <select name="filter[{$char.id}]" class="form-control">
                                        <option value="" {if !$filter[$char.id]}selected="selected"{/if}>{$LANG.SHOP_FILTER_ALL}</option>
                                        {foreach key=vid item=val from=$char.values_arr}
                                        <option value="{$val}" {if trim($filter[$char.id]) == trim($val)}selected="selected"{/if}>{$val}</option>
                                        {/foreach}
                                    </select>								
								{/if}
							{else}
								<input type="text" name="filter[{$char.id}]" class="form-control" value="{$filter[$char.id]}" />
							{/if}
						{else}
                            <input type="text" name="filter[{$char.id}][from]" class="form-control" value="{$filter[$char.id].from}" /><input type="text" name="filter[{$char.id}][to]" class="form-control" value="{$filter[$char.id].to}" />					
						{/if}
						</div>
					</div>	
					{$crse=$crse+1}
					{/if}					
                    {/foreach}
      </div>
      <div class="modal-footer">
        <input type="submit" value="{$LANG.SHOP_FILTER_SUBMIT}" class="btn btn-main" />
		{if $filter}<input type="button" value="Сброс" onclick="window.location.href='/shop/{$root_cat.seolink}/all'"  class="btn btn-not-main" />{/if}
      </div>
	</form>

