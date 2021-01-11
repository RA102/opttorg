<form method="POST"
      action="<?php echo $this->config['PAYMENT_URL']['value']; ?>"
      id="webmoney_<?php echo $currency; ?>"
      style="display:none"
      class="psys"
      >
    <input type="hidden" name="order_id" value="<?php echo $this->order['id']; ?>" />
    <input type="hidden" name="osk" value="<?php echo $this->order['secret_key']; ?>" />
    <input type="hidden" name="currency" value="<?php echo $currency; ?>" />
    <input type="hidden" name="client_sess_id" value="<?php echo session_id(); ?>" />
    <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="<?php echo $this->summ; ?>" />
    <input type="hidden" name="LMI_PAYMENT_DESC_BASE64" value="<?php echo base64_encode($this->order['description']); ?>" />
    <input type="hidden" name="LMI_PAYMENT_NO" value="<?php echo $this->order['id']; ?>" />
    <input type="hidden" name="LMI_PAYEE_PURSE" value="<?php echo $this->config['LMI_PAYEE_PURSE']['value']; ?>" />
    <input type="hidden" name="LMI_SIM_MODE" value="<?php echo $this->config['LMI_SIM_MODE']['value']; ?>" />
    <input type="submit" name="go_payment" value="<?php echo $_LANG['SHOP_CONTINUE']; ?>" />
</form>