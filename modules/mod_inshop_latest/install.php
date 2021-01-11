<?php

// ========================================================================== //

    function info_module_mod_inshop_latest(){

        //
        // Описание модуля
        //

        //Заголовок (на сайте)
        $_module['title']        = 'InstantShop: Новые товары';

        //Название (в админке)
        $_module['name']         = 'InstantShop: Новые товары';

        //описание
        $_module['description']  = 'Показывает новые товары InstantShop';
        
        //ссылка (идентификатор)
        $_module['link']         = 'mod_inshop_latest';
        
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

    function install_module_mod_inshop_latest(){

        return true;

    }

// ========================================================================== //

    function upgrade_module_mod_inshop_latest(){

        return true;
        
    }

// ========================================================================== //

?>