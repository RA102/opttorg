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
    //    $core = cmsCore::getInstance();
    //    $db = cmsDatabase::getInstance();
    //
    //    $query = "INSERT INTO `cms_modules` ( `id` , `position` , `name` , `title` , `is_external` , `content` , `ordering` , `showtitle` , `published` , `user` , `config` , `original` , `css_prefix` , `allow_group` , `cache` , `cachetime` , `cacheint` )
    //VALUES
    //('', 'cpMenu', 'Load Prices', 'Load Prices', '1', 'mod_load_prices', '1', '1', '1', '0', '', '1', '', '-1', '0', '1', 'HOUR')";
    //    $db->query($query);
        return true;
    }
    function upgrade_module_mod_load_prices()
    {
        return true;
    }
