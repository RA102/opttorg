<!--<form method="POST"-->
<!--      action="--><?php //echo $this->config['PAYMENT_URL']['value']; ?><!--"-->
<!--      id="robokassa_--><?php //echo $currency; ?><!--"-->
<!--      style="display:none"-->
<!--      class="psys"-->
<!-- > -->
<!--    <input type="hidden" name="MrchLogin" value="--><?php //echo $this->config['sMerchantLogin']['value']; ?><!--"/>-->
<!--    <input type="hidden" name="OutSum" value="--><?php //echo $this->order['summ']; ?><!--"/>-->
<!--    <input type="hidden" name="InvId" value="--><?php //echo $this->order['id']; ?><!--"/>-->
<!--    <input type="hidden" name="Desc" value="--><?php //echo str_replace('#', '', $this->order['description']); ?><!--"/>-->
<!--    <input type="hidden" name="SignatureValue" value="--><?php //echo $this->order['secret_key']; ?><!--"/>-->
<!--    <input type="hidden" name="Culture" value="--><?php //echo $this->config['sCulture']['value']; ?><!--"/>-->
<!--    <input type="button" value="--><?php //echo $_LANG['SHOP_CONTINUE']; ?><!--" onclick="$('form#robokassa_--><?php //echo $currency; ?>
<!--</form>-->


<script src="https://auth.robokassa.kz/Merchant/PaymentForm/FormMS.js?MerchantLogin=Sanmarket.kz&InvoiceID=<?php echo $inv_id; ?>&Culture=ru&Encoding=utf-8&OutSum=<?php echo $out_summ; ?>&SignatureValue=<?php echo $crc; ?>&test=<?php echo $IsTest; ?>"></script>



