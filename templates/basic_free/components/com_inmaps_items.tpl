{if $items}
<div class="breaker"></div>
    {if $cfg.ratings}
        {add_js file='components/maps/js/rating/jquery.MetaData.js'}
        {add_js file='components/maps/js/rating/jquery.rating.js'}
        {add_css file='components/maps/js/rating/jquery.rating.css'}
    {/if}
        {foreach key=num item=item from=$items}
<div class="row margin-bottom-row {cycle values="rowb1,rowb2"}">
	{if $cfg.show_thumb}
	<div class="col-md-4 media-gird">
        <a href="/maps/{$item.seolink}.html"><img src="/images/photos/small/{$item.filename}" class="media-object" /></a>	
	</div>
	<div class="col-md-8">
	{else}
	<div class="col-xs-12">
	{/if}
		<div class="media-body">
            {if $cfg.ratings}
                <div class="pull-right">
                <form action="/maps/rate" method="POST">
                    <input type="hidden" name="item_id" value="{$item.id}" />
                    <input type="hidden" name="points" value="{$item.id}" />
                    {section name=rate start=1 loop=6 step=1}
                        <input name="rate" type="radio" class="star" value="{$smarty.section.rate.index}" {if $item.rating>=$smarty.section.rate.index}checked="checked"{/if} {if !$is_user || $item.user_voted}disabled="disabled"{/if} />
                    {/section}
                </form>
				</div>
            {/if}	
			<h3 class="media-heading"><a href="/maps/{$item.seolink}.html">{$item.title}</a></h3>
			<div class="item-addr">
                            <div class="address" id="addr_main{$item.id}">
                                <span>
                                    {if $cfg.mode=='world'}
                                        {$item.address}
                                    {else}
                                        {$item.map_address}
                                    {/if}
                                </span>
                                {if sizeof($item.addresses) > 1}
                                    <a href="javascript:" class="ajaxlink" onclick="{literal}${/literal}('#addr_main{$item.id}').hide();{literal}${/literal}('#addr_all{$item.id}').show();">все адреса</a>
                                {/if}
                            </div>

                            <div class="addresses" style="display:none" id="addr_all{$item.id}">
                            {foreach key=m item=address from=$item.addresses}
                                <div class="address">
                                    <span>
                                        {if $cfg.mode=='world'}
                                            {$address.full}
                                        {else}
                                            {$address.short}
                                        {/if}
                                    </span>
                                </div>
                            {/foreach}
                            </div>	
			</div>
            {if $cfg.show_desc}
            <div class="media-description">{$item.shortdesc}</div>
            {/if}	

			{if ($cfg.show_vendors && $item.vendor) || $cfg.comments || $cfg.show_compare || $item.can_edit}				
			<div class="media-hinttext">
			{if $cfg.show_vendors && $item.vendor}<a href="/maps/vendors/{$item.vendor_id}" class="monospc"><span class="glyphicon glyphicon-flag"></span> {$item.vendor}</a>{/if}			
            {if $cfg.comments}<a href="/maps/{$item.seolink}.html#c" class="monospc"><span class="glyphicon glyphicon-comment"></span> {$item.comments|spellcount:$LANG.COMMENT:$LANG.COMMENT2:$LANG.COMMENT10}</a>{/if}
            {if $cfg.show_compare}
                {if !$item.is_in_compare}
                <a href="/maps/compare/{$item.id}" class="monospc" rel="nofollow"><span class="glyphicon glyphicon-random"></span> &nbsp; {$LANG.MAPS_COMPARE_ADD}</a>
                {else}
                <a href="/maps/compare.html" class="monospc" rel="nofollow"><span class="glyphicon glyphicon-random"></span> &nbsp; {$LANG.MAPS_COMPARE_ITEM_IN}{$LANG.MAPS_COMPARE_IN}</a>
                {/if}
            {/if}
                                {if $item.can_edit}
                                        <a href="/maps/edit{$item.category_id}-{$item.id}.html">{$LANG.MAPS_EDIT_OBJECT}</a>
                                {/if}			
			</div>
			{/if}
		</div>
	</div>
</div>
        {/foreach}

    {if $pages>1}
            {$pagebar}
    {/if}

    {if $cfg.ratings}
        <script type="text/javascript">
        {literal}
            $('.star').rating({
                callback: function(value, link){
                    $(this.form).find('input[name=points]').val(value);
                    this.form.submit();
                }
            });
        {/literal}
        </script>
    {/if}

{/if}
