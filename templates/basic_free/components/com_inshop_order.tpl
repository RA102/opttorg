<h1 class="con_heading"><span>{$LANG.SHOP_START_ORDER}</span></h1>
<script src="/templates/basic_free/js/jquery.maskedinput.min.js"></script>
<script scr="/templates/basic_free/js/delivery.js"></script>
<div style="background:#fff;padding:15px;margin-bottom:20px;">
    {if $items}
        <form action="/shop/payment.html" method="post">
            <div class="row">
                <div class="col-md-4">
                    <h3 class="con_heading"><span>Товары в заказе</span></h3>
                    <div class="small">
                        {include file='com_inshop_cart_items.tpl'}
                    </div>
                </div>


                <div class="col-md-4">
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
                                {foreach key=num item=dtype from=$delivery_types}
                                    <tr>
                                        <td width="30" class="btop">
                                            <input type="radio" id="d_type{$num}" name="d_type" value="{$dtype.id}" onclick="calcSumm({$dtype.price});" {if !$order}{if $num==0}checked="checked" {/if}{else}{if $order.d_type==$dtype.id}checked="checked"{/if}{/if} />
                                        </td>
                                        <td class="btop">
                            <span class="d_price pull-right">
                                {if $dtype.price}{$dtype.price} {$cfg.currency}{else}{$LANG.SHOP_FREE}{/if}
                            </span>
                                            <span class="d_type"><label for="d_type{$num}">{$dtype.title}</label></span>
                                            <div>{$dtype.description}</div>
                                        </td>
                                    </tr>
                                {/foreach}
                                <tr>
                                    <td width="30" class="btop">
                                        <input type="radio" id="d_type100" name="d_type" value="100" onclick="calcSumm(0);" {if !$order}{if $num==0}checked="checked" {/if}{else}{if $order.d_type==100}checked="checked"{/if}{/if}/>
                                    </td>
                                    <td class="btop">
                                        <span class="d_price pull-right">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                                Стоимость доставки
                                            </button>
                                        </span>
                                        <span class="d_type"><label for="d_type100">Exline</label></span>

                                    </td>
                                </tr>
                                <tr>
                                    <td width="30" class="btop">
                                        <input type="radio" id="d_type100" name="d_type" value="100" onclick="calcSumm(0);" {if !$order}{if $num==0}checked="checked" {/if}{else}{if $order.d_type==100}checked="checked"{/if}{/if}/>
                                    </td>
                                    <td class="btop">
                            <span class="d_price pull-right">
                                <a href="/dostavka.html" target="_blank">примерная стоимость</a>
                            </span>
                                        <span class="d_type"><label for="d_type100">Доставка по Казахстану</label></span>

                                        <div>Доставка по Казахстану осуществляется сторонней компанией, поэтому, для выяснения точной стоимости, вам необходимо оформить заказ, а затем дождаться ответа нашего оператора.</div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    {/if}

                    <script type="text/javascript">
                        {literal}
                        $(document).ready(function () {
                            $(".d_table input:radio").eq(0).trigger("click");
                        });
                        {/literal}
                    </script>

                    <div class="small"></div>
                </div>
                <div class="col-md-4">
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
            <div class="pull-left result-clearfix" style="font-size:24px;line-height:32px;">
                <strong>К оплате:</strong>
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
    <script>
        $(function () {
            //2. Получить элемент, к которому необходимо добавить маску
            $("#customer_phone").mask("8 (999) 999 99 99");
        });

        console.log($('input[name=d_type]:checked').val());

    </script>
{/literal}



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" >
                    <input type="text" value="" />

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>