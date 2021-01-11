<?php

$mrh_login = md5("Sanmarket.kz");
$mrh_pass1 = md5("DBOVf2w1XwBBGsxSF680");
$inv_id = 678678;
$inv_desc = "Товары для животных";
$out_summ = "100.00";
$IsTest = 1;
$crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1");
print "<html><script language=JavaScript " . "src='https://auth.robokassa.ru/Merchant/PaymentForm/FormMS.js?" .
    "MerchantLogin=$mrh_login&OutSum=$out_summ&InvoiceID=$inv_id" . "&Description=$inv_desc&SignatureValue=$crc&IsTest=$IsTest'></script></html>";
