<?php

    if (!(defined('VALID_CMS') || defined('VALID_CMS_ADMIN'))){ die(); }

    $psinfo['title']    = 'WebMoney Transfer';
    $psinfo['url']      = 'http://www.webmoney.ru/';
    $psinfo['logo']     = 'logo.gif';

    //Курсы валют платежной системы

    $pscfg['currency']['WMR']        = '1';
    $pscfg['currency']['WMZ']        = '30';
    $pscfg['currency']['WME']        = '42';
    $pscfg['currency']['WMU']        = '0.9';
    $pscfg['currency']['WMB']        = '0.005';

    //настройки по-умолчанию

    $pscfg['LMI_PAYEE_PURSE_R']['title']   = 'Кошелек продавца (WMR)';
    $pscfg['LMI_PAYEE_PURSE_R']['value']   = '';

    $pscfg['LMI_PAYEE_PURSE_Z']['title']   = 'Кошелек продавца (WMZ)';
    $pscfg['LMI_PAYEE_PURSE_Z']['value']   = '';

    $pscfg['LMI_PAYEE_PURSE_E']['title']   = 'Кошелек продавца (WME)';
    $pscfg['LMI_PAYEE_PURSE_E']['value']   = '';

    $pscfg['LMI_PAYEE_PURSE_U']['title']   = 'Кошелек продавца (WMU)';
    $pscfg['LMI_PAYEE_PURSE_U']['value']   = '';

    $pscfg['SECRET_KEY']['title']          = 'Секретный ключ';
    $pscfg['SECRET_KEY']['value']          = substr(md5(time().date('h h s')), 0, 9);

    $pscfg['LMI_SIM_MODE']['title']        = 'Режим тестирования (0,1,2)'; // 2
    $pscfg['LMI_SIM_MODE']['value']        = '2';

    $pscfg['PAYMENT_URL']['title']         = 'URL для отправки платежа'; // https://merchant.webmoney.ru/lmi/payment.asp
    $pscfg['PAYMENT_URL']['value']         = 'https://merchant.webmoney.ru/lmi/payment.asp';

?>
