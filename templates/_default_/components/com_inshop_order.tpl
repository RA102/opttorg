<h1 class="con_heading">{$LANG.SHOP_START_ORDER}</h1>

{if $items}

    <form action="/shop/payment.html" method="post">

        <h2 style="margin-top:15px">{$LANG.SHOP_ITEMS_LIST}</h2>

        {include file='com_inshop_cart_items.tpl'}

        {if $delivery_types}
            <h2 style="margin-top:25px">{$LANG.SHOP_DELIVERY_TYPE}</h2>

            <script type="text/javascript">
                {literal}
                    function calcSumm(del_price){
                        var result_summ = Number(del_price) + Number($("#totalsumm").val());
                        $("#resultsumm").html(result_summ);
                    }
                {/literal}
            </script>

            <table cellpadding="0" cellspacing="0" border="0" class="d_table" width="99%">
                {foreach key=num item=dtype from=$delivery_types}
                    <tr>
                        <td width="30" class="btop">
                            <input type="radio" id="d_type{$num}" name="d_type" value="{$dtype.id}" onclick="calcSumm({$dtype.price});" {if !$order}{if $num==0}checked="checked"{/if}{else}{if $order.d_type==$dtype.id}checked="checked"{/if}{/if} />
                        </td>
                        <td  class="btop">
                            <span class="d_type"><label for="d_type{$num}">{$dtype.title}</label></span>
                            <span class="d_price">
                                {if $dtype.price}{$dtype.price} {$cfg.currency}{else}{$LANG.SHOP_FREE}{/if}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            {$dtype.description}
                        </td>
                    </tr>
                {/foreach}
            </table>
        {/if}

        <script type="text/javascript">
            {literal}
                $(document).ready(function(){
                    $(".d_table input:radio").eq(0).trigger("click");
                });
            {/literal}
        </script>

        <h2 style="margin-top:25px">{$LANG.SHOP_CUSTOMER_INFO}</h2>

        {if !$user_id}
            <p>{$LANG.SHOP_REG_NOTICE}</p>
        {/if}

        <table cellpadding="0" cellspacing="0" border="0" class="customer_info" width="99%">
            <tr>
                <td width="160" class="first">{$LANG.SHOP_CUSTOMER}: </td>
                <td  class="first">
                    <label><input type="radio" id="customer_fis" onclick="{literal}$(".customer_info .org").hide();{/literal}" name="cust_type" value="fis" checked="checked"/> {$LANG.SHOP_CUSTOMER_FIS}</label>
                    <label><input type="radio" id="customer_org" onclick="{literal}$(".customer_info .org").show();{/literal}" name="cust_type" value="org"/> {$LANG.SHOP_CUSTOMER_ORG}</label>
                </td>
            </tr>
            <tr>
                <td>{$LANG.SHOP_CUSTOMER_NAME} {if in_array("name", $cfg.ord_req)}<span style="color:red">*</span>{/if}: </td>
                <td><input type="text" id="customer_name" name="customer_name" class="input" value="{$order.customer_name}" /></td>
            </tr>
            <tr class="org" style="display:none">
                <td>{$LANG.SHOP_CUSTOMER_COMPANY} {if in_array("org", $cfg.ord_req)}<span style="color:red">*</span>{/if}: </td>
                <td><input type="text" id="customer_org" name="customer_org" class="input" value="{$order.customer_org}" /></td>
            </tr>
            <tr class="org" style="display:none">
                <td>{$LANG.SHOP_CUSTOMER_INN} {if in_array("inn", $cfg.ord_req)}<span style="color:red">*</span>{/if}: </td>
                <td><input type="text" id="customer_inn" name="customer_inn" class="input" value="{$order.customer_inn}" /></td>
            </tr>
            <tr>
                <td>{$LANG.SHOP_CUSTOMER_PHONE} {if in_array("phone", $cfg.ord_req)}<span style="color:red">*</span>{/if}: </td>
                <td><input type="text" id="customer_phone" name="customer_phone" class="input" value="{$order.customer_phone}" /></td>
            </tr>
            <tr>
                <td>{$LANG.SHOP_CUSTOMER_EMAIL} {if in_array("email", $cfg.ord_req)}<span style="color:red">*</span>{/if}: </td>
                <td><input type="text" id="customer_email" name="customer_email" class="input" value="{$order.customer_email}" /></td>
            </tr>
            <tr>
                <td>{$LANG.SHOP_CUSTOMER_ADDRESS} {if in_array("address", $cfg.ord_req)}<span style="color:red">*</span>{/if}: </td>
                <td><input type="text" id="customer_address" name="customer_address" class="input" value="{$order.customer_address}" /></td>
            </tr>
            <tr>
                <td>{$LANG.SHOP_CUSTOMER_COMMENT}: </td>
                <td><input type="text" id="customer_comment" name="customer_comment" class="input" value="{$order.customer_comment}" /></td>
            </tr>
        </table>

        <p class="total_to_pay">
            <span class="label">{$LANG.SHOP_TOTAL_TO_PAY}:</span>
            <span id="result">
                <span id="resultsumm">                    
                    {if !$order}                    
                        {if $delivery_types}
                            {$totalsumm+$delivery_types[0].price}
                        {else}
                            {$totalsumm}
                        {/if}
                    {else}
                        {$order.summ}
                    {/if}
                </span> 
                {$cfg.currency}
            </span>
        </p>

        <p style="margin-top:25px">
            <input type="button" name="back" value="{$LANG.SHOP_BACK_TO_CART}" onclick="window.location.href=\"/shop/cart.html\";" /> 
            <input type="submit" name="gopay" value="{$LANG.SHOP_GO_PAYMENT}" />
        </p>

    </form>

{else}

    <p>{$LANG.SHOP_CART_EMPTY}</p>
    <p><input type="button" name="back" value="{$LANG.SHOP_BACK_TO_SHOP}" onclick="window.location.href=\"{$last_url}\";" /></p>

{/if}
