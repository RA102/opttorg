<?php
    function info_module_mod_load_prices(){
        $_module['title']        = 'Downloading price lists from suppliers';
        $_module['name']         = 'Downloading price lists from suppliers';
        $_module['description']  = 'Загрузка прайсов';
        $_module['link']         = 'mod_load_prices';
        $_module['position']     = 'cpMenu';
        $_module['author']       = 'ra';
        $_module['version']      = '1.0';
        $_module['config'] = [];
        return $_module;
    }
    function install_module_load_prices()
    {
        return true;
    }
    function upgrade_module_mod_load_prices()
    {
        return true;
    }
