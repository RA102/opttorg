<?php
/*******************************************************************************/
//                         InstantCMS v 1.10.6                                 //
//                      http://www.instantcmsv1.ru/                            //
//                       module "Universal Marquee"                            //
//                         written by Tokarev                                  //
//                                                                             //
//                       LICENSED BY GNU/GPL v2                                //
//                                                                             //
/*******************************************************************************/

function mod_sdecor($module_id, $cfg){ 

	$inCore = cmsCore::getInstance();
	$inDB   = cmsDatabase::getInstance();
	$inUser = cmsUser::getInstance();
	
    $inCore->loadModel('shop');
    $model = new cms_model_shop();	
	
	global $_LANG;  

	$default_cfg = array ( 
		'sd_banner'        => '',
		'sd_link'          => '',
		'sd_title_1'       => 'Душевые кабины',
		'sd_tovar_1'   	   => '',			
		'sd_rubric_1'      => '',
		'sd_brand_1'       => '',
		'sd_title_2'       => 'Ванны',
		'sd_tovar_2'   	   => '',			
		'sd_rubric_2'      => '',
		'sd_brand_2'       => '',	
		'sd_title_3'       => 'Мебель для ванной',
		'sd_tovar_3'   	   => '',			
		'sd_rubric_3'      => '',
		'sd_brand_3'       => '',	
		'sd_title_4'       => 'Смесители',
		'sd_tovar_4'   	   => '',			
		'sd_rubric_4'      => '',
		'sd_brand_4'       => '',
		'sd_title_5'       => 'Аксессуары',
		'sd_tovar_5'   	   => '',			
		'sd_rubric_5'      => '',
		'sd_brand_5'       => '',
		'sd_title_6'       => 'Санфаянс',
		'sd_tovar_6'   	   => '',			
		'sd_rubric_6'      => '',
		'sd_brand_6'       => '',	
		'sd_title_7'       => 'Мойки',
		'sd_tovar_7'   	   => '',			
		'sd_rubric_7'      => '',
		'sd_brand_7'       => '',
		'sd_title_8'       => 'Полотенцесушители',
		'sd_tovar_8'   	   => '',			
		'sd_rubric_8'      => '',
		'sd_brand_8'       => '',
		'sd_title_9'       => 'Водонагреватели',
		'sd_tovar_9'   	   => '',			
		'sd_rubric_9'      => '',
		'sd_brand_9'       => '',	
		'sd_title_0'       => 'Ещё',
		'sd_tovar_0'   	   => '',			
		'sd_rubric_0'      => '',
		'sd_brand_0'       => '',
        'sd_title_10'       => '',
        'sd_tovar_10'      => '',
		'sd_rubric_10'     => '',
		'sd_brand_10'      => ''
	);
	
	$cfg = array_merge($default_cfg, $cfg);
	$sd_banner       = $cfg['sd_banner'];
	$sd_link         = $cfg['sd_link'];
	$sd_title_1      = $cfg['sd_title_1'];
	$sd_tovar_1      = $model->getSdTovar($cfg['sd_tovar_1']);
	$sd_rubric_1     = $model->getSdRubric($cfg['sd_rubric_1']);	
	$sd_brand_1      = $model->getSdBrand($cfg['sd_brand_1']);		
	$sd_title_2      = $cfg['sd_title_2'];
	$sd_tovar_2      = $model->getSdTovar($cfg['sd_tovar_2']);
	$sd_rubric_2     = $model->getSdRubric($cfg['sd_rubric_2']);	
	$sd_brand_2      = $model->getSdBrand($cfg['sd_brand_2']);	
	$sd_title_3      = $cfg['sd_title_3'];
	$sd_tovar_3      = $model->getSdTovar($cfg['sd_tovar_3']);
	$sd_rubric_3     = $model->getSdRubric($cfg['sd_rubric_3']);	
	$sd_brand_3      = $model->getSdBrand($cfg['sd_brand_3']);	
	$sd_title_4      = $cfg['sd_title_4'];
	$sd_tovar_4      = $model->getSdTovar($cfg['sd_tovar_4']);
	$sd_rubric_4     = $model->getSdRubric($cfg['sd_rubric_4']);	
	$sd_brand_4      = $model->getSdBrand($cfg['sd_brand_4']);
	$sd_title_5      = $cfg['sd_title_5'];
	$sd_tovar_5      = $model->getSdTovar($cfg['sd_tovar_5']);
	$sd_rubric_5     = $model->getSdRubric($cfg['sd_rubric_5']);	
	$sd_brand_5      = $model->getSdBrand($cfg['sd_brand_5']);	
	$sd_title_6      = $cfg['sd_title_6'];
	$sd_tovar_6      = $model->getSdTovar($cfg['sd_tovar_6']);
	$sd_rubric_6     = $model->getSdRubric($cfg['sd_rubric_6']);	
	$sd_brand_6      = $model->getSdBrand($cfg['sd_brand_6']);
	$sd_title_7      = $cfg['sd_title_7'];
	$sd_tovar_7      = $model->getSdTovar($cfg['sd_tovar_7']);
	$sd_rubric_7     = $model->getSdRubric($cfg['sd_rubric_7']);	
	$sd_brand_7      = $model->getSdBrand($cfg['sd_brand_7']);
	$sd_title_8      = $cfg['sd_title_8'];
	$sd_tovar_8      = $model->getSdTovar($cfg['sd_tovar_8']);
	$sd_rubric_8     = $model->getSdRubric($cfg['sd_rubric_8']);	
	$sd_brand_8      = $model->getSdBrand($cfg['sd_brand_8']);	
	$sd_title_9      = $cfg['sd_title_9'];
	$sd_tovar_9      = $model->getSdTovar($cfg['sd_tovar_9']);
	$sd_rubric_9     = $model->getSdRubric($cfg['sd_rubric_9']);	
	$sd_brand_9      = $model->getSdBrand($cfg['sd_brand_9']);
	$sd_title_0      = $cfg['sd_title_0'];
	$sd_tovar_0      = $model->getSdTovar($cfg['sd_tovar_0']);
	$sd_rubric_0     = $model->getSdRubric($cfg['sd_rubric_0']);	
	$sd_brand_0      = $model->getSdBrand($cfg['sd_brand_0']);
	$sd_title_10     = $cfg['sd_title_10'];
	$sd_tovar_10     = $model->getSdTovar($cfg['sd_tovar_10']);
	$sd_rubric_10     = $model->getSdRubric($cfg['sd_rubric_10']);
	$sd_brand_10     = $model->getSdBrand($cfg['sd_brand_10']);
	
	cmsPage::initTemplate('modules', 'mod_sdecor')-> 
	assign('sd_banner', $sd_banner)->
	assign('sd_link', $sd_link)->
	assign('sd_title_1', $sd_title_1)->
	assign('sd_tovar_1', $sd_tovar_1)->
	assign('sd_rubric_1', $sd_rubric_1)->		
	assign('sd_brand_1', $sd_brand_1)->		
	assign('sd_title_2', $sd_title_2)->
	assign('sd_tovar_2', $sd_tovar_2)->
	assign('sd_rubric_2', $sd_rubric_2)->		
	assign('sd_brand_2', $sd_brand_2)->		
	assign('sd_title_3', $sd_title_3)->
	assign('sd_tovar_3', $sd_tovar_3)->
	assign('sd_rubric_3', $sd_rubric_3)->		
	assign('sd_brand_3', $sd_brand_3)->
	assign('sd_title_4', $sd_title_4)->
	assign('sd_tovar_4', $sd_tovar_4)->
	assign('sd_rubric_4', $sd_rubric_4)->		
	assign('sd_brand_4', $sd_brand_4)->	
	assign('sd_title_5', $sd_title_5)->
	assign('sd_tovar_5', $sd_tovar_5)->
	assign('sd_rubric_5', $sd_rubric_5)->		
	assign('sd_brand_5', $sd_brand_5)->	
	assign('sd_title_6', $sd_title_6)->
	assign('sd_tovar_6', $sd_tovar_6)->
	assign('sd_rubric_6', $sd_rubric_6)->		
	assign('sd_brand_6', $sd_brand_6)->			
	assign('sd_title_7', $sd_title_7)->
	assign('sd_tovar_7', $sd_tovar_7)->
	assign('sd_rubric_7', $sd_rubric_7)->		
	assign('sd_brand_7', $sd_brand_7)->	
	assign('sd_title_8', $sd_title_8)->
	assign('sd_tovar_8', $sd_tovar_8)->
	assign('sd_rubric_8', $sd_rubric_8)->		
	assign('sd_brand_8', $sd_brand_8)->
	assign('sd_title_9', $sd_title_9)->
	assign('sd_tovar_9', $sd_tovar_9)->
	assign('sd_rubric_9', $sd_rubric_9)->		
	assign('sd_brand_9', $sd_brand_9)->
	assign('sd_title_0', $sd_title_0)->
	assign('sd_tovar_0', $sd_tovar_0)->
	assign('sd_rubric_0', $sd_rubric_0)->		
	assign('sd_brand_0', $sd_brand_0)->
    assign('sd_title_10', $sd_title_10)->
	assign('sd_tovar_10', $sd_tovar_10)->
	assign('sd_rubric_10', $sd_rubric_10)->
	assign('sd_brand_10', $sd_brand_10)->
	assign('cfg', $cfg)-> 	
	display('mod_sdecor.tpl'); 

	return true;
}

