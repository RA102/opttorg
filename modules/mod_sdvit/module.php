<?php

function mod_sdvit($module_id, $cfg){ 

	$inCore = cmsCore::getInstance();
	$inDB   = cmsDatabase::getInstance();
	$inUser = cmsUser::getInstance();
	global $_LANG;  
	
    $inCore->loadModel('shop');
    $model = new cms_model_shop();		

	$default_cfg = array ( 
		'sd1'      	   => '',	
		'sd2'    	   => '',
		'sd3'    	   => '',
		'sd4'   	   => '',		
		'sd5'   	   => ''
	);
	
	$cfg = array_merge($default_cfg, $cfg);
	$sd1 = $model->getSdVit($cfg['sd1']);
	$sd2 = $model->getSdVit($cfg['sd2']);
	$sd3 = $model->getSdVit($cfg['sd3']);
	$sd4 = $model->getSdVit($cfg['sd4']);	
	$sd5 = $model->getSdVit($cfg['sd5']);
	
	cmsPage::initTemplate('modules', 'mod_sdvit')-> 
	assign('sd1', $sd1)->
	assign('sd2', $sd2)->
	assign('sd3', $sd3)->
	assign('sd4', $sd4)->		
	assign('sd5', $sd5)->	
	assign('cfg', $cfg)-> 	
	display('mod_sdvit.tpl'); 

	return true;
}

