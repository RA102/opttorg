<form method="post" class="psys" id="rbk_<?php echo $currency; ?>" style="display:none" action="https://rbkmoney.ru/acceptpurchase.aspx">

<select name="preference">
    <option value="inner">Оплата с кошелька RBK Money</option>
    <option value="bankCard">Банковская карта Visa/MasterCard</option>
    <option value="exchangers">Электронные платежные системы</option>
    <option value="prepaidcard">Предоплаченная карта RBK Money</option>
    <option value="transfers">Системы денежных переводов</option>
    <option value="terminals">Платёжные терминалы</option>
    <option value="bank">Банковский платёж</option>
    <option value="postRus">Почта России</option>
    <option value="atm">Банкоматы</option>
    <option value="yandex">Яндекс.Деньги</option>
    <option value="ibank">Интернет банкинг</option>
    <option value="euroset">Евросеть</option>
</select>

<input type="submit" value="Продолжить" name="button">

<input type="hidden" name="eshopId" value="<?php echo $this->config['RBK_SHOP_ID']['value']; ?>">
<input type="hidden" name="orderId" value="<?php echo $this->order['id']; ?>">
<input type="hidden" name="serviceName" value="3AKA3 N <?php echo $this->order['id']; ?>">
<input type="hidden" name="recipientAmount" value="<?php echo $this->order['summ']; ?>">
<input type="hidden" name="recipientCurrency" value="RUR">
<input type="hidden" name="user_email" value="<?php echo $this->order['customer_email']; ?>">
<input type="hidden" name="successUrl" value="<?php echo $this->config['RBK_SUCCESS_URL']['value']; ?>">
<input type="hidden" name="failUrl" value="<?php echo $this->config['RBK_FAIL_URL']['value']; ?>">

</form>