<?php

function info_module_mod_order_call()
{
    $_module['title']        = 'Order call';
    $_module['name']         = 'Order call';
    $_module['description']  = 'Заказать обратный звонок';
    $_module['link']         = 'mod_order_call';
    $_module['position']     = 'header-top-left';
    $_module['author']       = 'RA';
    $_module['version']      = '1.0';
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
