<h1 class="con_heading"><span>{$LANG.SHOP_START_ORDER}</span></h1>
<script src="/templates/basic_free/js/jquery.maskedinput.min.js"></script>
<div style="background:#fff;padding:15px;margin-bottom:20px;">
    {if $items}
        <form id="mainFormDelivery" action="/shop/payment.html" method="post">
            <div class="row">
                <div class="d-none">
                    <h3 class="con_heading"><span>Товары в заказе</span></h3>
                    <div class="small">
                        {include file='com_inshop_cart_items.tpl'}
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    {if $delivery_types}
                        <h3 class="con_heading"><span>{$LANG.SHOP_DELIVERY_TYPE} *</span></h3>
                        <script type="text/javascript">
                            {literal}
                            function calcSumm(del_price) {
                                var result_summ = Number(del_price) + Number($("#totalsumm").val());
                                $("#resultsumm").html(result_summ);
                            }
                            {/literal}
                        </script>
                        <div class="table-responsive1 small">
                            <table cellpadding="0" cellspacing="0" border="0" class="d_table table table-bordered">
                                {foreach from=$delivery_types item=typeDelivery}
                                    <tr>
                                        <td width="30" class="" valign="middle">
                                            <input type="radio" id="d_type{$typeDelivery.id}" name="d_type" value="{$typeDelivery.id}" {if $d_type == $typeDelivery.id} checked="checked" {/if} />
                                        </td>
                                        <td class="">
                                            <span class="d_price pull-right">
                                            </span>
                                            <span class="d_type">
                                                <label for="d_type{$typeDelivery.id}">{$typeDelivery.title}</label>
                                            </span>
                                            <div></div>
                                        </td>
                                    </tr>

                                {/foreach}

{*                                <tr>*}
{*                                    <td width="30" class="btop">*}
{*                                        <input type="radio" id="d_type6" name="d_type" value="6" data-toggle="modal" data-target="#deliveryModal" {if $d_type==6}checked {/if}/>*}
{*                                    </td>*}
{*                                    <td class="btop">*}
{*                                        <span class="d_price pull-right">*}
{*                                            <span>Доставка по Казахстану</span>*}
{*                                            <a href="#" id="cost_delivery" class="text-warning stretched-link" data-toggle="modal" data-target="#deliveryModal">Стоимость доставки</a>*}
{*                                            <a id="cost_delivery" href="/dostavka.html" target="_blank">Cтоимость доставки</a>*}
{*                                        </span>*}
{*                                    </td>*}
{*                                </tr>*}
                            </table>
                        </div>
                    {/if}

{*                    <script type="text/javascript">*}
{*                        {literal}*}
{*                        $(document).ready(function() {*}
{*                            $(".d_table input:radio").eq(0).trigger("click");*}
{*                        });*}
{*                        {/literal}*}
{*                    </script>*}

                    <div class="small"></div>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <h3 class="con_heading"><span>{$LANG.SHOP_CUSTOMER_INFO}</span></h3>

                    <!-- {if !$user_id}
            <p>{$LANG.SHOP_REG_NOTICE}</p>

        {/if} -->
                    <div class="table-responsive1 small">
                        <table cellpadding="0" cellspacing="0" border="0" class="customer_info table table-bordered">
                            <tr>
                                <td width="30%">{$LANG.SHOP_CUSTOMER_NAME}{if in_array("name", $cfg.ord_req)}
                                        <span style="color:red">*</span>
                                    {/if} </td>
                                <td>
                                    <input type="text" id="customer_name" name="customer_name" class="form-control" value="{$order.customer_name}" placeholder="Как к Вам обращаться?" required/>
                                </td>
                            </tr>
                            <tr>
                                <td>{$LANG.SHOP_CUSTOMER_PHONE}{if in_array("phone", $cfg.ord_req)}
                                        <span style="color:red">*</span>
                                    {/if} </td>
                                <td>
                                    <input type="text" id="customer_phone" name="customer_phone" class="form-control" value="{$order.customer_phone}" placeholder="8 (ХХХ) ХХХ ХХ ХХ" required/>
                                </td>
                            </tr>
                            <tr>
                                <td>{$LANG.SHOP_CUSTOMER_ADDRESS}{if in_array("address", $cfg.ord_req)}
                                        <span style="color:red">*</span>
                                    {/if} </td>
                                <td>
                                    <input type="text" id="customer_address" name="customer_address" class="form-control" value="{$order.customer_address}" placeholder="Город, улица, дом, квартира" required/>
                                </td>
                            </tr>
                            <tr>
                                <td>{$LANG.SHOP_CUSTOMER_EMAIL} (не обязательно)</td>
                                <td>
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
                <span id="sumDelivery">{$sumDelivery}</span>
                {$cfg.currency}
                <input type="text" name="price_delivery" value="{$sumDelivery}" hidden>
            </div>
            <div style="font-size:24px;line-height:32px;" >
                <strong>Стоимость покупки: </strong>
                <span>{$totalsumm}</span>
                {$cfg.currency}
            </div>
            <div class="pull-left result-clearfix" style="font-size:24px;line-height:32px;">
                <strong>К оплате:</strong>
                <span id="result">
                    <span id="resultsumm">
                        {$totalsumm+$sumDelivery}
    {*                    {if !$order}*}
    {*                        {if $delivery_types}*}
    {*                            {$totalsumm+$delivery_types[0].price}*}
    {*                        {else}*}
    {*                            {$totalsumm}*}
    {*                        {/if}*}
    {*                    {else}*}
    {*                        {$order.summ}*}
    {*                    {/if}*}
                    </span>
                    {$cfg.currency}
                </span>
            </div>

            <div class="pull-right">
                <a href="/shop/cart.html" class="btn btn-not-main">&larr; Назад</a>
                <input type="submit" name="gopay" class="btn btn-main" value="Оформить заказ &rarr;"/>
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
    <script type="text/javascript">
        $(function() {
            //2. Получить элемент, к которому необходимо добавить маску
            $("#customer_phone").mask("8 (999) 999 99 99");
        });
    </script>
{/literal}


<!-- Modal -->
<div class="modal fade" id="deliveryModal" tabindex="-1" role="dialog" aria-labelledby="deliveryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deliveryModalLabel">Стоимость доставки</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formDelivery" method="post" action="/shop/order.html"  >
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <select name="city" class="selectpicker form-control" data-live-search="true" data-width="100%" data-container="body" data-size="10" title="Choose city..."></select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Посчитать</button>
                </div>
            </form>
        </div>
    </div>
</div>