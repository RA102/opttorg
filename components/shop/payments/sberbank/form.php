<form method="POST"
      action="/shop/payment/sberbank.html"
      id="sberbank_RUR"
      style="display:none"
      class="psys"
      >
    <input type="hidden" name="order_id" value="<?php echo $this->order['id']; ?>" />
    <input type="hidden" name="osk" value="<?php echo $this->order['secret_key']; ?>" />
    <input type="hidden" name="currency" value="<?php echo $currency; ?>" />
    <input type="hidden" name="client_sess_id" value="<?php echo session_id(); ?>" />
    <input type="submit" name="go_payment" value="<?php echo $_LANG['SHOP_CONTINUE']; ?>" />
</form>