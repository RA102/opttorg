<?php

function info_module_mod_fishman(){
    $_module['title']        = 'Stock fishman';
    $_module['name']         = 'stock fishman';
    $_module['description']  = 'Акция рыбак';
    $_module['link']         = 'mod_fishman';
    $_module['position']     = 'top';
    $_module['author']       = 'ra';
    $_module['version']      = '1.0';
    $_module['config'] = [];
    return $_module;
}
function install_module_mod_fishman()
{
//        $core = cmsCore::getInstance();
//        $db = cmsDatabase::getInstance();
//
//        $query = "INSERT INTO cms_modules (`name` , `title` , `is_external` , `content` , `ordering` , `showtitle` , `published` , `user` , `config` , `original` , `css_prefix` , `allow_group` , `cache` , `cachetime` , `cacheint` )
//    VALUES ('Menu Mobile', 'Menu Mobile', '1', '1', '1', '1', 1, '', '1', '', '-1', '0', '1', '')";
//        $db->query($query);
    return true;
}
function upgrade_module_mod_fishman()
{
    return true;
}
