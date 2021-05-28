<?php

// ========================================================================== //

function info_module_mod_inshop_filter(){

    //
    // Описание модуля
    //

    //Заголовок (на сайте)
    $_module['title']        = 'Поиск ';

    //Название (в админке)
    $_module['name']         = 'RA: Поиск';

    //описание
    $_module['description']  = 'Поиск костомизированный';

    //ссылка (идентификатор)
    $_module['link']         = 'mod_ra_search';

    //позиция
    $_module['position']     = 'sidebar';

    //автор
    $_module['author']       = 'InstantSoft';

    //текущая версия
    $_module['version']      = '1.0';

    //
    // Настройки по-умолчанию
    //
    $_module['config'] = array();

    return $_module;

}

// ========================================================================== //

function install_module_mod_inshop_filter(){

    return true;

}

// ========================================================================== //

function upgrade_module_mod_inshop_filter(){

    return true;

}

// ========================================================================== //


