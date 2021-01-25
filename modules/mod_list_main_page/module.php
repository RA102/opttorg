<?php

function mod_list_main_page($module_id, $cfg)
{

    $inCore = cmsCore::getInstance();
    $inDB = cmsDatabase::getInstance();
    $inUser = cmsUser::getInstance();
    global $_LANG;

    if (!isset($cfg['show_title'])) {
        $cfg['show_title'] = 0;
    }

    $inCore->loadModel('shop');
    $model = new cms_model_shop();

    $items = $model->getCatalogItems($cfg);


    cmsPage::initTemplate('modules', 'mod_list_main_page')->
    assign('listItems', $items)->
    display('mod_list_main_page.tpl');

    return true;
}

