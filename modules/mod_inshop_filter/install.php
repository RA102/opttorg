<?php

// ========================================================================== //

    function info_module_mod_inshop_filter(){

        //
        // Описание модуля
        //

        //Заголовок (на сайте)
        $_module['title']        = 'InstantShop: Фильтр';

        //Название (в админке)
        $_module['name']         = 'InstantShop: Фильтр';

        //описание
        $_module['description']  = 'Фильтр товаров InstantShop';
        
        //ссылка (идентификатор)
        $_module['link']         = 'mod_inshop_filter';
        
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

