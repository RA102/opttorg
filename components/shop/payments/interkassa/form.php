<form method="POST"
      action="<?php echo $this->config['PAYMENT_URL']['value']; ?>"
      id="interkassa_<?php echo $currency; ?>"
      style="display:none"
      class="psys"
      >
    <input type="hidden" name="ik_shop_id" value="<?php echo $this->config['ik_shop_id']['value']; ?>" />
    <input type="hidden" name="ik_payment_amount" value="<?php echo $this->summ; ?>" />
    <input type="hidden" name="ik_payment_id" value="<?php echo $this->order['id']; ?>" />
    <input type="hidden" name="ik_payment_desc" value="<?php echo str_replace('#', '', $this->order['description']); ?>" />
    <input type="hidden" name="ik_paysystem_alias" value="">
    <input type="button" value="<?php echo $_LANG['SHOP_CONTINUE']; ?>" onclick="$('form#interkassa_<?php echo $currency; ?>').submit()"/>
</form>
