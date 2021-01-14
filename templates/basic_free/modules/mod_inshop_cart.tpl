<div class="d-none d-md-none d-sm-none d-lg-flex d-xl-flex" >
    <div class="position-relative">
        <img src="/templates/{template}/images/cart.svg" class="img-icon mt5" height="32"/>
        {if $items}
        <div class="top-qty text-center w16" style="">{if $totalsumm>0}{$items_count}{else}0{/if}</div>
        {/if}
    </div>
    <div class="ml-3">
        <span>Корзина</span>
        <div class="top-gray">{$totalsumm} тг</div>
    </div>
</div>
<div class="d-flex d-lg-none" style="position: relative;">
    <img src="/templates/{template}/images/cart.svg" class="img-icon" height="36"/>
    {if $items}
        <div class="top-qty text-center w16" style="">{if $totalsumm>0}{$items_count}{else}0{/if}</div>
    {/if}
</div>
