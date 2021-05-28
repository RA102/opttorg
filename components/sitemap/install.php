<?php
/******************************************************************************/
//                              Карта Сайта v2.1                              //
//          Разработка Компонентов, Плагинов и Модулей для Instant CMS:       //
//                      instantcms-development@ds-soft.ru                     //
/******************************************************************************/

function info_component_sitemap(){
    return array(
        "title" => "Карта Сайта",
        "description" => "Создает для каждого компонента вашего сайта карту для индексации поисковиками.",
        "link" => "sitemap",
        "author" => '<a href="http://ds-soft.ru/" title="Перейти на сайт" target="_blank">DS-SOFT</a>',
        "internal" => "0",
        "version" => "2.1"
    );
}

function install_component_sitemap(){
    $inCore = cmsCore::getinstance();
    $inDB = cmsDatabase::getinstance();
    $inCore->loadClass("cron");
    if (!$inDB->get_field("cms_cron_jobs", "job_name='generateMap'", "id")){
        cmsCron::registerjob("generateMap", array( "interval" => 24, "component" => "sitemap", "model_method" => "generateMap", "comment" => "Генерирует карту сайта.", "custom_file" => "", "enabled" => 1, "class_name" => "", "class_method" => "" ) );
    }
    return true;
}
	
function upgrade_component_sitemap(){
    return true;
}

