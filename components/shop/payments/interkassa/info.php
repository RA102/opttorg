<?php

    if (!(defined('VALID_CMS') || defined('VALID_CMS_ADMIN'))){ die(); }

    $psinfo['title']    = 'Интеркасса';
    $psinfo['url']      = 'http://www.interkassa.com/';
    $psinfo['logo']     = 'logo.gif';

    //Курсы валют платежной системы

    $pscfg['currency']['RUR']           = '1';

    //настройки по-умолчанию

    $pscfg['ik_shop_id']['title']   = 'Идентификатор магазина';
    $pscfg['ik_shop_id']['value']   = '';

    $pscfg['ik_secret_key']['title']   = 'Секретный ключ';
    $pscfg['ik_secret_key']['value']   = '';

    $pscfg['PAYMENT_URL']['title']      = 'URL для отправки платежа';
    $pscfg['PAYMENT_URL']['value']      = 'http://www.interkassa.com/lib/payment.php';
