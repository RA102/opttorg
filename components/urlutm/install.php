<?php

function info_component_urlutm(){

    //Описание компонента

    $_component['title']        = 'UTM';                        //название
    $_component['description']  = 'UTM ссылки в url';           //описание
    $_component['link']         = 'utm';                        //ссылка (идентификатор)
    $_component['author']       = 'RA';                         //автор
    $_component['internal']     = '1';                          //внутренний (только для админки)? 1-Да, 0-Нет
    $_component['version']      = '1.0';                        //текущая версия

    //Настройки по-умолчанию


    return $_component;

}

// ========================================================================== //

function install_component_urlutm(){

    $inCore     = cmsCore::getInstance();       //подключаем ядро
    $inDB       = cmsDatabase::getInstance();   //подключаем базу данных
    $inConf     = cmsConfig::getInstance();

    include($_SERVER['DOCUMENT_ROOT'].'/includes/dbimport.inc.php');

    dbRunSQL($_SERVER['DOCUMENT_ROOT'].'/components/urlutm/install.sql', $inConf->db_prefix);

    return true;

}

