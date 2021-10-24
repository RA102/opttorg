<?php

function info_component_sphinx(){

    $_component['title']        = 'SphinxSearch';              //название
    $_component['description']  = 'Spinx для InstantCMS';      //описание
    $_component['link']         = 'sphinx';                    //ссылка (идентификатор)
    $_component['author']       = 'RA';                        //автор
    $_component['internal']     = '0';                         //внутренний (только для админки)? 1-Да, 0-Нет
    $_component['version']      = '1.0.0';                     //текущая версия

    //Настройки по-умолчанию
    $_component['config'] = [
        'host'=> 'localhost',
        'port'=> 9206,
        'index'=> 'idx_items',
    ];

    return $_component;

}

function install_component_sphinx(){

    $inCore     = cmsCore::getInstance();       //подключаем ядро
    $inDB       = cmsDatabase::getInstance();   //подключаем базу данных
    $inConf     = cmsConfig::getInstance();

    return true;

}

function upgrade_component_sphinx(){

    return true;

}