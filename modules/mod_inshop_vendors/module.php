<?php
/*********************************************************************************************/
//																							 //
//                              InstantCMS v1.5   (c) 2009 FREEWARE                          //
//	 					  http://www.instantcms.ru/, info@instantcms.ru                      //
//                                                                                           //
// 						    written by Vladimir E. Obukhov, 2007-2009                        //
//                                                                                           //
/*********************************************************************************************/
	function mod_inshop_vendors($mod, $cfg){

        $inCore     = cmsCore::getInstance();
        $inDB       = cmsDatabase::getInstance();

        $inCore->loadModel('shop');
        $model = new cms_model_shop();

        $vendors = $model->getVendors();

        $current_id = 0;

        if ($_REQUEST['do']=='view_vendor'){
            $current_id = $inCore->request('vendor_id', 'int', 0);
        }

        $smarty = cmsPage::initTemplate('modules', 'mod_inshop_vendors.tpl');
        $smarty->assign('vendors', $vendors);
        $smarty->assign('current_id', $current_id);
        $smarty->display('mod_inshop_vendors.tpl');
	
		return true;
	
	}

?>