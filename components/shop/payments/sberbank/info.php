<?php

    if (!(defined('VALID_CMS') || defined('VALID_CMS_ADMIN'))){ die(); }

    $psinfo['title']    = 'СберБанк РФ';
    $psinfo['url']      = 'http://www.sbrf.ru/';
    $psinfo['logo']     = 'logo.gif';

    //Курсы валют платежной системы

    $pscfg['currency']['RUR']        = '1';

    //настройки по-умолчанию

    $pscfg['SBRF_SHOP']['title']        = 'Наименование получателя платежа';
    $pscfg['SBRF_SHOP']['value']        = '';

    $pscfg['SBRF_SHOP_INN']['title']    = 'ИНН получателя платежа';
    $pscfg['SBRF_SHOP_INN']['value']    = '';

    $pscfg['SBRF_SHOP_KPP']['title']    = 'КПП  получателя платежа';
    $pscfg['SBRF_SHOP_KPP']['value']    = '';

    $pscfg['SBRF_SHOP_ACC']['title']    = 'Счет получателя платежа';
    $pscfg['SBRF_SHOP_ACC']['value']    = '';

    $pscfg['SBRF_SHOP_BANK']['title']   = 'Наименование банка получателя';
    $pscfg['SBRF_SHOP_BANK']['value']   = '';

    $pscfg['SBRF_SHOP_BIK']['title']    = 'БИК';
    $pscfg['SBRF_SHOP_BIK']['value']    = '';

    $pscfg['SBRF_SHOP_KS']['title']     = 'Кор./сч.';
    $pscfg['SBRF_SHOP_KS']['value']     = '';

?>
