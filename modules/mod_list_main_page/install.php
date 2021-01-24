<?php

function info_module_mod_list_main_page()
{
    $_module['title'] = 'Module list items on main page';
    $_module['name'] = 'List items on main page';
    $_module['description'] = 'Лист товаров на главную';
    $_module['link'] = 'mod_list_main_page';
    $_module['position'] = 'mainbottom';
    $_module['author'] = 'RA';
    $_module['version'] = '1.0';
    $_module['config'] = [];
    return $_module;
}

function install_module_mod_list_main_page()
{
    return true;
}

function upgrade_module_mod_list_mail_page()
{
    return true;
}
