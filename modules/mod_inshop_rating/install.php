<?php

// ========================================================================== //

    function info_module_mod_inshop_rating(){

        //
        // Описание модуля
        //

        //Заголовок (на сайте)
        $_module['title']        = 'InstantShop: Популярные товары';

        //Название (в админке)
        $_module['name']         = 'InstantShop: Популярные товары';

        //описание
        $_module['description']  = 'Показывает лучшие товары InstantShop по рейтингу';
        
        //ссылка (идентификатор)
        $_module['link']         = 'mod_inshop_rating';
        
        //позиция
        $_module['position']     = 'maintop';

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

    function install_module_mod_inshop_rating(){

        return true;

    }

// ========================================================================== //

    function upgrade_module_mod_inshop_rating(){

        return true;
        
    }

// ========================================================================== //

