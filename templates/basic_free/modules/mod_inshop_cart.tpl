<table class="hidden-md hidden-sm hidden-xs" width="100%" border="0" >
    <tr>
        <td valign="middle">
            <div class="top-rel">
                <img src="/templates/{template}/images/cart.svg" class="img-icon mt5" height="32"/>
                {if $items}
                <div class="top-qty text-center w16" style="">{if $totalsumm>0}{$items_count}{else}0{/if}</div>
                {/if}
            </div>
        </td>
        <td valign="middle"> Корзина
            <div class="top-gray">{$totalsumm} тг</div>
        </td>
    </tr>
</table>
<div class="d-flex hidden-lg" style="position: relative;">
    <img src="/templates/{template}/images/cart.svg" class="img-icon" height="36"/>
    {if $items}
        <div class="top-qty text-center w16" style="">{if $totalsumm>0}{$items_count}{else}0{/if}</div>
    {/if}
</div>
{*<span class="hidden-lg"><span class="glyphicon glyphicon-shopping-cart"></span>*}
{*    <sup> {if $totalsumm>0}{$items_count}{else}0{/if}</sup></span>*}