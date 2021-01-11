<?php
/*********************************************************************************************/
//																							 //
//                              InstantCMS v1.5   (c) 2009 FREEWARE                          //
//	 					  http://www.instantcms.ru/, info@instantcms.ru                      //
//                                                                                           //
// 						    written by Vladimir E. Obukhov, 2007-2009                        //
//                                                                                           //
/*********************************************************************************************/
	
    function mod_inshop_filter($mod, $cfg){

        $inCore     = cmsCore::getInstance();
        $inDB       = cmsDatabase::getInstance();

        $inCore->loadModel('shop');
        $model = new cms_model_shop();

        $cfg = $inCore->loadComponentConfig('shop');

        if ($_REQUEST['do']=='view'){
            $seolink     = $inCore->request('seolink', 'str');
            if ($seolink){
                $root_cat = $model->getCategoryByLink($seolink);
            } else { return false; }
        } else { return false; }

// ------- получаем значения фильтров -----------------

        //получаем производителей для фильтра
        $vendors = $model->getCatVendors($root_cat['id']);

        //получаем хар-ки категории
        $chars = $model->getCatChars($root_cat['id']);

        $filter     = array();
        $filter_str = $_SESSION['shop_filters'][$root_cat['id']];

        if ($filter_str){ $filter = $model->parseFilterString($filter_str); }
        if ($inCore->inRequest('filter')) { $filter = $inCore->request('filter', 'array'); }

        $smarty = cmsPage::initTemplate('modules', 'mod_inshop_filter.tpl');
        $smarty->assign('filter', $filter);
		$smarty->assign('chars', $chars);
		$smarty->assign('vendors', $vendors);
        $smarty->assign('root_cat', $root_cat);
        $smarty->assign('cfg', $cfg);
        $smarty->display('mod_inshop_filter.tpl');
	
		return true;
	
	}

