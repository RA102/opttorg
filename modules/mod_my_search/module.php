<?php


function mod_my_search($mod, $cfg)
{
    $inCore = cmsCore::getInstance();
    $inDb = cmsDatabase::getInstance();

    cmsCore::loadClass('render');
    cmsCore::loadModel('search');

    $render = new Layout();

    $model = cms_model_search::initModel();

    global $_LANG;
    if (!isset($cfg['show_title'])) {
        $cfg['show_title'] = 0;
    }
    if (!empty($_POST["referal"])) {
        $response = [];
        $userQuery = trim($_POST['referal']);
        $userQuery = stripslashes($userQuery);
        $userQuery = strip_tags($userQuery);
        $userQuery = htmlspecialchars($userQuery);

        // подсказка для поиска по артиклу
        $queryForArt = 'SELECT p.art_no, p.seolink, p.title FROM cms_shop_items as p WHERE (p.art_no LIKE :art AND p.published <> 0)';

        $response['art_no'] = $inDb->query($queryForArt);

        // подсказка для поиска по названию категории
        $queryForCategories = 'SELECT c.title, c.seolink FROM cms_shop_cats as c WHERE (c.published <> 0 AND c.title LIKE :title)';
        $response['categories'] = $inDb->query($queryForCategories);

        // подсказка для поиска по производителям
        $queryForVendors = 'SELECT v.title, v.id FROM cms_shop_vendors as v WHERE (v.published <> 0 AND v.title LIKE :vendor)';
        $response['vendors'] = $inDb->query($queryForVendors);

        // подсказка для поиска по названию товара
        $queryForItems = 'SELECT p.title, p.seolink FROM cms_shop_items as p WHERE (p.title LIKE :prod AND p.published <> 0) LIMIT 30';
        $response['items'] = $inDb->query($queryForItems);

    }

    $pathToView = PATH . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . TEMPLATE . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'search_my.php';

//    return $render->renderPhpFile($pathToView);
    cmsPage::initTemplate('modules',  $cfg['tpl'])->
        assign('path', PATH)->
        display( $cfg['tpl']);
    return true;
}

