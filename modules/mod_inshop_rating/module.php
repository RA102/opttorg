<?php
/*********************************************************************************************/
//																							 //
//                                InstantShop v1.9   (c) 2010                                //
//	 					  http://www.instantcms.ru/, r2@instantsoft.ru                       //
//                                                                                           //
// 						    written by Vladimir E. Obukhov, 2009-2010                        //
//                                                                                           //
/*********************************************************************************************/

function mod_inshop_rating($mod, $cfg){

    $inCore     = cmsCore::getInstance();
    $inDB       = cmsDatabase::getInstance();
    $inPage     = cmsPage::getInstance();

    global $_LANG;

    $inCore->loadLanguage('components/shop');

    $inCore->loadModel('shop');
    $model = new cms_model_shop();

    $shop_cfg   = $inCore->loadComponentConfig('shop');

    if (!isset($cfg['show_hit_img'])) { $cfg['show_hit_img'] = 1; }
    if (!isset($cfg['show_title'])) { $cfg['show_title'] = 0; }
    if (!isset($cfg['limit'])) { $cfg['limit'] = 12; }
    if (!isset($cfg['cols'])) { $cfg['cols'] = 4; }
	if (!isset($cfg['cat_id'])) { $cfg['cat_id'] = 0; }

    $model->groupBy('i.id');
    $model->orderBy('rating', 'DESC');
    $model->limitIs($cfg['limit']);

    if ($cfg['cat_id']) {
        $model->whereRecursiveCatIs($cfg['cat_id']);
    }
    
    $items = $model->getItems();

    $smarty = cmsPage::initTemplate('modules', 'mod_inshop_rating.tpl');
    $smarty->assign('cfg', $cfg);
    $smarty->assign('shop_cfg', $shop_cfg);
    $smarty->assign('items', $items);
    $smarty->assign('items_count', sizeof($items));
    $smarty->display('mod_inshop_rating.tpl');

    return true;

}
