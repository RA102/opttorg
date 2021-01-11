<?php

    if (!(defined('VALID_CMS') || defined('VALID_CMS_ADMIN'))){ die(); }

    $psinfo['title']    = 'Безналичный расчет';
    $psinfo['url']      = '';
    $psinfo['logo']     = 'logo.gif';

    //Курсы валют платежной системы

    $pscfg['currency']['RUR']        = '1';

    //настройки по-умолчанию

    $pscfg['BILL_SHOP']['title']        = 'Наименование получателя платежа';
    $pscfg['BILL_SHOP']['value']        = '';

    $pscfg['BILL_SHOP_ADDR']['title']   = 'Адрес получателя платежа';
    $pscfg['BILL_SHOP_ADDR']['value']   = '';

    $pscfg['BILL_SHOP_DIR']['title']     = 'Директор';
    $pscfg['BILL_SHOP_DIR']['value']     = '';

    $pscfg['BILL_SHOP_BUH']['title']     = 'Главный бухгалтер';
    $pscfg['BILL_SHOP_BUH']['value']     = '';

    $pscfg['BILL_SHOP_INN']['title']    = 'ИНН получателя платежа';
    $pscfg['BILL_SHOP_INN']['value']    = '';

    $pscfg['BILL_SHOP_KPP']['title']    = 'КПП получателя платежа';
    $pscfg['BILL_SHOP_KPP']['value']    = '';

    $pscfg['BILL_SHOP_ACC']['title']    = 'Счет получателя платежа';
    $pscfg['BILL_SHOP_ACC']['value']    = '';

    $pscfg['BILL_SHOP_BANK']['title']   = 'Наименование банка получателя';
    $pscfg['BILL_SHOP_BANK']['value']   = '';

    $pscfg['BILL_SHOP_BIK']['title']    = 'БИК';
    $pscfg['BILL_SHOP_BIK']['value']    = '';

    $pscfg['BILL_SHOP_KS']['title']     = 'Кор./сч.';
    $pscfg['BILL_SHOP_KS']['value']     = '';

    $pscfg['BILL_SHOP_NDS']['title']    = 'НДС, %';
    $pscfg['BILL_SHOP_NDS']['value']    = '18';

?>
