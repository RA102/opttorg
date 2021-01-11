<?php
/*********************************************************************************************/
//																							 //
//                              InstantCMS v1.5   (c) 2009 FREEWARE                          //
//	 					  http://www.instantcms.ru/, info@instantcms.ru                      //
//                                                                                           //
// 						    written by Vladimir E. Obukhov, 2007-2009                        //
//                                                                                           //
/*********************************************************************************************/
	function mod_inshop_tree($mod, $cfg){

        $inCore     = cmsCore::getInstance();
        $inDB       = cmsDatabase::getInstance();

        $inCore->loadModel('shop');
        $model = new cms_model_shop();

        if (!$cfg['parent_id']){ $cfg['parent_id'] = 0; }

        $items = $model->getCategories(true, $cfg['parent_id']);

        $current_id = 0;

        if ($_REQUEST['do']=='view'){
            $seolink     = $inCore->request('seolink', 'str');
            if ($seolink){
                $current_cat = $model->getCategoryByLink($seolink);
                $current_id  = $current_cat['id'];
            }
        }

        if ($_REQUEST['do']=='item'){
            $seolink     = $inCore->request('seolink', 'str');
            if ($seolink){
                $item           = $model->getItemBySeolink($seolink);
                $current_id     = $item['category_id'];
            }
        }

        $smarty = cmsPage::initTemplate('modules', 'mod_inshop_tree.tpl');
        $smarty->assign('items', $items);
        $smarty->assign('last_level', -1);
        $smarty->assign('hide_parent', 0);
        $smarty->assign('current_id', $current_id);
        $smarty->assign('cfg', $cfg);
        $smarty->display('mod_inshop_tree.tpl');
	
		return true;
	
	}

