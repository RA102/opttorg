<form method="POST"
      action="<?php echo $this->config['PAYMENT_URL']['value']; ?>"
      id="interkassa2_<?php echo $currency; ?>"
      style="display:none"
      class="psys"
      accept-charset="UTF-8"
      >
    <input type="hidden" name="ik_co_id" value="<?php echo $this->config['ik_co_id']['value']; ?>" />
    <input type="hidden" name="ik_am" value="<?php echo $this->order['summ']; ?>" />
    <input type="hidden" name="ik_pm_no" value="<?php echo $this->order['id']; ?>" />
    <input type="hidden" name="ik_desc" value="<?php echo str_replace('#', '', $this->order['description']); ?>" />
    <input type="button" value="<?php echo $_LANG['SHOP_CONTINUE']; ?>" onclick="$('form#interkassa2_<?php echo $currency; ?>').submit()"/>
</form>
