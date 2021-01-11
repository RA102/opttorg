<!--
https://epay.kkb.kz/jsp/process/logon.jsp 
https://testpay.kkb.kz/jsp/process/logon.jsp
-->
<form
    style="display:none"
    class="psys"
    id="epaykz_<?php echo $currency; ?>"
    name="SendOrder"
    method="post"
    action="<?php echo $this->config['PAYMENT_URL']['value']; ?>">

    <input type="hidden" name="Signed_Order_B64" value="<?php echo $this->processRequest(); ?>">
    <input type="hidden" name="Language" value="rus"> <!-- язык формы оплаты rus/eng -->
    <input type="hidden" name="BackLink" value="<?php echo $this->config['BACK_LINK']['value']; ?>">
    <input type="hidden" name="PostLink" value="<?php echo $this->config['POST_LINK']['value']; ?>">
    <input type="hidden" name="FailurePostLink" value="https://moi.sanmarket.kz/test/err_postln.php">
    <input type="submit" name="GotoPay"  value="Продолжить →">
</form>