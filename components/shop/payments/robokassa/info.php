<?php

    if (!(defined('VALID_CMS') || defined('VALID_CMS_ADMIN'))){ die(); }

    $psinfo['title']    = 'RoboKassa';
    $psinfo['url']      = 'https://auth.robokassa.kz/';
    $psinfo['logo']     = 'logo.gif';

    //Курсы валют платежной системы

    $pscfg['currency']['RUR']           = '1';

    //настройки по-умолчанию

    $pscfg['sMerchantLogin']['title']   = 'Логин продавца';
    $pscfg['sMerchantLogin']['value']   = 'Sanmarket.kz';

    $pscfg['sMerchantPass1']['title']   = 'Пароль #1';
    $pscfg['sMerchantPass1']['value']   = 'kppuLA2NdEQ22bV31IZj';

    $pscfg['sMerchantPass2']['title']   = 'Пароль #2';
    $pscfg['sMerchantPass2']['value']   = '';

    $pscfg['sCulture']['title']         = 'Язык интерфейса РобоКассы (en/ru)';
    $pscfg['sCulture']['value']         = 'ru';

    $pscfg['PAYMENT_URL']['title']      = 'URL для отправки платежа';
    $pscfg['PAYMENT_URL']['value']      = 'http://test.robokassa.ru/Index.aspx';


