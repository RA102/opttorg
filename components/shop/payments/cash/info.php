<?php

    if (!(defined('VALID_CMS') || defined('VALID_CMS_ADMIN'))){ die(); }

    $psinfo['title']    = 'Оплата наличными';
    $psinfo['url']      = '';
    $psinfo['logo']     = 'logo.gif';

    //Курсы валют платежной системы

    $pscfg['currency']['RUR']        = '1';

    //настройки по-умолчанию

