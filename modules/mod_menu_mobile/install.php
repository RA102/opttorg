<?php
    function info_module_mod_menu_mobile(){
        $_module['title']        = 'Mobile menu';
        $_module['name']         = 'mobile_menu';
        $_module['description']  = 'Мобильное меню';
        $_module['link']         = 'menu_mobile';
        $_module['position']     = 'top';
        $_module['author']       = 'ra';
        $_module['version']      = '1.0';
        $_module['config'] = [];
        return $_module;
    }
    function install_module_mod_menu_mobile()
    {
//        $core = cmsCore::getInstance();
//        $db = cmsDatabase::getInstance();
//
//        $query = "INSERT INTO cms_modules (`name` , `title` , `is_external` , `content` , `ordering` , `showtitle` , `published` , `user` , `config` , `original` , `css_prefix` , `allow_group` , `cache` , `cachetime` , `cacheint` )
//    VALUES ('Menu Mobile', 'Menu Mobile', '1', '1', '1', '1', 1, '', '1', '', '-1', '0', '1', '')";
//        $db->query($query);
        return true;
    }
    function upgrade_module_mod_menu_mobile()
    {
        return true;
    }
