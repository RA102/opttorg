{* ================================================================================ *}
{* =================== Cписок [под]рубрик и товаров магазина ====================== *}
{* ================================================================================ *}

<h1 class="con_heading"><a href="#" class="history-back hidden-lg hidden-md" onclick="history.back();">&laquo;</a> {if $root_cat.title}{$root_cat.title}{else}Каталог{/if}{if $filter} ({$total}){/if}</h1>

{if $topbanner!=''}{$topbanner}{/if}
{if $smarty.server.REQUEST_URI == "/shop"}
<div class="row mb20">
    {foreach key=tid item=cat from=$subcats name=shopcats}
	<div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 px-1"> {*  *}
		<div class="thumb-cat ">
			<a href="/shop/{$cat.seolink}" title="{$cat.title}">
				<img src="/images/photos/small/{$cat.config.icon}" class="img-thumbnail" alt="{$cat.title}"/>
			</a>
			<a class="cat-th-title" href="/shop/{$cat.seolink}" data-truncate="1">{$cat.title}</a>
		</div>
	</div>	
    {/foreach}
</div>
{else}
	<div class="d-flex flex-row justify-content-between align-items-center">
		<div class="">
			<a id="btnFilterItems" class="mob-filter hidden-lg">Фильтр товаров</a>
		</div>
		{if $items}
			<div class="shop_items_sort">
				<span class="" >по:</span>
				{foreach key=t item=type from=$order_types}
					{if $type.selected}
						<a href="/shop/sort/{$type.order}/{if $orderto=='asc'}desc{else}asc{/if}" class="selected">
							{$type.name}
							{if $orderto=='asc'}&darr;{else}&uarr;{/if}</a>
					{else}
						<a href="/shop/sort/{$type.order}/asc">{$type.name}</a>
					{/if}
					{if $t<3}|{/if}
				{/foreach}
			</div>
		{/if}
	</div>
	<div class="rub-wrp">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-3 pr-2">
				{if $subcats}
				<div class="subcats-style">
				<ul class="rub-list">
				{foreach key=tid item=cat from=$subcats name=shopcats}
					<li><a href="/shop/{$cat.seolink}" title="{$cat.title}">{$cat.title}</a></li>
				{/foreach}
				</ul>
				</div>
				{/if}
				<div
						id="divFilterItems"
						class="d-none d-lg-block"
{*						style="display: none"*}
				>
					<div class="subcats-style">
						<form action="/shop/{$root_cat.seolink}" method="post">
							<div class="filter-block col-12">
								<div class="ex-click col-12">Цена, тенге</div>
								<div class="row"> {* col-sm-12 col-md-12 col-lg-12   *}
									<div class="col-6 col-sm-6 col-md-6 col-lg-6 pl-0">
										<input
												class="form-control"
												type="number"
												min="1"
												name="filter[pfrom]"
												value="{$filter.pfrom}"
												placeholder="от"

										/>
									</div>
									<div class="col-6 col-sm-6 col-md-6 col-lg-6">
										<input
												class="form-control"
												type="number"
												min="1"
												name="filter[pto]"
												value="{$filter.pto}"
												placeholder="до"

										/>
									</div>
								</div>
							</div>
							<div class="clearfix">
								{if $cfg.show_filter_vendors && is_array($vendors)}
								<div class="filter-block">
									<div class="ex-click">Производство <span class="pull-right"><span class="glyphicon glyphicon-plus-sign"></span></span></div>
									<div class="ex-slide">
									{foreach key=vendor_id item=vendor from=$vendors}
									<div class="f-label"><label><input type="checkbox" value="{$vendor.id}" name="filter[vendors][]" {if in_array($vendor_id, $filter.vendors)}checked="checked"{/if} /> {$vendor.title}</label></div>
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

							<p>
								<input type="submit" value="{$LANG.SHOP_FILTER_SUBMIT}" class="btn btn-main" />
								{if $filter}<input type="button" value="Сброс" onclick="window.location.href='/shop/{$root_cat.seolink}/all'"  class="btn-oneclick" />{/if}
							</p>
						</form>
					</div>


				</div>
				{if $leftbanner!=''}{$leftbanner}{/if}
			</div>
			<div class="col-12 col-sm-12 col-md-12 col-lg-9">

			{if $items}
				{include file='com_inshop_items.tpl'}
			{else}
				{if $filter}
					<p>{$LANG.SHOP_ITEMS_NOT_FOUND}</p>
				{/if}
			{/if}
			{if $root_cat.description && $is_pager==1}
				<div class="rub-description">{$root_cat.description}</div>
			{/if}
			</div>
		</div>
	</div>
{/if}
<div id="stopstick" class="clearfix"></div>
