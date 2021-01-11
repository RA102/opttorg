<?php

    if (!(defined('VALID_CMS') || defined('VALID_CMS_ADMIN'))){ die(); }

    $psinfo['title']    = 'Интеркасса 2.0';
    $psinfo['url']      = 'http://new.interkassa.com/';
    $psinfo['logo']     = 'logo.gif';

    //Курсы валют платежной системы

    $pscfg['currency']['RUR']           = '1';

    //настройки по-умолчанию

    $pscfg['ik_co_id']['title']   = 'Идентификатор кассы';
    $pscfg['ik_co_id']['value']   = '';

    $pscfg['ik_secret_key']['title']   = 'Секретный ключ';
    $pscfg['ik_secret_key']['value']   = '';

    $pscfg['PAYMENT_URL']['title']      = 'URL для отправки платежа';
    $pscfg['PAYMENT_URL']['value']      = 'https://sci.interkassa.com/';
