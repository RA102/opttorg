{$item.plugins_output_before}
{if $cat.view_type=='shop' || $item.can_edit}
	<div class="float_bar" id="shop_toollink_div">
    {if $cat.view_type=='shop'}
        {$shopCartLink}
    {/if}
    {if $item.can_edit}
        <a href="/catalog/edit{$item.id}.html" class="btn btn-default">{$LANG.EDIT}</a>
    {/if}
    </div>
{/if}
<h1 class="con_heading">{$item.title}</h1>
<div class="row margin-bottom-row">
	<div class="col-md-4 media-gird">
		{if strlen($item.imageurl)>4}
            <a class="lightbox-enabled" title="{$item.title|escape:'html'}" rel="lightbox" href="/images/catalog/{$item.imageurl}" target="_blank"><img class="media-object" alt="{$item.title|escape:'html'}" src="/images/catalog/medium/{$item.imageurl}" /></a>
        {else}
            <img class="media-object" src="/images/catalog/medium/nopic.jpg" />
        {/if}	
	</div>
	<div class="col-md-8">
        <ul class="list-group">
        	<li class="list-group-item"><strong>{$LANG.ADDED_BY}: </strong> {$getProfileLink}</li>
			{foreach key=field item=value from=$fields}
                {if $value}
                    {if strstr($field, '/~l~/')}
                        <li class="list-group-item">{$value}</li>
                    {else}
                        <li class="list-group-item"><strong>{$field}: </strong>{$value}</li>
                    {/if}
                {/if}
			{/foreach}
{if ($cat.showtags) && ($tagline)}
    <li class="list-group-item"><strong>{$LANG.TAGS}: </strong> {$tagline}</li>
{/if}			
		</ul>
        {if $cat.view_type=='shop'}
		<div class="well">
                <span class="item-catalog-current-price">{$LANG.PRICE}: {$item.price} {$LANG.CURRENCY}</span>
                <a href="/catalog/addcart{$item.id}.html" class="btn btn-primary" rel="nofollow" title="{$LANG.ADD_TO_CART}" id="shop_ac_item_link"><span class="glyphicon glyphicon-shopping-cart"></span> {$LANG.ADD_TO_CART}</a>
		</div>
        {/if}
        {if $item.on_moderate}
                <div id="shop_moder_form" style="margin:10px 0;">
                    <p class="text-danger">{$LANG.WAIT_MODERATION}:</p>
                    <table cellpadding="0" cellspacing="0" border="0"><tr>
                    <td>
                            <form action="/catalog/moderation/accept{$item.id}.html" method="POST">
                                <input type="submit" name="accept" value="{$LANG.MODERATION_ACCEPT}"/>
                            </form>
                          </td>
                    <td>
                            <form action="/catalog/edit{$item.id}.html" method="POST">
                                <input type="submit" name="accept" value="{$LANG.EDIT}"/>
                            </form>
                          </td>
                    <td>
                            <form action="/catalog/moderation/reject{$item.id}.html" method="POST">
                                 <input type="submit" name="accept" value="{$LANG.MODERATION_REJECT}"/>
                            </form>
                          </td>
                    </tr></table>
                </div>
        {/if}
	</div>
</div>
{if $cat.is_ratings}
	{$ratingForm}
{/if}	
{$item.plugins_output_after}