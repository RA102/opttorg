<h1 class="con_heading"><span>{$LANG.SHOP_START_ORDER}</span></h1>
<script src="/templates/basic_free/js/jquery.maskedinput.min.js"></script>
<div class="shadow" style="background:#fff;padding:15px;margin-bottom:20px;">
    {if $items}
        <form id="mainFormDelivery" action="/shop/payment.html" method="post">
            <div class="row">
                <div class="d-none">
                    <h3 class="con_heading"><span>Товары в заказе</span></h3>
                    <div class="small">
{*                        {include file='com_inshop_cart_items.tpl'}*}
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    {if $delivery_types}
                        <h3 class="con_heading"><span>{$LANG.SHOP_DELIVERY_TYPE} *</span></h3>
                            <table class="d_table table">
                                <thead class="w-100">
                                    <tr class="d-md-table-row">
                                        <th class="text-center d-md-table-cell" >#</th>
                                        <th class="text-center d-md-table-cell" >Тип</th>
                                        <th class="text-center d-md-table-cell" >Стоимость</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {foreach from=$delivery_types item=typeDelivery}
                                        <tr class="delivery-tr d-md-table-row">
                                            <td class="text-center d-md-table-cell" valign="middle">
                                                <input class="align-content-center " type="radio" id="d_type{$typeDelivery.id}" name="d_type" value="{$typeDelivery.id}" />
                                            </td>
                                            <td class="text-center d-md-table-cell">
                                                <span class="d_price pull-right">
                                                </span>
                                                <span class="d_type">
                                                    <label for="d_type{$typeDelivery.id}">{$typeDelivery.title}</label>
                                                </span>
                                                <div></div>
                                            </td>
                                            <td class="text-center d-md-table-cell">
                                                <input  style="width: 50px" name="price" type="text" value="{$typeDelivery.price}" disabled>
                                                {$cfg.currency}
                                            </td>
                                        </tr>
                                    {/foreach}
                                </tbody>
                            </table>
                    {/if}

{*                    <script type="text/javascript">*}
{*                        {literal}*}
{*                        $(document).ready(function() {*}
{*                            $(".d_table input:radio").eq(0).trigger("click");*}
{*                        });*}
{*                        {/literal}*}
{*                    </script>*}

                    <div class="separator_with_border"></div>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <h3 class="con_heading"><span>{$LANG.SHOP_CUSTOMER_INFO}</span></h3>

{*{if !$user_id}*}
{*                    <p>{$LANG.SHOP_REG_NOTICE}</p>*}

{*                {/if}*}
                    <div class="">
                        <table class="customer_info table table-borderless d-table">
                            <tr class="d-md-table-row">
                                <td class="d-md-table-cell">
                                    {$LANG.SHOP_CUSTOMER_NAME}
                                    {if in_array("name", $cfg.ord_req)}
                                        <span style="color:red">*</span>
                                    {/if} </td>
                                <td class="d-md-table-cell">
                                    <input type="text" id="customer_name" name="customer_name" class="form-control" value="{$order.customer_name}" placeholder="Как к Вам обращаться?" required/>
                                </td>
                            </tr>
                            <tr class="d-table-row">
                                <td class="d-md-table-cell">
                                    {$LANG.SHOP_CUSTOMER_PHONE}{if in_array("phone", $cfg.ord_req)}
                                        <span style="color:red">*</span>
                                    {/if}
                                </td>
                                <td class="d-md-table-cell">
                                    <input type="text" id="customer_phone" name="customer_phone" class="form-control" value="{$order.customer_phone}" placeholder="8 (ХХХ) ХХХ ХХ ХХ" required/>
                                </td>
                            </tr>
                            <tr class="d-table-row">
                                <td class="d-md-table-cell">
                                    {$LANG.SHOP_CUSTOMER_CITY}{if in_array("city", $cfg.ord_req)}
                                        <span style="color:red">*</span>
                                    {/if}
                                </td>
                                <td class="d-md-table-cell">
                                    <input type="text" id="customer_city" name="customer_city" class="form-control" value="{$order.customer_city}" placeholder="Город" required/>
                                </td>
                            </tr>
                            <tr class="d-table-row">
                                <td class="d-md-table-cell">
                                    {$LANG.SHOP_CUSTOMER_ADDRESS}{if in_array("address", $cfg.ord_req)}
                                        <span style="color:red">*</span>
                                    {/if}
                                </td>
                                <td class="d-md-table-cell">
                                    <input type="text" id="customer_address" name="customer_address" class="form-control" value="{$order.customer_address}" placeholder="Улица, дом, квартира" required/>
                                </td>
                            </tr>
                            <tr class="d-table-row">
                                <td class="d-md-table-cell">
                                    {$LANG.SHOP_CUSTOMER_EMAIL} (не обязательно)
                                </td>
                                <td class="d-md-table-cell">
                                    <input type="email" id="customer_email" name="customer_email" class="form-control" value="{$order.customer_email}" placeholder="mail@mail.com"/>
                                </td>
                            </tr>

                            {*            {$delivery_types|@var_dump}*}

                        </table>
                    </div>
                </div>
            </div>
            <hr/>

            <div style="font-size:24px;line-height:32px;" >
                <strong>Стоимость доставки: </strong>
                <span>
                    <input id="sumDelivery" style="width: 100px; border: none;" type="text" name="price_delivery" value="{$sumDelivery}" readonly>
                </span>
                {$cfg.currency}
            </div>
            <div style="font-size:24px;line-height:32px;" >
                <strong>Стоимость покупки: </strong>
                <span>
                    <input id="totalsumm" style="width: 100px; border: none;" type="text"  value="{$totalsumm}" readonly>
                </span>
                {$cfg.currency}
            </div>
            <div class="pull-left result-clearfix" style="font-size:24px;line-height:32px;">
                <strong>К оплате:</strong>
                <span id="result">
                    <span>
                        <input id="resultsumm" style="width: 100px; border: none;" type="text" value="" readonly>
                    </span>
                    {$cfg.currency}
                </span>
            </div>

            <div class="pull-right">
                <a href="/shop/customer-form.html" class="btn btn-not-main">&larr; Назад</a>
                <input class="btn float-right"  type="submit" name="gopay" style="background: #ff9600; color: #ffffff; border-radius: 10px; font-weight: 400; outline: none;" value="Оформить заказ &rarr;"/>
                {*    <a type="submit" name="gopay" class="btn btn-main" href="shop/order_accept" >Оформить заказ &rarr; </a>*}
            </div>
            <div class="clearfix"></div>

        </form>
    {else}
        <p>{$LANG.SHOP_CART_EMPTY}</p>
        <p><a href="{$last_url}" class="btn btn-not-main">&larr; Назад в магазин</a></p>
    {/if}
</div>

{literal}
    <script>
        $(document).ready(function () {
            $('#d_type4').prop('checked', true);
            $('#d_type6').prop('checked', true);

            $('input#resultsumm').val(+$('input#totalsumm').val() + +$('input#sumDelivery').val());

            $('tr.delivery-tr').on('click', function (event) {
                let tdWithInputPrice = $(this).children('td').last();
                let input = $(tdWithInputPrice).find('input[name="price"]');
                $('input#sumDelivery').val($(input).val());
                $('input#resultsumm').val(0);
                $('input#resultsumm').val(+$('input#totalsumm').val() + +$('input#sumDelivery').val());
            })
        })
    </script>
{/literal}

