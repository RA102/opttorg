<?php
/*********************************************************************************************/
//																							 //
//                                InstantShop v1.0   (c) 2010                                //
//	 					  http://www.instantcms.ru/, r2@instantsoft.ru                       //
//                                                                                           //
// 						    written by Vladimir E. Obukhov, 2009-2010                        //
//                                                                                           //
/*********************************************************************************************/

function mod_inshop_front($mod, $cfg){

    $inCore     = cmsCore::getInstance();
    $inDB       = cmsDatabase::getInstance();
    $inPage     = cmsPage::getInstance();

    global $_LANG;

    $inCore->loadLanguage('components/shop');

    $inCore->loadModel('shop');
    $model = new cms_model_shop();

    $shop_cfg   = $inCore->loadComponentConfig('shop');

    if (!isset($cfg['autohide'])) { $cfg['autohide'] = 0; }
    if (!isset($cfg['show_hit_img'])) { $cfg['show_hit_img'] = 1; }
    if (!isset($cfg['show_title'])) { $cfg['show_title'] = 0; }
    if (!isset($cfg['cols'])) { $cfg['cols'] = 4; }
	if (!isset($cfg['cat_id'])) { $cfg['cat_id'] = 0; }

    $items = $model->getFrontItems($cfg['cat_id']);

    if (!$items && $cfg['autohide']) { return false; }

    $smarty = cmsPage::initTemplate('modules', 'mod_inshop_front.tpl');
    $smarty->assign('cfg', $cfg);
    $smarty->assign('shop_cfg', $shop_cfg);
    $smarty->assign('items', $items);
    $smarty->assign('items_count', sizeof($items));
    $smarty->display('mod_inshop_front.tpl');

    return true;

}

