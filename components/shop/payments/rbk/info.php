<?php

    if (!(defined('VALID_CMS') || defined('VALID_CMS_ADMIN'))){ die(); }

    $psinfo['title']    = 'RBKmoney';
    $psinfo['url']      = 'http://www.rbkmoney.ru/';
    $psinfo['logo']     = 'logo.gif';

    //Курсы валют платежной системы

    $pscfg['currency']['RUR']           = '1';

    //настройки по-умолчанию

    $pscfg['RBK_SHOP_ID']['title']   = 'ID сайта';
    $pscfg['RBK_SHOP_ID']['value']   = '';

    $pscfg['RBK_SECRET_KEY']['title']   = 'Секретное слово';
    $pscfg['RBK_SECRET_KEY']['value']   = '';

    $pscfg['RBK_SUCCESS_URL']['title']   = 'Страница в случае успешного платежа';
    $pscfg['RBK_SUCCESS_URL']['value']   = '';

    $pscfg['RBK_FAIL_URL']['title']   = 'Страница в случае не успешного платежа';
    $pscfg['RBK_FAIL_URL']['value']   = '';
