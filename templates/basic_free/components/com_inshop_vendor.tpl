<h1 class="con_heading">{$vendor.title}</h1>

<div class="rub-wrp">
	<div class="row no-gutters">

		<div class="col-lg-9 col-lg-push-3">
{if $items}

    {include file='com_inshop_items.tpl'}

{else}

    <p class="text-danger">{$LANG.SHOP_VENDOR_NO_ITEMS}</p>

{/if}
		</div>
		<div class="col-lg-3 col-lg-pull-9">
			<div class="vendor-descr">{$vendor.descr}</div>			
		</div>		
	</div>
</div>
<div id="stopstick" class="clearfix"></div>

