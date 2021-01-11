<?php
/*********************************************************************************************/
//																							 //
//                                InstantShop v1.0   (c) 2010                                //
//	 					  http://www.instantcms.ru/, r2@instantsoft.ru                       //
//                                                                                           //
// 						    written by Vladimir E. Obukhov, 2009-2010                        //
//                                                                                           //
/*********************************************************************************************/

function mod_inshop_cart($mod, $cfg){

    $inCore     = cmsCore::getInstance();
    $inDB       = cmsDatabase::getInstance();
    $inPage     = cmsPage::getInstance();

    global $_LANG;

    $inCore->loadModel('shop');
    $model = new cms_model_shop();

    $inCore->loadLanguage('components/shop');

    $shop_cfg   = $inCore->loadComponentConfig('shop');

    if (!isset($cfg['showtype'])) {  $cfg['showtype'] = 'list';  }
    if (!isset($cfg['showqty']))  {  $cfg['showqty']  = 1;       }
    if (!isset($cfg['autohide'])) {  $cfg['autohide'] = 0;       }

    $items = $model->getCartItems($cfg);

    if (!$items && $cfg['autohide']) { return false; }

    $totalsumm = 0;

    foreach($items as $item){
        $totalsumm += ($item['price'] * $item['cart_qty']);
    }

    $smarty = cmsPage::initTemplate('modules', 'mod_inshop_cart.tpl');
    $smarty->assign('cfg', $cfg);
    $smarty->assign('shop_cfg', $shop_cfg);
    $smarty->assign('items', $items);
    $smarty->assign('items_count', sizeof($items));
    $smarty->assign('totalsumm', round($totalsumm, 2));
    $smarty->display('mod_inshop_cart.tpl');

    return true;

}
?>
