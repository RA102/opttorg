{*<div class="alert alert-warning">Уважаемые пользователи! В данное время на сайте ведутся технические работы. Оплата временно возможна <strong>только наличными курьеру</strong>! Благодарим за понимание.</div>*}
<h1 class="con_heading"><span>{$LANG.SHOP_SELECT_PAYSYS}</span></h1>
<div class="row">
    <div class="col-12 bg-white shadow">
        <table class="table table-borderless d-table">
            {foreach key=num item=sys from=$p_systems}
                {foreach key=currency item=kurs from=$sys.config.currency}
                    {if $kurs}
                        <tr class="d-table-row">
                            <td class="d-table-cell align-middle" width="20">
                                <input type="radio" name="psys_selector" value="{$sys.link}_{$currency}" onclick="{literal}$('form.psys').hide();$('form#'+$(this).val()).show();{/literal}" />
                            </td>
                            <td class="d-table-cell align-middle" width="100">
                                <img src="/components/shop/payments/{$sys.link}/{$sys.logo}" border="0" onclick="{literal}$(this).parent('td').parent('tr').find('input:radio').trigger('click');{/literal}" style="cursor:pointer"/>
                            </td>
                            <td class="d-table-cell align-middle">
                                <div class="psys_price">{$kurs} <span>{$currency|str_replace:'RUR':$cfg.currency}</span></div>
                            </td>
                            <td class="d-table-cell align-middle">
                                <div>{$sys.forms.$currency}</div>
                            </td>
                        </tr>
                    {/if}
                {/foreach}
            {/foreach}
        </table>
    </div>
</div>
<script type="text/javascript">
    {literal}
        $('input:radio').eq(0).trigger('click');
    {/literal}
</script>

<p style="margin:10px 0 30px 0">
    <input type="button" name="back" class="btn-vspis" value="{$LANG.SHOP_BACK_TO_ORDER}" onclick="window.location.href='/shop/{$order.id}/order.html';" />
</p>
