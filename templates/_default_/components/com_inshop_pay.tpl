<h1 class="con_heading">{$LANG.SHOP_SELECT_PAYSYS}</h1>

<table border="0" cellpadding="10" cellspacing="0" width="">
    {foreach key=num item=sys from=$p_systems}
        {foreach key=currency item=kurs from=$sys.config.currency}
            {if $kurs}
                <tr>
                    <td width="20">
                        <input type="radio" name="psys_selector" value="{$sys.link}_{$currency}" onclick="{literal}$('form.psys').hide();$('form#'+$(this).val()).show();{/literal}" />
                    </td>
                    <td width="100">
                        <img src="/components/shop/payments/{$sys.link}/{$sys.logo}" border="0" onclick="{literal}$(this).parent('td').parent('tr').find('input:radio').trigger('click');{/literal}" style="cursor:pointer"/>
                    </td>
                    <td>
                        <div class="psys_price">{$kurs} <span>{$currency|str_replace:'RUR':$cfg.currency}</span></div>
                    </td>
                    <td>
                        <div>{$sys.forms.$currency}</div>
                    </td>
                </tr>
            {/if}
        {/foreach}
    {/foreach}
</table>

<script type="text/javascript">
    {literal}
        $('input:radio').eq(0).trigger('click');
    {/literal}
</script>

<p style="margin-top:25px">
    <input type="button" name="back" value="{$LANG.SHOP_BACK_TO_ORDER}" onclick="window.location.href='/shop/{$order.id}/order.html';" />
</p>
